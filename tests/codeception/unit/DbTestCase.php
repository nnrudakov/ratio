<?php

namespace tests\codeception\unit;

use yii\codeception\DbTestCase as BaseDbTestCase;

class DbTestCase extends BaseDbTestCase
{
    public $appConfig = '@tests/codeception/config/unit.php';
}
