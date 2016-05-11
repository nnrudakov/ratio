<?php

namespace app\models\Plp;

use yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "task".
 *
 * @property integer $id
 * @property integer $account_id
 * @property string $created
 * @property string $deffer
 * @property integer $type
 * @property string $task
 * @property string $action
 * @property string $data
 * @property integer $status
 * @property integer $retries
 * @property string $finished
 * @property string $result
 */
class Task extends ActiveRecord
{
    /**
     * Статус задачи "невозможно выполнить".
     *
     * @var integer
     */
    const STATUS_CANTDONE = -1;

    /**
     * Статус задачи "невыполнена".
     *
     * @var integer
     */
    const STATUS_UNDONE = 0;

    /**
     * Статус задачи "выполнена".
     *
     * @var integer
     */
    const STATUS_DONE = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'task';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['account_id', 'type', 'status', 'retries'], 'integer'],
            [['created', 'deffer', 'finished'], 'safe'],
            [['data', 'result'], 'string'],
            [['task', 'action'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'         => 'ID',
            'account_id' => 'Account ID',
            'created'    => 'Created',
            'deffer'     => 'Deffer',
            'type'       => 'Type',
            'task'       => 'Task',
            'action'     => 'Action',
            'data'       => 'Data',
            'status'     => 'Status',
            'retries'    => 'Retries',
            'finished'   => 'Finished',
            'result'     => 'Result',
        ];
    }

    /**
     * Установка задачи как выполненной.
     *
     * @throws yii\base\InvalidConfigException
     * @throws yii\base\InvalidParamException
     */
    public function setDone()
    {
        $this->finished = Yii::$app->formatter->asDatetime('now', 'yyyy-MM-dd HH:mm:ss');
        $this->status = static::STATUS_DONE;
    }

    /**
     * Установка задачи как невыполненной.
     *
     * @throws yii\base\InvalidConfigException
     * @throws yii\base\InvalidParamException
     */
    public function setUnDone()
    {
        $this->deffer = Yii::$app->formatter->asDatetime('now', 'yyyy-MM-dd HH:mm:ss');
        $this->finished = null;
        $this->status = static::STATUS_UNDONE;
        $this->retries++;
    }

    /**
     * Установка задачи как невозможной к выполнению.
     *
     * @throws yii\base\InvalidConfigException
     * @throws yii\base\InvalidParamException
     */
    public function setCantDone()
    {
        $this->deffer = Yii::$app->formatter->asDatetime('now', 'yyyy-MM-dd HH:mm:ss');
        $this->finished = null;
        $this->status = static::STATUS_CANTDONE;
    }

    /**
     * Получение списка не выполненных задач.
     *
     * @return Task[]
     */
    public function getNewTasks()
    {
        return static::find()->where(['status' => static::STATUS_UNDONE])->orderBy('created')->all();
    }

    /**
     * Получение результата в тексовом виде.
     *
     * @return string
     *
     * @throws yii\base\InvalidParamException
     */
    public function getResultText()
    {
        if (!$this->result) {
            return '';
        }

        $result = yii\helpers\Json::decode($this->result);

        return $result['message'];
    }
}
