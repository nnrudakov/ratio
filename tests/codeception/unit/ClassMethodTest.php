<?php

namespace tests\codeception\backend\unit\models;

use yii;
use Codeception\Specify;
use tests\codeception\unit\DbTestCase;
use tests\codeception\fixtures\TaskFixture;

/**
 * Class ClassMethodTest
 *
 * @property array $task
 *
 * @package tests\codeception\unit
 */
class ClassMethodTest extends DbTestCase
{
    /**
     * Test class exception.
     */
    public function testClassException()
    {
        $this->assertTrue(false);
    }

    /**
     * Test method exception.
     */
    public function testMethodException()
    {
        $this->assertTrue(false);
    }

    /**
     * @inheritdoc
     */
    public function fixtures()
    {
        return [
            'task' => [
                'class' => TaskFixture::className(),
                'dataFile' => '@tests/codeception/fixtures/data/task.php'
            ]
        ];
    }
}
