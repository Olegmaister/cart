<?php

namespace frontend\widgets\ChatMessenger;

use yii\base\Widget;

class ChatMessenger extends Widget
{
    public function run()
    {
        return $this->render('chat-messenger');
    }
}
