<?php

use think\migration\Migrator;
use think\migration\db\Column;

class CreateUserTable extends Migrator
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function up()
    {
        $this->table('user')
             ->setId(false)->setPrimaryKey('id')->setEngine('InnoDB')
             ->addColumn('id', 'biginteger', ['identity'=>true, 'signed' => false])
             ->addColumn('username', 'string', ['limit'=>15, 'default'=>''])
             ->addColumn('password', 'string', ['limit'=>60, 'default'=>''])
             ->addColumn('status', 'boolean', ['limit'=>1, 'default'=>1, 'signed'=>false, 'comment'=>'状态1启用0禁用'])
             ->addColumn('last_login_ip', 'integer', ['limit'=>11, 'default'=>0, 'signed'=>false])
             ->addColumn('last_login_time', 'timestamp', ['limit'=>10, 'default'=>0])
             ->addTimestamps()
             ->addSoftDelete()
             ->addIndex(['username'], ['unique' => true])
             ->create();
    }

    public function down()
    {
        $this->dropTable('user');
    }
}
