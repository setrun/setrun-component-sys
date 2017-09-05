<?php

/**
 * @author Denis Utkin <dizirator@gmail.com>
 * @link   https://github.com/dizirator
 */

namespace setrun\sys\migrations;

use yii\db\Migration;

/**
 * Handles the creation of table `sys_language`.
 */
class m170807_160307_create_sys_language_table extends Migration
{
    /**
     * @var string Name of create a table
     */
    private $table = '{{%sys_language}}';

    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable($this->table, [
            'id'          => $this->primaryKey(),
            'slug'        => $this->string(50)->notNull()->unique(),
            'name'        => $this->string(50)->notNull(),
            'alias'       => $this->string(50)->notNull(),
            'locale'      => $this->string(50),
            'icon'        => $this->string(10),
            'position'    => $this->integer()->notNull()->defaultValue(1),
            'created_at'  => $this->integer()->notNull()->unsigned(),
            'updated_at'  => $this->integer()->notNull()->unsigned(),
            'created_by'  => $this->integer(),
            'updated_by'  => $this->integer()
        ], $tableOptions);

        $this->createIndex('{{%idx-sys_language-name}}',   $this->table, 'name');
        $this->createIndex('{{%idx-sys_language-slug}}',   $this->table, 'slug');
        $this->createIndex('{{%idx-sys_language-alias}}',  $this->table, 'alias');

        $this->insertDefault();
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable($this->table);
    }

    /**
     * Insert default languages.
     * @return void
     */
    private function insertDefault() : void
    {
        // Insert default languages
        $this->batchInsert($this->table, [
            'slug', 'name',       'locale',     'alias',
            'icon', 'created_at', 'updated_at', 'created_by', 'updated_by'
        ],
        [
            ['ru', 'Русский', 'ru_RU', 'ru',  'ru', time(), time(), 1, 1],
            ['en', 'English', 'en_GB', 'en',  'gb', time(), time(), 1, 1],
        ]);
    }
}
