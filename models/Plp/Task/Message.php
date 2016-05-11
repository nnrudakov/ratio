<?php

namespace app\models\Plp\Task;

/**
 * Класс задачи сообщений.
 *
 * @package    ratio
 * @author     Nikolaj Rudakov <nnrudakov@gmail.com>
 * @copyright  2016
 */
class Message extends BaseTask
{
    /**
     * Выполнение задачи.
     *
     * @param array $data Данные.
     *
     * @return array
     *
     * @throws UserException
     */
    public static function sms(array $data = [])
    {
        return ['type' => 'success', 'message' => 'Сообщение отправлено.'];
    }
}
