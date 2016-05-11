<?php

namespace app\models\Plp\Task;

use yii\base\Object;

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
     * @param array $data Параметры для метода.
     *
     * @return array Результат выполнения.
     */
    public function run(array $data)
    {
        return $this->{$this->method}($data);
    }
}
