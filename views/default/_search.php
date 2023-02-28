<?php
    /**
     * @link http://phe.me
     * @copyright Copyright (c) 2014 Pheme
     * @license MIT http://opensource.org/licenses/MIT
     */

    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use jabernal\settings\Module;

    /**
     * @var yii\web\View $this
     * @var jabernal\settings\models\SettingSearch $model
     * @var yii\widgets\ActiveForm $form
     * @var bool $isAjax
     */
?>

<div class="setting-search">
    <?php $form = ActiveForm::begin(
        [
            'action' => ['index'],
            'method' => 'get',
        ]
    ); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'section') ?>

    <?= $form->field($model, 'key') ?>

    <?= $form->field($model, 'value') ?>

    <?= $form->field($model, 'active')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton(Module::t('settings', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Module::t('settings', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
