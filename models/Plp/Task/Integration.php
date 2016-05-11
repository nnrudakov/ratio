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
     * @return bool
     *
     * @throws UserException
     */
    public static function process(array $data = [])
    {
        if (!array_key_exists('integration_id', $data)) {
            throw new UserException('Недостаточно передано параметов.');
        }

        return true;
    }
}
