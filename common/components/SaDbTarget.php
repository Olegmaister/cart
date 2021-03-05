<?php

declare(strict_types=1);

namespace common\components;

use Yii;
use yii\helpers\Json;
use yii\log\DbTarget;

class SaDbTarget extends DbTarget
{
    public function export()
    {
        foreach ($this->messages as $message) {
            /** @var \Error $error */
            $error = $message[0];
            $data = [
                'message' => $error->getMessage(),
                'file' => $error->getFile(),
                'line' => $error->getLine(),
            ];
        }

        $sql = "
            INSERT INTO error_log (user_ip, user_agent, controller, action, data, code, url)
            VALUES (:IP, :USER_AGENT, :CONTROLLER, :ACTION, :DATA, :CODE, :URL)
        ";
        $command = Yii::$app->db->createCommand($sql);
        $command->bindValues([
            'IP' => Yii::$app->request->getUserIP(),
            'USER_AGENT' => Yii::$app->request->getUserAgent(),
            'CONTROLLER' => Yii::$app->controller->uniqueId,
            'ACTION' => Yii::$app->controller->module->requestedAction->id,
            'DATA' => Json::encode($data),
            'CODE' => $error->statusCode ?? 500,
            'URL' =>  Yii::$app->request->getAbsoluteUrl(),
        ])->execute();
    }
}
