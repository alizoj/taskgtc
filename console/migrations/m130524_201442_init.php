<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql')
        {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id'            => $this->primaryKey(),
            'email'         => $this->string()->notNull()->unique(),
            'auth_key'      => $this->string(32)->notNull(),
            'password_hash' => $this->string(),
            'auth_token'    => $this->string()->unique(),
            'status'        => $this->smallInteger()->notNull()->defaultValue(\common\models\User::STATUS_ACTIVE),
            'created_at'    => $this->dateTime()->notNull(),
            'updated_at'    => $this->dateTime()->notNull(),
        ], $tableOptions);

        $this->insert('{{%user}}', [
            'email'         => 'kzt1@bk.ru',
            'auth_key'      => Yii::$app->security->generateRandomString(),
            'password_hash' => Yii::$app->security->generatePasswordHash('1q2w3e4r'),
            'status'        => \common\models\User::STATUS_ADMIN,
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
        ]);

        $this->createTable('{{%application}}', [
            'id'           => $this->primaryKey(),
            'user_id'      => $this->integer(),
            'FIO'          => $this->string()->notNull()->comment('ФИО'),
            'phone_number' => $this->string()->notNull()->comment('Контактный телефон'),
            'message'      => $this->string(1000)->notNull('Текст сообщения'),
            'status'       => $this->smallInteger()->notNull()->defaultValue(1),
            'created_at'   => $this->dateTime()->notNull(),
            'updated_at'   => $this->dateTime()->notNull(),
        ], $tableOptions);

        $this->createIndex('application-user_id', '{{%application}}', 'user_id');
        $this->addForeignKey('application-user_id-fk', '{{%application}}', 'user_id', 'user', 'id', 'RESTRICT', 'RESTRICT');
    }

    public function down()
    {
        $this->dropForeignKey('application-user_id-fk', '{{%application}}');
        $this->dropTable('{{%application}}');
        $this->dropTable('{{%user}}');
    }
}
