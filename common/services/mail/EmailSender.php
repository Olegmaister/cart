<?php

namespace common\services\mail;

use backend\models\MailStocks;
use backend\models\PriceWatch;
use backend\models\Subscribe;
use common\api\NovaPoshta;
use common\entities\City;
use common\entities\Countries;
use common\entities\Customer;
use common\entities\Forms;
use common\entities\Order;
use common\entities\Order\Payment;
use common\entities\Settings\Settings;
use common\entities\SlugManager;
use common\entities\Status;
use common\helpers\LanguageHelper;
use common\helpers\order\StatusesHelper;
use common\helpers\ProductHelper;
use common\helpers\StringHelper;
use common\models\Mail;
use common\models\MailLanguage;
use common\repositories\CityRepository;
use common\services\api\NovaPoshtaService;
use common\services\BasicFormsService;
use frontend\components\ApiCurrency;
use frontend\repositories\ProductRepository;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

class EmailSender
{
    /** @var int Спасибо за заказ */
    public const THANK_NEW_ORDER_ID = 1;
    public const ADMIN_NEW_ORDER_ID = 11;
    public const THANK_NEW_ONE_CLICK_ORDER_ID = 2;
    public const ADMIN_NEW_ONE_CLICK_ORDER_ID = 10;
    public const THANK_NEW_RESERVE_ID = 3;
    public const ADMIN_NEW_RESERVE_ID = 12;
    public const NEW_FORM_ID = 4;
    public const NEW_FORM_ADMIN_ID = 5;
    public const NEW_USER_ID = 6;
    public const RESET_PASSWORD_ID = 7;
    public const NEW_ORDER_STATUS_ID = 13;
    public const CHANGE_PRODUCT_PRICE = 14;
    public const CONFIRM_EMAIL_ID = 15;
    public const PRODUCT_AVAILABILITY_ID = 16;
    public const STOCKS_ID = 17;
    public const NEWSLETTER_SUBSCRIPTION = 18;

    /** @var string */
    private $view;
    /** @var Mail */
    private $mailSettings;
    /** @var MailLanguage */
    private $mailLangData;
    /** @var array */
    private $mailData;
    /** @var string */
    private $sendTo;

    public function __construct()
    {
        Yii::$app->language = 'ua-UA';
    }

    /**
     * @param Order $order
     * @throws \yii\web\NotFoundHttpException
     */
    public function sendNewOrderEmail(Order $order): void
    {
        $this->sendTo = $order->email;

        $this->view = '@common/mail/new-order.php';
        $this->initEmailModel(self::THANK_NEW_ORDER_ID);
        $currencySymbol = '₴';
        $currencyCoefficient = 1;
        $total_cost = round($order->cost / $currencyCoefficient);
        $discount_value = round($order->stock_value / $currencyCoefficient);
        $delivery_cost = round($order->delivery_cost / $currencyCoefficient);

        if (isset($order->customer)) {
            Yii::$app->language = $order->customer->profile->language;
            $currencySymbol = $order->customer->profile->currency;
            $currency = ProductRepository::getCurrencyFromDb();

            if ($currencySymbol === ApiCurrency::EUR_SYMBOL) {
                $currencyCoefficient = $currency['EUR']['value'] ?? ApiCurrency::EUR_COEFFICIENT;
            }

            if ($currencySymbol === ApiCurrency::USD_SYMBOL) {
                $currencyCoefficient = $currency['EUR']['value'] ?? ApiCurrency::USD_COEFFICIENT;
            }

            if ($currencyCoefficient !== 1) {
                $total_cost =  (float)round($order->cost / $currencyCoefficient, 1);
                $discount_value =  (float)round($order->stock_value / $currencyCoefficient, 1);
                $delivery_cost =  (float)round($order->delivery_cost / $currencyCoefficient,1);
            }
        }

        $this->mailLangData = $this->mailSettings->getLanguageData(LanguageHelper::getIdByCode(Yii::$app->language));
        $this->mailLangData->title = str_replace('[CUSTOMER_FULL_NAME]', "$order->last_name $order->first_name", $this->mailLangData->title);

        $this->mailData = [
            'title' => $this->mailLangData->title,
            'additional_text' => $this->mailLangData->additional_text,
            'order_id' => $order->id,
            'order_status' => ArrayHelper::getValue(StatusesHelper::statusList(), $order->current_status),
            'total_cost' => $total_cost,
            'discount_value' => $discount_value,
            'delivery_cost' => $delivery_cost,
            'payment_type' => $order->payment->desc->name,
            'customer_name' => "$order->last_name $order->first_name",
            'phone' => $order->phone,
            'email' => $order->email,
            'comment' => $order->comment,
            'product_list' => $this->createProductList($order),
            'delivery' => $this->getDeliveryAddress($order),
            'order_number_hash' => md5($order->id),
            'is_invoice' => (int)$order->payment_id === Payment::PAYMENT_BY_NVOICE,
            'currencySymbol' => $currencySymbol,
        ];

        $this->send();
    }

    /**
     * @param Order $order
     * @throws NotFoundHttpException
     */
    public function sendOrderAdminEmail(Order $order): void
    {
        $this->view = '@common/mail/admin-mail.php';
        $this->initEmailModel(self::ADMIN_NEW_ORDER_ID);

        $this->sendTo = $this->mailSettings->mail_from;

        if (isset($order->customer)) {
            Yii::$app->language = $order->customer->profile->language;
        }

        $this->mailLangData = $this->mailSettings->getLanguageData(LanguageHelper::getIdByCode(Yii::$app->language));
        $this->mailLangData->title = str_replace('[ORDER_NUMBER]', $order->id, $this->mailLangData->title);
        $this->mailLangData->title = str_replace('[PRODUCT]', $this->createProductListAdmin($order), $this->mailLangData->title);
        $this->mailLangData->title = str_replace('[CUSTOMER_NAME]', "$order->first_name $order->last_name", $this->mailLangData->title);
        $this->mailLangData->title = str_replace('[CUSTOMER_PHONE]', $order->phone, $this->mailLangData->title);
        $this->mailLangData->title = str_replace('[CUSTOMER_EMAIL]', $order->email, $this->mailLangData->title);
        $this->mailLangData->title = str_replace('[CUSTOMER_DELIVERY]', $this->getDeliveryAddress($order), $this->mailLangData->title);

        $this->mailData = [
            'title' => $this->mailLangData->title,
        ];

        $this->send();
    }

    /**
     * @param Order $order
     * @throws \yii\web\NotFoundHttpException
     */
    public function sendNewOrderStatusEmail(Order $order): void
    {
        $this->sendTo = $order->email;

        if (!$this->sendTo) {
            return;
        }

        if (!$this->sendTo || (int)$order->current_status === Status::NEW || (int)$order->current_status === 0) {
            return;
        }

        $this->view = '@common/mail/order-status-change.php';
        $this->initEmailModel(self::NEW_ORDER_STATUS_ID);

        if (isset($order->customer)) {
            Yii::$app->language = $order->customer->profile->language;
        }

        $this->mailLangData = $this->mailSettings->getLanguageData(LanguageHelper::getIdByCode(Yii::$app->language));
        $this->mailLangData->title = str_replace('[CUSTOMER_FULL_NAME]', "$order->last_name $order->first_name", $this->mailLangData->title);
        $this->mailLangData->title = str_replace('[ORDER_NUMBER]', $order->id, $this->mailLangData->title);
        $this->mailLangData->title = str_replace('[ORDER_DATE]', $order->created_at, $this->mailLangData->title);

        $this->mailData = [
            'title' => $this->mailLangData->title,
            'order_status' => ArrayHelper::getValue(StatusesHelper::statusList(), $order->current_status),
        ];

        $this->send();
    }

    /**
     * @param Order $order
     * @throws \yii\web\NotFoundHttpException
     */
    public function sendNewFastOrderEmail(Order $order): void
    {
        $this->sendTo = $order->email;

        if (!$this->sendTo) {
            return;
        }

        $this->view = '@common/mail/new-fast-order.php';
        $this->initEmailModel(self::THANK_NEW_ONE_CLICK_ORDER_ID);
        $currencySymbol = '₴';
        $currencyCoefficient = 1;
        $total_cost = round($order->cost / $currencyCoefficient);
        $discount_value = round($order->stock_value / $currencyCoefficient);
        $delivery_cost = round($order->delivery_cost / $currencyCoefficient);

        if (isset($order->customer)) {
            Yii::$app->language = $order->customer->profile->language;
            $currencySymbol = $order->customer->profile->currency;
            $currency = ProductRepository::getCurrencyFromDb();

            if ($currencySymbol === ApiCurrency::EUR_SYMBOL) {
                $currencyCoefficient = $currency['EUR']['value'] ?? ApiCurrency::EUR_COEFFICIENT;
            }

            if ($currencySymbol === ApiCurrency::USD_SYMBOL) {
                $currencyCoefficient = $currency['EUR']['value'] ?? ApiCurrency::USD_COEFFICIENT;
            }

            if ($currencyCoefficient !== 1) {
                $total_cost =  (float)round($order->cost / $currencyCoefficient, 1);
                $discount_value =  (float)round($order->stock_value / $currencyCoefficient, 1);
                $delivery_cost =  (float)round($order->delivery_cost / $currencyCoefficient,1);
            }
        }

        $this->mailLangData = $this->mailSettings->getLanguageData(LanguageHelper::getIdByCode(Yii::$app->language));
        $this->mailLangData->title = str_replace('[CUSTOMER_FULL_NAME]', "$order->last_name $order->first_name", $this->mailLangData->title);

        $this->mailData = [
            'title' => $this->mailLangData->title,
            'additional_text' => $this->mailLangData->additional_text,
            'order_id' => $order->id,
            'order_status' => ArrayHelper::getValue(StatusesHelper::statusList(), $order->current_status),
            'total_cost' => $total_cost,
            'discount_value' => $discount_value,
            'delivery_cost' => $delivery_cost,
            'payment_type' => $order->payment->desc->name,
            'customer_name' => "$order->last_name $order->first_name",
            'phone' => $order->phone,
            'email' => $order->email,
            'comment' => $order->comment,
            'product_list' => $this->createProductList($order),
            'delivery' => $this->getDeliveryAddress($order),
            'currencySymbol' => $currencySymbol,
        ];

        $this->send();
    }

    /**
     * @param Order $order
     * @throws NotFoundHttpException
     */
    public function sendFastOrderAdminEmail(Order $order): void
    {
        $this->view = '@common/mail/admin-mail.php';
        $this->initEmailModel(self::ADMIN_NEW_ONE_CLICK_ORDER_ID);

        $this->sendTo = $this->mailSettings->mail_from;

        if (isset($order->customer)) {
            Yii::$app->language = $order->customer->profile->language;
        }

        $this->mailLangData = $this->mailSettings->getLanguageData(LanguageHelper::getIdByCode(Yii::$app->language));
        $this->mailLangData->title = str_replace('[ORDER_NUMBER]', $order->id, $this->mailLangData->title);
        $this->mailLangData->title = str_replace('[PRODUCT]', $this->createProductListAdmin($order), $this->mailLangData->title);
        $this->mailLangData->title = str_replace('[CUSTOMER_NAME]', "$order->first_name $order->last_name", $this->mailLangData->title);
        $this->mailLangData->title = str_replace('[CUSTOMER_PHONE]', $order->phone, $this->mailLangData->title);
        $this->mailLangData->title = str_replace('[CUSTOMER_EMAIL]', $order->email, $this->mailLangData->title);
        $this->mailLangData->title = str_replace('[CUSTOMER_DELIVERY]', $this->getDeliveryAddress($order), $this->mailLangData->title);

        $this->mailData = [
            'title' => $this->mailLangData->title,
        ];

        $this->send();
    }

    /**
     * @param string $userName
     * @param string $email
     * @param string $phone
     * @param string $password
     * @throws NotFoundHttpException
     */
    public function sendRegistrationEmail(string $userName, string $email, string $phone, string $password): void
    {
        $this->sendTo = $email;
        $this->view = '@common/mail/register.php';
        $this->initEmailModel(self::NEW_USER_ID);

        $customer = Customer::findOne(['email' => $email]);

        if ($customer) {
            Yii::$app->language = $customer->profile->language;
        }

        $this->mailLangData = $this->mailSettings->getLanguageData(LanguageHelper::getIdByCode(Yii::$app->language));
        $this->mailLangData->title = str_replace('[CUSTOMER_FULL_NAME]', $userName, $this->mailLangData->title);

        $this->mailData = [
            'title' => $this->mailLangData->title,
            'phone' => $phone,
            'email' => $email,
            'password' => $password,
        ];

        $this->send();
    }

    /**
     * @param Order $order
     * @throws \yii\web\NotFoundHttpException
     */
    public function sendNewReserveEmail(Order $order): void
    {
        $this->sendTo = $order->email;

        if (!$this->sendTo) {
            return;
        }

        $this->view = '@common/mail/reserve.php';
        $this->initEmailModel(self::THANK_NEW_RESERVE_ID);
        $currencySymbol = '₴';
        $currencyCoefficient = 1;
        $total_cost = round($order->cost / $currencyCoefficient);
        $discount_value = round($order->stock_value / $currencyCoefficient);
        $delivery_cost = round($order->delivery_cost / $currencyCoefficient);

        if (isset($order->customer)) {
            Yii::$app->language = $order->customer->profile->language;
            $currencySymbol = $order->customer->profile->currency;
            $currency = ProductRepository::getCurrencyFromDb();

            if ($currencySymbol === ApiCurrency::EUR_SYMBOL) {
                $currencyCoefficient = $currency['EUR']['value'] ?? ApiCurrency::EUR_COEFFICIENT;
            }

            if ($currencySymbol === ApiCurrency::USD_SYMBOL) {
                $currencyCoefficient = $currency['EUR']['value'] ?? ApiCurrency::USD_COEFFICIENT;
            }


            if ($currencyCoefficient !== 1) {
                $total_cost =  (float)round($order->cost / $currencyCoefficient, 1);
                $discount_value =  (float)round($order->stock_value / $currencyCoefficient, 1);
                $delivery_cost =  (float)round($order->delivery_cost / $currencyCoefficient,1);
            }
        }

        $this->mailLangData = $this->mailSettings->getLanguageData(LanguageHelper::getIdByCode(Yii::$app->language));
        $this->mailLangData->title = str_replace('[CUSTOMER_FULL_NAME]', "$order->last_name $order->first_name", $this->mailLangData->title);
        $this->mailLangData->title = str_replace('[SHOP_NAME]', $order->store->description->name, $this->mailLangData->title);
        $this->mailLangData->title = str_replace('[SHOP_CITY]', $order->store->description->city, $this->mailLangData->title);
        $this->mailLangData->title = str_replace('[SHOP_ADDRESS]', $order->store->description->address, $this->mailLangData->title);

        $this->mailData = [
            'title' => $this->mailLangData->title,
            'additional_text' => $this->mailLangData->additional_text,
            'order_id' => $order->id,
            'order_status' => ArrayHelper::getValue(StatusesHelper::statusList(), $order->current_status),
            'total_cost' => $total_cost,
            'discount_value' => $discount_value,
            'delivery_cost' => $delivery_cost,
            'payment_type' => $order->payment->desc->name,
            'customer_name' => "$order->last_name $order->first_name",
            'phone' => $order->phone,
            'email' => $order->email,
            'comment' => $order->comment,
            'product_list' => $this->createProductList($order),
            'shop_city' => $order->store->description->city,
            'shop_address' => $order->store->description->address,
            'currencySymbol' => $currencySymbol,
        ];

        $this->send();
    }

    /**
     * @param Order $order
     * @throws NotFoundHttpException
     */
    public function sendNewReserveAdminEmail(Order $order): void
    {
        $this->view = '@common/mail/admin-mail.php';
        $this->initEmailModel(self::ADMIN_NEW_RESERVE_ID);

        $this->sendTo = $this->mailSettings->mail_from;

        if (isset($order->customer)) {
            Yii::$app->language = $order->customer->profile->language;
        }

        $this->mailLangData = $this->mailSettings->getLanguageData(LanguageHelper::getIdByCode(Yii::$app->language));
        $this->mailLangData->title = str_replace('[ORDER_NUMBER]', $order->id, $this->mailLangData->title);
        $this->mailLangData->title = str_replace('[PRODUCT]', $this->createProductListAdmin($order), $this->mailLangData->title);
        $this->mailLangData->title = str_replace('[CUSTOMER_NAME]', "$order->first_name $order->last_name", $this->mailLangData->title);
        $this->mailLangData->title = str_replace('[CUSTOMER_PHONE]', $order->phone, $this->mailLangData->title);
        $this->mailLangData->title = str_replace('[CUSTOMER_EMAIL]', $order->email, $this->mailLangData->title);
        $this->mailLangData->title = str_replace('[CUSTOMER_DELIVERY]', $this->getDeliveryAddress($order), $this->mailLangData->title);

        $this->mailData = [
            'title' => $this->mailLangData->title,
        ];

        $this->send();
    }

    /**
     * @param Forms $form
     * @throws \yii\web\NotFoundHttpException
     */
    public function sendFormEmail(Forms $form): void
    {
        $this->sendTo = $form->user_email ?? Yii::$app->user->identity->email;

        if (!$this->sendTo) {
            return;
        }

        $this->view = '@common/mail/feedback.php';
        $this->initEmailModel(self::NEW_FORM_ID);

        $customer = Customer::findOne(['email' => $form->user_email]);

        if ($customer) {
            Yii::$app->language = $customer->profile->language;
        }

        $this->mailLangData = $this->mailSettings->getLanguageData(LanguageHelper::getIdByCode(Yii::$app->language));
        $this->mailLangData->title = str_replace('[CUSTOMER_NAME]', $form->user_name, $this->mailLangData->title);

        $this->mailData = [
            'title' => $this->mailLangData->title,
            'user_name' => $form->user_name,
            'user_email' => $this->sendTo,
            'user_phone' => $form->user_phone,
            'message' => $form->message,
        ];

        $this->send();
    }

    /**
     * @param Forms $form
     * @throws \yii\web\NotFoundHttpException
     */
    public function sendFormAdminEmail(Forms $form): void
    {
        $this->view = '@common/mail/admin-mail.php';
        $this->initEmailModel(self::NEW_FORM_ADMIN_ID);

        $this->sendTo = $this->mailSettings->mail_from;
        $this->mailLangData = $this->mailSettings->getLanguageData(LanguageHelper::UA_ID);
        $this->mailLangData->title = str_replace('[FORM_NAME]', BasicFormsService::getRusType($form->type), $this->mailLangData->title);
        $this->mailLangData->title = str_replace('[CUSTOMER_NAME]', $form->user_name, $this->mailLangData->title);
        $this->mailLangData->title = str_replace('[CUSTOMER_EMAIL]', $form->user_email, $this->mailLangData->title);
        $this->mailLangData->title = str_replace('[CUSTOMER_PHONE]', $form->user_phone, $this->mailLangData->title);
        $this->mailLangData->title = str_replace('[CUSTOMER_COMMENT]', $form->message, $this->mailLangData->title);

        $this->mailData = [
            'title' => $this->mailLangData->title,
        ];

        $this->send();
    }

    /**
     * @param Customer $customer
     * @throws NotFoundHttpException
     */
    public function sendResetPasswordEmail(Customer $customer): void
    {
        $this->sendTo = $customer->email;

        if (!$this->sendTo) {
            return;
        }

        $this->view = '@common/mail/password-reset-link.php';
        $this->initEmailModel(self::RESET_PASSWORD_ID);

        Yii::$app->language = $customer->profile->language;
        $resetLink = 'https://dev.p1gtac.com/'
            . LanguageHelper::getCurrent()
            . '/customer/reset/reset?token='
            . $customer->password_reset_token
        ;

        $this->mailLangData = $this->mailSettings->getLanguageData(LanguageHelper::getIdByCode(Yii::$app->language));
        $this->mailLangData->title = str_replace('[CUSTOMER_FULL_NAME]', $customer->fullName(), $this->mailLangData->title);
        $this->mailLangData->title = str_replace('[LINK]', $resetLink, $this->mailLangData->title);

        $this->mailData = [
            'title' => $this->mailLangData->title,
            'reset_lnk' => $resetLink,
        ];

        $this->send();
    }

    /**
     * @param string $email
     * @param int $code
     * @throws NotFoundHttpException
     */
    public function sendConfirmEmail(string $email, int $code): void
    {
        $this->sendTo = $email;

        $this->view = '@common/mail/confirm-email.php';
        $this->initEmailModel(self::CONFIRM_EMAIL_ID);

        $this->mailLangData = $this->mailSettings->getLanguageData(LanguageHelper::getIdByCode(Yii::$app->language));
        $this->mailLangData->title = str_replace('[CODE]', $code, $this->mailLangData->title);

        $this->mailData = [
            'title' => $this->mailLangData->title,
            'code' => $code,
        ];

        $this->send();
    }

    /**
     * @param PriceWatch $priceWatch
     * @throws NotFoundHttpException
     */
    public function sendChangeProductPriceEmail(PriceWatch $priceWatch): void
    {
        $this->sendTo = $priceWatch->email;

        if (!$this->sendTo) {
            return;
        }

        if ($priceWatch->customer) {
            Yii::$app->language = $priceWatch->customer->profile->language;
        }

        $this->view = '@common/mail/price-change.php';
        $this->initEmailModel(self::CHANGE_PRODUCT_PRICE);

        $customerName = $priceWatch->customer ? $priceWatch->customer->fullName() : '';
        $this->mailLangData = $this->mailSettings->getLanguageData(LanguageHelper::getIdByCode(Yii::$app->language));
        $this->mailLangData->title = str_replace('[CUSTOMER_FULL_NAME]', $customerName, $this->mailLangData->title);
        $currencySymbol = '₴';
        $currencyCoefficient = 1;
        $oldPrice =  round($priceWatch->price / $currencyCoefficient);
        $newPrice =  round($priceWatch->price_new / $currencyCoefficient);

        if (isset($priceWatch->customer)) {
            $currencySymbol = $priceWatch->customer->profile->currency;
            $currency = ProductRepository::getCurrencyFromDb();

            if ($currencySymbol === ApiCurrency::EUR_SYMBOL) {
                $currencyCoefficient = $currency['EUR']['value'] ?? ApiCurrency::EUR_COEFFICIENT;
            }

            if ($currencySymbol === ApiCurrency::USD_SYMBOL) {
                $currencyCoefficient = $currency['EUR']['value'] ?? ApiCurrency::USD_COEFFICIENT;
            }

            if ($currencyCoefficient !== 1) {
                $oldPrice =  (float)round($priceWatch->price / $currencyCoefficient, 1);
                $newPrice =  (float)round($priceWatch->price_new / $currencyCoefficient,1);
            }
        }

        $this->mailData = [
            'title' => $this->mailLangData->title,
            'product' => $priceWatch->product,
            'oldPrice' => $oldPrice,
            'newPrice' => $newPrice,
            'currencySymbol' => $currencySymbol,
        ];

        $this->send();
    }

    /**
     * @param Order $order
     * @return string
     */
    private function createProductList(Order $order): array
    {
        $data = [];

        $currencyCoefficient = 1;

        if (isset($order->customer)) {
            $currencySymbol = $order->customer->profile->currency;
            $currency = ProductRepository::getCurrencyFromDb();

            if ($currencySymbol === ApiCurrency::EUR_SYMBOL) {
                $currencyCoefficient = $currency['EUR']['value'] ?? ApiCurrency::EUR_COEFFICIENT;
            }

            if ($currencySymbol === ApiCurrency::USD_SYMBOL) {
                $currencyCoefficient = $currency['EUR']['value'] ?? ApiCurrency::USD_COEFFICIENT;
            }
        }

        foreach ($order->items as $key => $product) {
            $data[$key]['name'] = $product->product->description->name;
            $data[$key]['origin_price'] = (float)round($product->origin_price / $currencyCoefficient, 1);
            $data[$key]['discount_price'] = (float)round($product->price / $currencyCoefficient, 1);
            $data[$key]['product_color_image'] = $product->product_color_image;
            $data[$key]['product_image'] = ProductHelper::correctedImgPath($product->product->image);
            $data[$key]['quantity'] = $product->quantity;
            $data[$key]['option_name'] = $product->option_name;
            $data[$key]['link'] = 'https://dev.p1gtac.com'
                . LanguageHelper::langUrl((SlugManager::findOne(['id' => $product->product->product_id, 'controller' => 'products']))->keyword);
        }

        return $data;
    }

    /**
     * @param Subscribe $subscribe
     * @param MailStocks $mailStockModel
     * @throws NotFoundHttpException
     */
    public function sendStocksEmail(Subscribe $subscribe, MailStocks $mailStockModel): void
    {
        if (!filter_var($subscribe->email, FILTER_VALIDATE_EMAIL)) {
            return;
        }

        Yii::$app->language = 'ua-UA';

        if ($subscribe->customer) {
            Yii::$app->language = $subscribe->customer->profile->language;
        }

        $this->sendTo = $subscribe->email;
        $this->view = '@common/mail/stocks.php';
        $this->initEmailModel(self::STOCKS_ID);
        $this->mailLangData = $this->mailSettings->getLanguageData(LanguageHelper::getIdByCode(Yii::$app->language));
        $this->mailLangData->title = $mailStockModel->getTitle();


        $this->mailData = [
            'title' => $mailStockModel->getTitle(),
            'mailStockModel' => $mailStockModel,
        ];

        $this->send();
    }

    /**
     * @param Order $order
     * @return string
     */
    private function createProductListAdmin(Order $order): string
    {
        $html = '<div>';

        foreach ($order->items as $key => $product) {
            $link = 'https://dev.p1gtac.com/'
                . (SlugManager::findOne(['id' => $product->id, 'controller' => 'products']))->keyword;
            $html .= "<a href='$link'>$product->product_name</a>";
            $html .= '<br>';
        }

        $html .= '</div>';

        return $html;
    }

    private function getDeliveryAddress(Order $order): string
    {
        $delivery = (int)$order->delivery_method_id;
        $address = '';
        $address .= $this->getDeliveryName($order->delivery->id, LanguageHelper::getCurrentId());

        if ($delivery === Order::SELF_DELIVERY) {
            $address .= " " . Yii::t('app', 'Pick up from the store');
            $address .= " " . $order->store->description->name;
            $address .= " (" . Yii::t('app', 'Address:');
            $address .= " " . $order->store->description->city;
            $address .= " " . $order->store->description->address;
            $address .= ")";

            return $address;
        }

        if ($delivery === Order::OFFICE_NP) {
            $npService = (new NovaPoshtaService(new CityRepository, new NovaPoshta));
            $cityModel = City::find()->where(['id' => $order->delivery_city])->one();
            $branches = $npService->branches($order->delivery_city);
            $addressBranch = $branches[$order->delivery_branch] ?? '';
            $cityName = $cityModel->name ?? '';

            if (\Yii::$app->language === 'en-EN') {
                $addressBranch = StringHelper::cyrillic2translit($addressBranch);
                $cityName = StringHelper::cyrillic2translit($cityName);
            }

            $address .= " " . $cityName;
            $address .= " " . $addressBranch;

            return $address;
        }

        if ($delivery === Order::COURIER_NP) {
            $cityModel = City::find()->where(['id' => $order->delivery_city])->one();
            $address .= " $cityModel->name";
            $address .= " $order->delivery_street";
            $address .= " буд. $order->delivery_house";
            $address .= " кв. $order->delivery_apartment";

            return $address;
        }

        if ($delivery === Order::DELIVERY_URK_POCHTA) {
            $address .= " " . Countries::findOne($order->delivery_country)->name;
            $address .= " " . $order->delivery_city;
            $address .= " $order->delivery_index";
            $address .= " $order->delivery_street";
            $address .= " буд. $order->delivery_house";
            $address .= " кв. $order->delivery_apartment";

            return $address;
        }

        return $address;
    }

    private function send()
    {
        $message = Yii::$app->mailer->compose($this->view,
            [
                'data' => $this->mailData,
                'title' => $this->mailLangData->subject,
            ])
            ->setTo($this->sendTo)
            ->setFrom([$this->mailSettings->mail_from => $this->mailSettings->name_from])
            ->setSubject($this->mailLangData->subject);

        Yii::$app->mailer->send($message);
    }

    private function initEmailModel(int $id): void
    {
        $model = Mail::findOne($id);

        if (!$model) {
            throw new NotFoundHttpException('Шаблон письма не найден');
        }

        $this->mailSettings = $model;
    }

    public function sendAvailabilityProductEmail($product, $sendTo, $langId)
    {
        $this->view = '@common/mail/product-availability.php';
        $this->initEmailModel(self::PRODUCT_AVAILABILITY_ID);
        //$this->sendTo = $this->mailSettings->mail_from;
        $this->mailLangData = $this->mailSettings->getLanguageData($langId);
        $this->mailLangData->title = str_replace('[PRODUCT_LINK]', $product['link'], $this->mailLangData->title);
        $this->mailLangData->title = str_replace('[PRODUCT_NAME]', $product['name'], $this->mailLangData->title);

        $this->mailData = [
            'title' => $this->mailLangData->subject,
            'content' => $this->mailLangData->title,
            'image' => $product['image'],
            'oldPrice' => $product['price_old'], //round($priceWatch->price / $currencyCoefficient),
            'newPrice' => $product['price'], //round($priceWatch->price_new / $currencyCoefficient),
            'link' => $product['link'],
            'name' => $product['name'],
            //'currencySymbol' => $currencySymbol,
        ];

        $this->sendTo = $sendTo;

        $this->send();
    }

    private function getDeliveryName(int $id, int $languageId = LanguageHelper::DEFAULT_LANGUAGE_ID): string
    {
        if ($id === Order::SELF_DELIVERY) {
            if ($languageId === LanguageHelper::EN_ID) {
                return Settings::findOne(87)->value;
            }

            if ($languageId === LanguageHelper::UA_ID) {
                return Settings::findOne(89)->value;
            }

            return Settings::findOne(88)->value;
        }

        if ($id === Order::OFFICE_NP) {
            if ($languageId === LanguageHelper::EN_ID) {
                return Settings::findOne(81)->value;
            }

            if ($languageId === LanguageHelper::UA_ID) {
                return Settings::findOne(83)->value;
            }

            return Settings::findOne(82)->value;
        }

        if ($id === Order::COURIER_NP) {
            if ($languageId === LanguageHelper::EN_ID) {
                return Settings::findOne(100)->value;
            }

            if ($languageId === LanguageHelper::UA_ID) {
                return Settings::findOne(102)->value;
            }

            return Settings::findOne(101)->value;
        }

        if ($id === Order::DELIVERY_URK_POCHTA) {
            if ($languageId === LanguageHelper::EN_ID) {
                return Settings::findOne(40)->value;
            }

            if ($languageId === LanguageHelper::UA_ID) {
                return Settings::findOne(42)->value;
            }

            return Settings::findOne(41)->value;
        }

        return '';
    }
}
