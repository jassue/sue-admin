<?php

use think\migration\Migrator;
use think\migration\db\Column;

class CreateAdminRole extends Migrator
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
        $this->table('admin_role')
            ->setId(false)->setPrimaryKey('id')->setEngine('InnoDB')
            ->addColumn('id', 'biginteger', ['identity'=>true, 'signed'=>false])
            ->addColumn('name', 'string', ['limit'=>20, 'default'=>''])
            ->addColumn('status', 'boolean', ['limit'=>1, 'default'=>1, 'signed'=>false])
            ->addColumn('create_time', 'integer', ['limit'=>10, 'signed'=>false])
            ->addColumn('update_time', 'integer', ['limit'=>10, 'signed'=>false])
            ->create();
    }

    public function down()
    {
        $this->dropTable('admin_role');
    }
}
