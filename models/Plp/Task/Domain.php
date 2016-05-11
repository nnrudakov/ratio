<?php

namespace app\models\Plp\Task;

/**
 * Класс задачи доменов.
 *
 * @package    ratio
 * @author     Nikolaj Rudakov <nnrudakov@gmail.com>
 * @copyright  2016
 */
class Domain extends BaseTask
{
    /**
     * Выполнение задачи.
     *
     * @param array $data Данные.
     *
     * @return bool
     *
     * @throws UserException
     */
    public static function addzone(array $data = [])
    {
        return ['type' => 'success', 'message' => 'Домен добавлен.'];
    }
}
