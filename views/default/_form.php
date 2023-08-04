<?php
    /**
     * @link http://phe.me
     * @copyright Copyright (c) 2014 Pheme
     * @license MIT http://opensource.org/licenses/MIT
     */

    use yii\helpers\Html;
    use yii\helpers\Url;
    use yii\widgets\ActiveForm;
    use jabernal\settings\Module;
    use \jabernal\settings\models\Setting;
    use \jabernal\settings\components\JSRegister;

    /**
     * @var yii\web\View $this
     * @var jabernal\settings\models\Setting $model
     * @var yii\widgets\ActiveForm $form
     * @var bool $isAjax
     */
    $randomid = str_replace('-', '_', \Yii::$app->security->generateRandomString());
?>
    <div class="setting-form">
        <?php $form = ActiveForm::begin([
            'id' => 'form-' . $randomid,
            'options' => ['autocomplete' => 'off', 'role' => 'form'],
        ]); ?>
        <?= $form->field($model, 'section')->textInput(['maxlength' => 255]) ?>
        <?= $form->field($model, 'key')->textInput(['maxlength' => 255]) ?>
        <?= $form->field($model, 'value')->textarea(['rows' => 6]) ?>
        <?= $form->field($model, 'active')->checkbox(['value' => 1]) ?>
        <?=
            $form->field($model, 'type')->dropDownList(
                $model->getTypes()
            )->hint(Module::t('settings', 'Change at your own risk')) ?>
        <div class="form-group">
            <?=
                Html::submitButton(
                    $model->isNewRecord ? Module::t('settings', 'Create') :
                        Module::t('settings', 'Update'),
                    [
                        'class' => $model->isNewRecord ?
                            'btn btn-success' : 'btn btn-primary'
                    ]
                ) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
<?php JSRegister::begin(); ?>
    <script>
        $('#form-<?= $randomid ?>').on('beforeSubmit', function (e) {
            if ($(this).find('.has-error').length) {
                return false;
            }
            <?php if($isAjax) : ?>
            $.ajax({
                url: $(this).attr('action'),
                type: 'post',
                data: $(this).serialize(),
                success: function (response) {
                    _puedecerrar = true;
                    $('#modaldialog').modal('hide');
                    $('#settings-index').html('<div style="text-align:center"><img src="/img/loader.gif"></div>');
                    $('#settings-index').load('<?= Url::to(['/settings']) ?>');
                },
                error: function (xhr, status, error) {
                    var errorMessage = xhr.status + ': ' + xhr.statusText;
                    console.log('Error - ' + errorMessage);
                }
            });
            return false;
            <?php else : ?>
            return true;
            <?php endif; ?>
        });
        $('[data-toggle="tooltip"]').tooltip();
    </script>
<?php JSRegister::end(); ?>