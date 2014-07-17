<?php

namespace app\commands;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * Description of MigrateController
 *
 * @author Misbahul D Munir (mdmunir) <misbahuldmunir@gmail.com>
 */
class MigrateController extends \yii\console\controllers\MigrateController
{
    /**
     *
     * @var array 
     */
    public $migrationLookup = [];
    private $_migrations;

    protected function createMigration($class)
    {
        $paths = $this->getMigrationMap();
        if (isset($paths[$class])) {
            $file = $paths[$class];
            require_once($file);

            return new $class(['db' => $this->db]);
        } else {
            return parent::createMigration($class);
        }
    }

    protected function getMigrationMap()
    {
        if ($this->_migrations === null) {
            $this->_migrations = [];
            $directories = array_merge($this->migrationLookup, [$this->migrationPath]);
            $extraPath = ArrayHelper::getValue(Yii::$app->params, 'yii.migrations');
            if (!empty($extraPath)) {
                $directories = array_merge((array) $extraPath, $directories);
            }
            $dirs = [];
            foreach (array_unique($directories) as $dir) {
                $dir = Yii::getAlias($dir);
                if (isset($dirs[$dir])) {
                    continue;
                }
                $dirs[$dir] = true;
                $handle = opendir($dir);
                while (($file = readdir($handle)) !== false) {
                    if ($file === '.' || $file === '..') {
                        continue;
                    }
                    $path = $dir . DIRECTORY_SEPARATOR . $file;
                    if (preg_match('/^(m(\d{6}_\d{6})_.*?)\.php$/', $file, $matches) && is_file($path)) {
                        $this->_migrations[$matches[1]] = $path;
                    }
                }
                closedir($handle);
            }

            ksort($this->_migrations);
        }
        return $this->_migrations;
    }

    protected function getNewMigrations()
    {
        $applied = [];
        foreach ($this->getMigrationHistory(null) as $version => $time) {
            $applied[substr($version, 1, 13)] = true;
        }

        $migrations = [];
        foreach ($this->getMigrationMap() as $version => $path) {
            if (!isset($applied[substr($version, 1, 13)])) {
                $migrations[] = $version;
            }
        }

        return $migrations;
    }
}