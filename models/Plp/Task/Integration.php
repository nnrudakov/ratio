<?php

namespace app\models\Plp\Task;

/**
 * Класс задачи интеграции.
 *
 * @package    ratio
 * @author     Nikolaj Rudakov <nnrudakov@gmail.com>
 * @copyright  2016
 */
class Integration extends BaseTask
{
    /**
     * Выполнение задачи.
     *
     * @param array $data Данные.
     *
     * @return array Реультат.
     */
    public static function process(array $data = [])
    {
        $result = ['type' => 'success'];

        return $result;
    }
}
