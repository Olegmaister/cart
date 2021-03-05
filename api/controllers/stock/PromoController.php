<?php
namespace api\controllers\stock;


use api\entities\Synchronize;
use api\forms\stock\PromoCreateForm;
use common\entities\SynchronizeStock;
use Yii;

use api\services\stock\StockPromoService;
use common\entities\Customer;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBasicAuth;
use yii\helpers\Json;
use yii\rest\Controller;

class PromoController extends Controller
{
    private $service;

    public function __construct(
        $id,
        $module,
        StockPromoService $service,
        $config = [])
    {
        $this->service = $service;
        parent::__construct($id, $module, $config);
    }

    public function __init()
    {
        parent::init();
        Yii::$app->user->enableSession = false;
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBasicAuth::class,
            'auth' => function($username, $password){
                if($user = Customer::find()->where(['username' => $username])->one()){
                    if($user->validatePassword($password) && $user->validatePassword1C()){
                        return $user;
                    }
                }
                return null;
            },
        ];

        $behaviors['access'] = [
            'class' => AccessControl::class,
            'rules' => [
                [
                    'allow' => true,
                    'roles' => ['@']
                ]
            ]
        ];

        return $behaviors;
    }

    public function actionCreate()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $input = Json::decode(Yii::$app->getRequest()->getRawBody());

        /*========save info========*/
        $synchronize = Synchronize::create(json_encode($input));
        $synchronize->save(false);
        /*========================*/

        Yii::$app->user->logout();

        $form = new PromoCreateForm();

        $form->loadForm($input);

        if($form->validate()){

            if($this->service->stockExists($form->api)){
                try {
                    $stock = $this->service->edit($form);
                    return [
                        'message' => 'success edit stock api : '.$stock->guid,
                        'id' => $stock->id
                    ];
                }catch (\DomainException $exception){
                    return [
                        'message' => $exception->getMessage()
                    ];
                }
            }
            try {
                //create new stock , type promo
                $stock = $this->service->create($form);
                return [
                    'message' => 'success create new stock type '.$stock->type,
                    'id' => $stock->id
                ];
            }catch (\DomainException $exception){
                return [
                    'message' => $exception->getMessage()
                ];
            }
        }else{
            return $form->errors;
        }
    }
}
