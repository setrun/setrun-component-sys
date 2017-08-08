<?php

/**
 * @author Denis Utkin <dizirator@gmail.com>
 * @link   https://github.com/dizirator
 */

namespace setrun\sys\commands;

use Yii;
use yii\db\Migration;
use yii\helpers\Console;
use yii\helpers\FileHelper;

/**
 * Class MigrateController.
 */
class MigrateController extends \yii\console\controllers\MigrateController
{
    /**
     * @var string
     */
    protected $tmpDir = '@runtime/db-migrations';

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        $this->migrationPath = Yii::getAlias($this->tmpDir);
        $this->copyMigrations();
        return parent::beforeAction($action);
    }

    /**
     * @inheritdoc
     */
    public function afterAction($action, $result)
    {
        //FileHelper::removeDirectory($this->migrationPath);
        return parent::afterAction($action, $result);
    }

    /**
     * @inheritdoc
     */
    protected function createMigration($class)
    {
        $this->clearNamespace($this->migrationPath . '/' . $class . '.php');
        return parent::createMigration($class);
    }

    /**
     * Copy migrations to temp directory.
     * @return void
     */
    protected function copyMigrations() : void
    {
        $this->stdout("Copy the migration files in a temp directory \n", Console::FG_YELLOW);
        FileHelper::removeDirectory($this->migrationPath);
        FileHelper::createDirectory($this->migrationPath);
        if (!is_dir($this->migrationPath)) {
            $this->stdout("Could not create a temporary directory migration \n", Console::FG_RED);
            exit();
        }
        $this->stdout("\t Created a directory migration \n", Console::FG_GREEN);
        if ($dirs = $this->findMigrationDirs()) {
            foreach ($dirs as $dir) {
                FileHelper::copyDirectory($dir, $this->migrationPath);
            }
        }
        $this->stdout("\t The copied files components migrations \n", Console::FG_GREEN);
        $appMigrateDir = \Yii::getAlias("@app/commands");
        if (is_dir($appMigrateDir)) {
            FileHelper::copyDirectory($appMigrateDir, $this->migrationPath);
        }
        $this->stdout("\t The copied files app migrations \n\n", Console::FG_GREEN);
    }

    /**
     * Find migrations.
     * @return array
     */
    private function findMigrationDirs() : array
    {
        $output = [];
        foreach ($this->findMigrationPossibleDirs() as $migrationPath) {
            if (is_dir($migrationPath)) {
                $output[] = $migrationPath;
            }
        }
        return $output;
    }
    /**
     * Find possible migrations.
     * @return array
     */
    private function findMigrationPossibleDirs()
    {
        $output = [];
        foreach (Yii::$app->extensions as $code => $data) {
            if ($data['alias']) {
                foreach ($data['alias'] as $code => $path) {
                    $output[] = $path . '/migrations';
                }
            }
        }
        return $output;
    }

    /**
     * Clear namespace to php class file.
     * @param string $class
     */
    protected function clearNamespace(string $class)
    {
        if (file_exists($class)) {
            $content = file_get_contents($class);
            $content = preg_replace('#^namespace\s+(.+?);$#sm', ' ', $content);
            file_put_contents($class, $content);
        }
    }
}