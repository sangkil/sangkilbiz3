<?php

namespace biz\app\base;

use Yii;
use yii\helpers\Inflector;

/**
 * Description of DefaultController
 *
 * @author Misbahul D Munir (mdmunir) <misbahuldmunir@gmail.com>
 */
class DefaultController extends \yii\web\Controller
{
    public $viewFile = '@biz/app/base/views/index.php';

    public function actionIndex()
    {
        $module = $this->module;
        $prefixR = '/' . $module->uniqueId . '/';
        if ($prefixR === '//') {
            $prefixR = '/';
        }
        $result = [];
        foreach ($module->controllerMap as $id => $value) {
            if ($id==='default') {
                continue;
            }
            $class = is_string($value) ? $value : $value['class'];
            $result[$id] = $this->getInfo($class);
        }
        $this->getControllers($module->controllerNamespace.'\\', '', $result);

        return $this->render($this->viewFile, [
                'controllers' => $result,
                'prefixRoute' => $prefixR,
            'moduleDescription' => $this->getInfo($module),
        ]);
    }

    protected function getControllers($namespace, $prefix, &$result)
    {
        $path = Yii::getAlias('@' . str_replace('\\', '/', $namespace));
        if (!is_dir($path)) {
            return;
        }
        foreach (scandir($path) as $file) {
            if ($file == '.' || $file == '..') {
                continue;
            }
            if (is_dir($path . '/' . $file)) {
                $this->getControllers($namespace . $file . '\\', $prefix . $file . '/', $result);
            } elseif (strcmp(substr($file, -14), 'Controller.php') === 0) {
                $id = Inflector::camel2id(substr(basename($file), 0, -14));
                $className = $namespace . Inflector::id2camel($id) . 'Controller';
                if (strpos($className, '-') === false && class_exists($className) && is_subclass_of($className, 'yii\base\Controller')) {
                    $result[$prefix . $id] = $this->getInfo($className);
                }
            }
        }
    }

    protected function getInfo($controller)
    {
        $class = new \ReflectionClass($controller);
        $comment = strtr(trim(preg_replace('/^\s*\**( |\t)?/m', '', trim($class->getDocComment(), '/'))), "\r", '');
        if (preg_match('/^\s*@\w+/m', $comment, $matches, PREG_OFFSET_CAPTURE)) {
            $comment = trim(substr($comment, 0, $matches[0][1]));
        }

        return $comment;
    }
}
