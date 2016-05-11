<?php

namespace tests\codeception\unit;

use yii;
use Codeception\Specify;
use tests\codeception\fixtures\TaskFixture;
use app\models\Plp\Task;
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
     * @throws yii\base\InvalidConfigException
     * @throws yii\base\InvalidParamException
     */
    public function testSuccess()
    {
        $data = $this->tasks[0];
        $task = Task::findOne(['id' => $data['id']]);
        $executor = TaskFactory::build($task->task, $task->action);
        self::assertTrue($executor->run($task));
        $task = Task::findOne(['id' => $data['id']]);
        $result = json_decode($task->result, true);
        self::assertArrayHasKey('type', $result);
        self::assertSame($result['type'], 'success');
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
