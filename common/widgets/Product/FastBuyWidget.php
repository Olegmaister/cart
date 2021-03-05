<?php
namespace common\widgets\Product;

use common\services\customer\CustomerService;
use frontend\forms\product\FastForm;
use Yii;

use common\forms\customer\SignupForm;
use common\services\customer\SignupService;
use yii\base\Widget;


class FastBuyWidget extends Widget
{

    private $customerService;

    public function __construct(CustomerService $customerService,$config = [])
    {
        $this->customerService = $customerService;
        parent::__construct($config);
    }

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $customer = $this->customerService->getProfile();
        $form = new FastForm($customer);

        return $this->render('fast',[
            'model' => $form
        ]);
    }

}