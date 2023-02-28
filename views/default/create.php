<?php
/**
 * @link http://phe.me
 * @copyright Copyright (c) 2014 Pheme
 * @license MIT http://opensource.org/licenses/MIT
 */

use yii\helpers\Html;
use jabernal\settings\Module;

/**
 * @var yii\web\View $this
 * @var jabernal\settings\models\Setting $model
 * @var bool $isAjax
 */

$this->title = Module::t(
    'settings',
    'Create {modelClass}',
    [
        'modelClass' => Module::t('settings', 'Setting'),
    ]
);
$this->params['breadcrumbs'][] = ['label' => Module::t('settings', 'Settings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="setting-create">
    <?php if (!$isAjax) : ?>
        <h1><?= Html::encode($this->title) ?></h1>
    <?php endif; ?>
    <?=
    $this->render(
        '_form',
        [
            'model' => $model,
            'isAjax' => $isAjax,
        ]
    ) ?>

</div>
