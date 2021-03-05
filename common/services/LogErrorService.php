<?php

namespace common\services;

use common\entities\LogErrors;

class LogErrorService
{
    public static function saveValidateToString($type, $message, $source)
    {
        $string = '';

        if(is_array($message)) {
            foreach ($message as $key => $element) {
                $string .= $key . ': ';
                $string .= implode('; ', $element);
                $string .= "\n <br>";
            }
        } else {
            $string = $message;
        }


        self::saveDB($type, $string, $source);
    }

    public static function saveDB($type, $message, $source)
    {
        $error = new LogErrors();
        $error->type = $type;
        $error->message = $message;
        $error->source = $source;
        $error->save();
    }
}