<?php

namespace app\commands;

use yii\console\Controller;

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
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionIndex($message = 'hello world')
    {
        echo $message . "\n";
    }
}
