<?php
namespace console\controllers;

use console\services\RbacService;
use yii\console\Controller;
use function globalFunction\functions\dd;

class RbacController extends Controller
{

    private $service;

    public function __construct(
        $id,
        $module,
        RbacService $service,
        $config = [])
    {
        $this->service = $service;
        parent::__construct($id, $module, $config);
    }


    public function actionIndex()
    {
        $this->service->getAdministrator();
    }
}