<?php

namespace app\models\Plp\Task;

use yii;
use yii\base\Object;
use yii\helpers\Json;
use app\models\Plp\Task;

/**
 * Базовый класс задач.
 *
 * @property string $method Вызываемый метод.
 *
 * @package    ratio
 * @author     Nikolaj Rudakov <nnrudakov@gmail.com>
 * @copyright  2016
 */
class BaseTask extends Object
{
    /**
     * Вызываемый метод.
     *
     * @var string
     */
    public $method;

    /**
     * Сообщение об успешном выполнении задачи.
     *
     * @var string
     */
    protected static $messageSuccess = 'Задача выполнена.';

    /**
     * Сообщение о неуспешном выполнении задачи.
     *
     * @var string
     */
    protected $messageFail = 'Задача невыполнена.';

    /**
     * Сообщение о невозможности выполнения задачи.
     *
     * @var string
     */
    protected $messageFatal = 'Задача не может быть выполнена.';

    /**
     * Запуск метода.
     *
     * Запускается метод, выполняющий задачу. В случае успешного выполнения записывает результат в БД через
     * переданную задачу. Если выполнение задачи было неудачным, то результат также пишется в БД со своими статусами.
     *
     * @param Task $task Задача в БД.
     *
     * @return bool
     *
     * @throws FatalException
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\base\InvalidParamException
     */
    public function run(Task $task)
    {
        if ($task->retries >= Yii::$app->params['retries']) {
            $this->messageFatal = 'Превышено количество попыток.';
            $task->setCantDone();
            $task->result = Json::encode(['type' => 'fail', 'message' => $this->messageFatal]);
            $task->save();
            throw new FatalException($this->messageFatal);
        }

        try {
            $result = $this->{$this->method}(json_decode($task->data, true));
            $task->setDone();
        } catch (UserException $e) {
            $result = ['type' => 'fail', 'message' => $e->getMessage()];
            $task->setUnDone();
        }

        $task->result = Json::encode($result);
        $task->save();

        return true;
    }
}
