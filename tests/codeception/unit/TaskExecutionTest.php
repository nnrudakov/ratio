<?php

namespace tests\codeception\unit;

use app\models\Plp\Task;
use yii;
use Codeception\Specify;
use tests\codeception\fixtures\TaskFixture;
use app\models\Plp\Task\TaskFactory;
use app\models\Plp\Task\FatalException;

/**
 * Class TaskExecutionTest
 *
 * @property array $tasks
 *
 * @package tests\codeception\unit
 */
class TaskExecutionTest extends DbTestCase
{
    /**
     * Проверка записи результата задачи в БД.
     */
    public function testTaskSave()
    {
        $data = $this->tasks[0];
        $task = Task::findOne(['id' => $data['id']]);
        self::assertTrue($task->save());
    }

    /**
     * Проверка записи успешного выполнения задачи.
     *
     * @throws FatalException
     */
    public function testSuccess()
    {
        self::assertTrue(false);
    }

    /**
     * Проверка записи неуспешного выполнения задачи.
     *
     * @throws FatalException
     */
    public function testFail()
    {
        self::assertTrue(false);
    }

    /**
     * Проверка количества повторного запуска задачи.
     *
     * @expectedException \app\models\Plp\Task\FatalException
     *
     * @throws FatalException
     */
    public function testCount()
    {
        self::assertTrue(false);
    }

    /**
     * @inheritdoc
     */
    public function fixtures()
    {
        return [
            'tasks' => [
                'class' => TaskFixture::className(),
                'dataFile' => '@tests/codeception/fixtures/data/task.php'
            ]
        ];
    }
}
