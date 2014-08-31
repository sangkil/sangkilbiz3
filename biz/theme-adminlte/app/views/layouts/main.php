<?php

use yii\helpers\Html;
use biz\adminlte\MyAsset;
use yii\helpers\Inflector;
use yii\widgets\Breadcrumbs;

/**
 * @var \yii\web\View $this
 * @var string $content
 */
$lte_asset = MyAsset::register($this);
$baseurl = $lte_asset->baseUrl;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" manifest="<?= isset($this->context->manifestFile) ? $this->context->manifestFile : '' ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <?php $this->beginBody() ?>
    <body class="skin-blue fixed">
        <header class="header">
            <?php echo $this->render('heading', ['baseurl' => $baseurl]); ?>
        </header>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <aside class="right-side">
                <section class="content-header">
                    <h1>
                        <?= '&nbsp;' . Html::encode($this->title) ?>
                        <small><?php echo \Yii::$app->controller->id . '-' . \Yii::$app->controller->action->id; ?></small>
                    </h1>
                    <?php
                    $breadcrumbs = isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [];
                    foreach (Yii::$app->controller->modules as $module) {
                        if ($module != Yii::$app) {
                            array_unshift($breadcrumbs, ['label' => Inflector::camel2words($module->id), 'url' => ['/' . $module->uniqueId]]);
                        }
                    }
                    ?>
                    <?=
                    Breadcrumbs::widget([
                        'tag'=>'ol',
                        'encodeLabels'=>false,
                        'homeLink'=>['label'=>'<i class="fa fa-dashboard"></i> Home/Dashboard','url'=>['/site/index']],
                        'links' => $breadcrumbs,
                    ])
                    ?>
                </section>
                <section class="content">
                    <?= $content ?>
                </section>
            </aside>            
            <aside class="left-side sidebar-offcanvas">
                <?php echo $this->render('sidebar', ['baseurl' => $baseurl]); ?>
            </aside>
        </div>

        <!--        <footer class="footer">
                    <div class="container">
                        <p class="pull-left">&copy; My Company <?= ''//date('Y')              ?></p>
                        <p class="pull-right"><?= ''//Yii::powered()              ?></p>
                    </div>
                </footer>-->
    </div>
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
