<?php

use Phinx\Migration\AbstractMigration;

class CreateUsersTable extends AbstractMigration
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
    public function change()
    {
        $table = $this->table("users");
        $table
                ->addColumn("phone", "string", array("length" => 12))
                ->addColumn("email", "string", array("length" => 40, "null" => true))
                ->addColumn("flags", "integer", array("default" => 0))
                ->addColumn("roles", "integer", array("default" => 0))
                ->addColumn("perms_a", "integer", array("default" => 0))
                ->addColumn("perms_b", "integer", array("default" => 0))
                ->addColumn("perms_c", "integer", array("default" => 0))
                ->addColumn("salt", "string", array("length" => 40, "null" => false))
                ->addColumn("password", "string", array("length" => 40, "null" => false))
                ->addColumn("created_at", "timestamp", array("default" => "CURRENT_TIMESTAMP"))
                ->addColumn("updated_at", "timestamp", array("default" => "CURRENT_TIMESTAMP", "update" => "CURRENT_TIMESTAMP"));
        $table->create();
    }
}
