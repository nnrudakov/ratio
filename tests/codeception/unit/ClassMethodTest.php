<?php

namespace tests\codeception\unit;

use yii;
use Codeception\Specify;
use app\models\Plp\Task\TaskFactory;
use app\models\Plp\Task\FatalException;

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
     * Проверка выброса исключения.
     *
     * @expectedException \app\models\Plp\Task\FatalException
     *
     * @throws FatalException
     * @throws \PHPUnit_Framework_Exception
     */
    public function testClassException()
    {
        TaskFactory::build('testclass', 'testmethod');
        $this->expectExceptionMessage('Класс для задачи "testclass" не существует.');
    }

    /**
     * Проверка инициализации класса.
     *
     * @throws FatalException
     */
    public function testClassExists()
    {
        TaskFactory::build('integration', 'process');
    }

    /**
     * Проверка существования метода.
     *
     * @expectedException \app\models\Plp\Task\FatalException
     *
     * @throws FatalException
     * @throws \PHPUnit_Framework_Exception
     */
    public function testMethodException()
    {
        TaskFactory::build('integration', 'testmethod');
        $this->expectExceptionMessage('Метод "testmethod" для задачи "testclass" не существует.');
    }
}
