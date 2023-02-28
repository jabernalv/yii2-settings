<?php
/**
 * @link http://phe.me
 * @copyright Copyright (c) 2014 Pheme
 * @license MIT http://opensource.org/licenses/MIT
 */

use yii\helpers\Html;
use yii\grid\GridView;
use jabernal\settings\Module;
use jabernal\settings\models\Setting;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use yii\helpers\Url;

/**
 * @var yii\web\View $this
 * @var jabernal\settings\models\SettingSearch $searchModel
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var bool $isAjax
 */

$this->title = Module::t('settings', 'Settings');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="setting-index">
    <?php if (!$isAjax) : ?>
        <h1><?= Html::encode($this->title) ?></h1>
    <?php endif; ?>
    <?php //echo $this->render('_search', ['model' => $searchModel]);?>
    <?php Pjax::begin(); ?>
    <?=
    GridView::widget(
        [
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                'id',
                //'type',
                [
                    'attribute' => 'section',
                    'filter' => ArrayHelper::map(
                        Setting::find()->select('section')->distinct()->where(['<>', 'section', ''])->all(),
                        'section',
                        'section'
                    ),
                ],
                'key',
                'value:ntext',
                [
                    'class' => '\pheme\grid\ToggleColumn',
                    'attribute' => 'active',
                    'filter' => [1 => Yii::t('yii', 'Yes'), 0 => Yii::t('yii', 'No')],
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'header' => Html::button('<i class="bi bi-plus-circle"></i>', [
                        'data-url' => Url::to(['create']),
                        'title' => 'Crear ajuste',
                        'data-title' => 'Crear ajuste',
                        'class' => 'show-modal-link btn btn-success',
                        'data-pjax' => '0',
                    ]),
                ],
            ],
        ]
    ); ?>
    <?php Pjax::end(); ?>
</div>
