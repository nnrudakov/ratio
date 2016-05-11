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
     * Строка для прогресс-бара.
     *
     * @var string
     */
    private $progressFormat = "Дата: %s. ID: %d. Задача: %s. Действие: %s. Результат: %s\n";

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

            $this->progress($task);
        }

        return true;
    }

    /**
     * Вывод информации о выполнении.
     *
     * @param Task $task Задача.
     *
     * @throws yii\base\InvalidConfigException
     * @throws yii\base\InvalidParamException
     */
    private function progress(Task $task)
    {
        printf(
            $this->progressFormat,
            Yii::$app->formatter->asDatetime('now', 'dd.MM.yyyy HH:mm:ss'),
            $task->id,
            $task->task,
            $task->action,
            $task->getResultText()
        );
    }
}
