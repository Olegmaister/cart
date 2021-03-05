<?php
namespace common\bootstrap;

use backend\services\order\CartOrder;
use backend\services\order\cost\calculator\SimpleCalculator;
use backend\services\order\storage\HybridStorage;
use common\repositories\CartItemRepository;
use common\repositories\Order\FundedCustomerRepository;
use common\repositories\Order\StockCustomerRepository;
use common\repositories\Order\StockRepository;
use common\repositories\ProductRepository;
use common\services\stock\SegmentService;
use console\services\RbacService;
use common\services\rbac\AdministratorService;
use core\services\cart\cost\calculator\DynamicCalculator;
use core\services\cart\cost\calculator\DiscountCalculator;
use core\services\cart\DiscountService;
use core\services\cart\storage\DbStorage;
use core\services\cart\storage\SessionStorage;
use core\services\cart\Cart;
use yii\base\BootstrapInterface;
use yii\mail\MailerInterface;
class SetUp implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $container = \Yii::$container;

        $container->setSingleton(MailerInterface::class,function () use ($app){
            return $app->mailer;
        });

        $container->set(RbacService::class,[],[
            $app->authManager
        ]);

        $container->set(AdministratorService::class,[],[
            $app->authManager
        ]);

        $container->setSingleton(Cart::class, function () use ($app) {
            if($app->user->isGuest)
            {
                return new Cart(
                    new SessionStorage('cart'),
                    new DynamicCalculator(new DiscountCalculator(new DiscountService(
                        new StockRepository(),
                        new ProductRepository(),
                        new StockCustomerRepository(),
                        new FundedCustomerRepository(),
                        new SegmentService()
                    )))
                );
            }else{
                return new Cart(
                    new DbStorage($app->user->id, $app->db,'cart',
                    new CartItemRepository()),
                    new DynamicCalculator(new DiscountCalculator(new DiscountService(
                        new StockRepository(),
                        new ProductRepository(),
                        new StockCustomerRepository(),
                        new FundedCustomerRepository(),
                        new SegmentService()
                    )))
                );
            }
        });

        $container->setSingleton(CartOrder::class, function () use ($app){
           return new CartOrder(
                new HybridStorage($app->db),
                new SimpleCalculator()
           );
        });

    }

}
