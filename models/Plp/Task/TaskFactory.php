<?php

namespace app\models\Plp\Task;

/**
 * Фабрика выбора классов задач.
 *
 * @package    ratio
 * @author     Nikolaj Rudakov <nnrudakov@gmail.com>
 * @copyright  2016
 */
class TaskFactory
{
    /**    
     * Возвращает экземпляр класса, который будет выполнять задачу.
     * Если класса или запрошенного метода не существует, то вызывается исключение.
     * 
     * @param string $className  Имя класса.
     * @param string $methodName Имя метода.
     *                           
     * @return BaseTask
     *
     * @throws FatalException
     */
    public static function build($className, $methodName)
    {
        $class = __NAMESPACE__ . '\\' . ucfirst($className);

        if (class_exists($class)) {
            $class = new $class(['method' => $methodName]);
        } else {
            throw new FatalException('Класс для задачи "' . $className . '" не существует.');
        }
        
        if (!method_exists($class, $methodName)) {
            throw new FatalException('Метод "' . $methodName . '" для задачи "' . $className . '" не существует.');
        }
        
        return $class;
    }
}
