<?php

namespace app\models\Plp\Task;

use yii\base\InvalidParamException;
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
     * Запуск метода.
     *
     * Запускается метод, выполняющий задачу. В случае успешного выполнения записывает результат в БД через
     * переданную задачу. Если выполнение задачи было неудачным, то результат также пишется в БД со своими статусами.
     *
     * @param Task $task Задача в БД.
     *
     * @return bool
     *
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\base\InvalidParamException
     */
    public function run(Task $task)
    {
        $result = $this->{$this->method}(json_decode($task->data, true));

        $task->result = Json::encode($result);
        $task->setDone();
        $task->save();

        return true;
    }
}
