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
        self::assertEquals($task->status, Task::STATUS_DONE);
        self::assertNotEmpty($task->finished);
    }

    /**
     * Проверка записи неуспешного выполнения задачи.
     *
     * @throws FatalException
     * @throws yii\base\InvalidConfigException
     * @throws yii\base\InvalidParamException
     */
    public function testFail()
    {
        $data = $this->tasks[3];
        $task = Task::findOne(['id' => $data['id']]);
        $data = json_decode($task->data, true);
        unset($data['integration_id']);
        $task->data = json_encode($data);
        $executor = TaskFactory::build($task->task, $task->action);
        self::assertTrue($executor->run($task));
        $task = Task::findOne(['id' => $task->id]);
        $result = json_decode($task->result, true);
        self::assertArrayHasKey('type', $result);
        self::assertSame($result['type'], 'fail');
        self::assertEquals($task->status, Task::STATUS_UNDONE);
        self::assertEmpty($task->finished);
        self::assertNotEmpty($task->deffer);
        self::assertGreaterThan(0, $task->retries);
    }

    /**
     * Проверка количества повторного запуска задачи.
     *
     * @expectedException \app\models\Plp\Task\FatalException
     *
     * @throws FatalException
     * @throws yii\base\InvalidConfigException
     * @throws yii\base\InvalidParamException
     * @throws \PHPUnit_Framework_Exception
     */
    public function testCount()
    {
        $data = $this->tasks[4];
        $task = Task::findOne(['id' => $data['id']]);
        $task->setUnDone();
        $task->retries = 3;
        $executor = TaskFactory::build($task->task, $task->action);
        $executor->run($task);
        $this->expectExceptionMessage('Превышено количество попыток.');
        $task = Task::findOne(['id' => $task->id]);
        $result = json_decode($task->result, true);
        self::assertArrayHasKey('type', $result);
        self::assertSame($result['type'], 'fail');
        self::assertEquals($task->status, Task::STATUS_CANTDONE);
        self::assertEmpty($task->finished);
        self::assertNotEmpty($task->deffer);
        self::assertGreaterThan(0, $task->retries);
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
