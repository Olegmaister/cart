<?php
namespace common\entities;

use backend\models\Subscribe;
use backend\services\SubscribeService;
use common\entities\Customer\CustomerOrder;
use common\entities\Customer\Profile;
use common\entities\Customer\Segment;
use common\entities\Rbac\AuthAssignment;
use common\helpers\StringHelper;
use core\entities\Customer\Network;
use frontend\forms\customer\CustomerForm;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\rbac\Assignment;
use yii\web\IdentityInterface;
/**
 * Customer model
 *
 * @property integer $customer_id
 * @property integer $group_id
 * @property string $username
 * @property string $salt
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $verification_token
 * @property string $email
 * @property string $phone
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 * @property string $guid
 *
 * @property Assignment[] $assignments
 * @property Network[] $networks
 * @property Profile $profile
 * @property Segment $segment
 * @property Order[] $reserveOrders
 * @property string $type_id [char(36)]
 * @property int $accumulated_sales [int(11)]
 * @property Subscribe $mailing
 * @property string $type [varchar(255)]
 * @property int $segment_id [int(11)]
 */
class Customer extends ActiveRecord implements IdentityInterface
{

    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;

    const RETAIL = '19a5249c-86ee-11e9-80ca-005056807e63';

    const OPT = 1;

    public $role;

    public function afterFind()
    {
        if (isset($this->phone) && !empty($this->phone)) {
            $this->phone = '+' . $this->phone;
        }

        return parent::afterFind();
    }

    public function beforeSave($insert)
    {
        if(isset($this->phone) && !empty($this->phone)) {
            $this->phone = str_replace('+', '', $this->phone);
        }

        return parent::beforeSave($insert);
    }

    /**
     * @param string $username
     * @param string $email
     * @param string $phone
     * @param string $password
     * @return Customer
     */
    public static function signup(string $username, string $email, ?string $phone, string $password): self
    {
        $customer = new self();
        $customer->username = $username;
        $customer->email = $email;
        $customer->phone = $phone;
        //$customer->group_id = 1;
        $customer->salt = StringHelper::saltString();
        $customer->password = sha1($customer->salt . sha1($customer->salt . sha1($password)));
        $customer->created_at = time();
        $customer->status = self::STATUS_ACTIVE;

        if($email) {
            (new SubscribeService($email))
                ->setAllMail()
                ->save();
        }

        return $customer;
    }

    public function setNewPassword(string $password)
    {
        $this->salt = StringHelper::saltString();
        $this->password = sha1($this->salt . sha1($this->salt . sha1($password)));
    }


    public function attributeLabels()
    {
        return [
            'username' => 'Имя',
            'phone' => 'Телефон'
        ];
    }

    public function edit(string $email, string $phone)
    {
        $this->email = $email;
        $this->phone = $phone;
        $this->updated_at = time();
    }

    public function resetPassword($password): void
    {
        if (empty($this->password_reset_token)) {
            throw new \DomainException('Password resetting is not requested.');
        }

        $this->salt = StringHelper::saltString();
        $this->password = sha1($this->salt . sha1($this->salt . sha1($password)));
        $this->password_reset_token = null;
    }

    public function getNameSegment()
    {
        return $this->type;
    }

    /**
     * @$network - название соц.сети
     * @$identity - идентификатор в ней пользователя
     * @return Customer
     */
    public static function signupByNetwork($network, $identity): self
    {
        $customer = new self();
        $customer->created_at = time();
        $customer->status = self::STATUS_ACTIVE;
        $customer->networks = [Network::create($network,$identity)];

        return $customer;
    }

    public function assignProfileSignup($form)
    {
        $profile = Profile::create($form);
        $this->profile = $profile;
    }

    public function assignProfile(CustomerForm $form, Profile $profile)
    {
        $profile->edit($form);
        $this->profile = $profile;
    }

    public function editProfile(CustomerOrder $customerOrder)
    {
        $profile = $this->profile;
        $profile->editOrder($customerOrder);
        $this->profile = $profile;

    }

    public function assignProfileAccumulation($fundedCost, $presentPrice = 1)
    {
        $profile = $this->profile;

        $profile->setAccumulationSystem($fundedCost, $presentPrice);
        $this->profile = $profile;

    }

    public function attachNetwork(string $network, string $identity)
    {
        //получает из связи все networks пользователя
        $networks = $this->networks;
        //проходит по каждой
        foreach ($networks as $network) {
            //если текущая равна, тому, что передал пользователь
            //бросаем исключение, что такая соц.сеть
            //уже привязана
            if($network->isFor($network,$identity)){
                throw new \DomainException('Network is already attached.');
            }
        }

        //привязываем новую соц.сеть
        $networks[] = Network::create($network, $identity);
        //добавляем в связь
        $this->networks = $networks;
    }

    public function fullName()
    {
        if(isset($this->profile)){
            return $this->profile->last_name.' '. $this->profile->first_name;
        }

    }

    public function getProfileName()
    {
        return isset($this->profile->first_name) ? $this->profile->first_name : $this->username;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%customers}}';
    }


    public function requestPasswordReset(): void
    {
        if (!empty($this->password_reset_token) && self::isPasswordResetTokenValid($this->password_reset_token)) {
            throw new \DomainException('Password resetting is already requested.');
        }
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }


    public function getAccumulatedSales()
    {
        return $this->accumulated_sales;
    }

    /*
     * проверка на пустоту guid
     * **/
    public function checkNotEmptyGuid()
    {
        return (isset($this->guid) && !empty($this->guid));
    }

    public function isOpt()
    {

    }

    /**
     *
     * */
    public function isRetail() : bool
    {
       return $this->type_id === self::RETAIL || $this->type_id == null;
    }



    public function existsSegmentId()
    {
        if(!isset($this->segment) || !isset($this->segment->id))
            return false;

        return $this->segment->id;
    }


    public function behaviors()
    {
        return[
            TimestampBehavior::class,
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => [
                    'assignments',
                    'networks',
                    'profile'
                ],
            ],
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }


    public function revokeAssignments()
    {
        $this->assignments = [];
    }

    public function getRoleDescription()
    {
        return AuthAssignment::getRoleDescription($this->customer_id);

    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($customer_id)
    {
        return static::findOne(['customer_id' => $customer_id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    public static function findByVerificationToken($token) {
        return static::findOne([
            'verification_token' => $token,
            'status' => self::STATUS_INACTIVE
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {

        if($this->password == sha1($this->salt . sha1($this->salt . sha1($password)))){
            return true;
        }else{
            return false;
        }

    }

    public function validatePassword1C()
    {
        return $this->password === '986acef77aea4048c99f2928601b23fd04600e1f';
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Generates new token for email verification
     */
    public function generateEmailVerificationToken()
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    ######### relations ###########
    public function getAssignments()
    {
        return $this->hasMany(AuthAssignment::class, ['user_id' => 'customer_id']);
    }
    public function getAdministrators()
    {
        return $this->hasMany(AuthAssignment::class, ['user_id' => 'customer_id']);
    }

    public function getNetworks() : ActiveQuery
    {
        return $this->hasMany(Network::class, ['user_id' => 'id']);
    }

    public function getProfile() : ActiveQuery
    {
        return $this->hasOne(Profile::class, ['customer_id' => 'customer_id']);
    }

    public function getSegment() : ActiveQuery
    {
        return $this->hasOne(Segment::class, ['id' => 'segment_id']);
    }

    /**
     * @return string
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function getReserveOrders()
    {
        return $this->hasMany(Order::class, ['customer_id' => 'customer_id'])
            ->where(['orders.delivery_method_id' => 4])
            ->orderBy(['orders.created_at' => SORT_DESC])
        ;
    }

    public function getMailing()
    {
        return $this->hasOne(Subscribe::class, ['email' => 'email']);
    }

    /**
     * @return string
     */
    public function getGuid(): string
    {
        return $this->guid;
    }
}
