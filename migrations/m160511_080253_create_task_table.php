<?php

use yii\db\Migration;

/**
 * Handles the creation for table `task` table.
 */
class m160511_080253_create_task_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $table_data = [
            [
                'id'         => 2971220,
                'account_id' => 70748,
                'created'    => '2016-02-14 13:08:15',
                'deffer'     => null,
                'type'       => null,
                'task'       => 'integration',
                'action'     => 'process',
                'data'       => '{"integration_id":3312,"lead_id":"2999670"}',
                'status'     => 0,
                'retries'    => 0,
                'finished'   => null,
                'result'     => null
            ],
            [
                'id'         => 2971206,
                'account_id' => 80034,
                'created'    => '2016-02-14 13:08:16',
                'deffer'     => null,
                'type'       => null,
                'task'       => 'message',
                'action'     => 'sms',
                'data'       => '{"number":"89111111119","message":"Заявка с ru.ru\nвячеслав \n"}',
                'status'     => 0,
                'retries'    => 0,
                'finished'   => null,
                'result'     => null
            ],
            [
                'id'         => 2971187,
                'account_id' => 81259,
                'created'    => '2016-02-14 13:06:42',
                'deffer'     => null,
                'type'       => null,
                'task'       => 'account',
                'action'     => 'bill',
                'data'       => '{"bill_id":"82029"}',
                'status'     => 0,
                'retries'    => 0,
                'finished'   => null,
                'result'     => null
            ],
            [
                'id'         => 2971123,
                'account_id' => 9608,
                'created'    => '2016-02-14 13:01:58',
                'deffer'     => null,
                'type'       => null,
                'task'       => 'integration',
                'action'     => 'process',
                'data'       => '{"integration_id":2845,"lead_id":"2999571"}',
                'status'     => 0,
                'retries'    => 0,
                'finished'   => null,
                'result'     => null
            ],
            [
                'id'         => 2971122,
                'account_id' => 9608,
                'created'    => '2016-02-14 13:01:53',
                'deffer'     => null,
                'type'       => null,
                'task'       => 'integration',
                'action'     => 'process',
                'data'       => '{"integration_id":2987,"lead_id":"2999570"}',
                'status'     => 0,
                'retries'    => 0,
                'finished'   => null,
                'result'     => null
            ],
            [
                'id'         => 2971107,
                'account_id' => 83992,
                'created'    => '2016-02-14 13:01:03',
                'deffer'     => null,
                'type'       => null,
                'task'       => 'domain',
                'action'     => 'addzone',
                'data'       => '{"domain":"mydomain.ru"}',
                'status'     => 0,
                'retries'    => 0,
                'finished'   => null,
                'result'     => null
            ]
        ];
        $this->createTable('task', [
            'id'         => $this->primaryKey(10),
            'account_id' => $this->integer(10)->unsigned(),
            'created'    => $this->dateTime(),
            'deffer'     => $this->dateTime(),
            'type'       => $this->smallInteger(2),
            'task'       => $this->string(45),
            'action'     => $this->string(45),
            'data'       => $this->text(),
            'status'     => $this->smallInteger(2),
            'retries'    => $this->smallInteger(2),
            'finished'   => $this->dateTime(),
            'result'     => $this->text()
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
        $this->createIndex('status', 'task', 'status');
        $this->createIndex('deffer', 'task', 'deffer');
        foreach ($table_data as $columns) {
            $this->insert('task', $columns);
        }
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('task');
    }
}
