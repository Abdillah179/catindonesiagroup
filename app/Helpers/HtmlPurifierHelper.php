<?php

namespace App\Helpers;

use \HTMLPurifier;
use \HTMLPurifier_Config;

class HtmlPurifierHelper
{
    public static function clean($dirty_html)
    {
        $config = HTMLPurifier_Config::createDefault();
        $purifier = new HTMLPurifier($config);
        return $purifier->purify($dirty_html);
    }
}