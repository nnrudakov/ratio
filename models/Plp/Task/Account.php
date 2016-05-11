<?php

namespace app\models\Plp\Task;

/**
 * Класс задачи учётных записей.
 *
 * @package    ratio
 * @author     Nikolaj Rudakov <nnrudakov@gmail.com>
 * @copyright  2016
 */
class Account extends BaseTask
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
    public static function bill(array $data = [])
    {
        return ['type' => 'success', 'message' => self::$messageSuccess];
    }
}
