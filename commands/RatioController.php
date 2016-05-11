<?php

namespace app\commands;

use yii;
use yii\console\Controller;
use app\models\Plp\Task;

/**
 * Обработчик задач.
 *
 * Берёт задачу из базы, выполняет нужный класс+метод, передав ему значение поля data (декодированное через json_decode).
 * Результат, возвращенный от метода записывается в БД в поле result (SON).
 * Отмечаеи задачу как выполненную.
 *
 * @author     Nikolaj Rudakov <nnrudakov@gmail.com>
 * @copyright  2016
 */
class RatioController extends Controller
{
    /**
     * Запуск обработчика фонового выполнения задач.
     *
     * @return integer
     *
     * @throws Task\FatalException
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\base\InvalidParamException
     */
    public function actionIndex()
    {
        while (true) {
            $this->doTasks();
        }

        return Controller::EXIT_CODE_NORMAL;
    }

    /**
     * Выполнение запроса задач и их выполнение.
     *
     * @throws Task\FatalException
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\base\InvalidParamException
     */
    private function doTasks()
    {
        $tasks = (new Task())->getNewTasks();
        /** @var Task $task */
        foreach ($tasks as $task) {
            /** @var Task\BaseTask $executor */
            try {
                $executor = Task\TaskFactory::build($task->task, $task->action);
                $executor->run($task);
            } catch (Task\FatalException $e) {
                Yii::error($e->getMessage(), 'app\models\Plp\Task\FatalException');
            }
        }

        return true;
    }
}
