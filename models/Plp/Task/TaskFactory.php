<?php

namespace app\models\Plp\Task;

/**
 * Фабрика выбора классов задач.
 * Если класс или его метод не существует выбрасывается исключение.
 *
 * @package    ratio
 * @author     Nikolaj Rudakov <nnrudakov@gmail.com>
 * @copyright  2016
 */
class TaskFactory
{
    /**
     * @param string $className  Имя класса.
     * @param string $methodName Имя метода.
     *
     * @throws FatalException
     */
    public static function build($className, $methodName)
    {
        $class = __NAMESPACE__ . '\\' . ucfirst($className);

        if (class_exists($class)) {
            $class = new $class();
        } else {
            throw new FatalException('Класс для задачи "' . $className . '" не существует.');
        }
        
        if (!method_exists($class, $methodName)) {
            throw new FatalException('Метод "' . $methodName . '" для задачи "' . $className . '" не существует.');
        }
    }
}
