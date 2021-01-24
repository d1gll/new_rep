<?php
use corpsepk\DaData\SuggestionsWidget;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
$this->title = 'Домик';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Главная страница</h1>
        <?php $form = ActiveForm::begin([]); ?>

        <?= $form->field($model, 'auto')->widget(SuggestionsWidget::class, [
            'type' => 'ADDRESS'
        ]) ?>
        <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary mb-2']) ?>

    </div>
    <?php ActiveForm::end(); ?>

    <?php echo $mod; ?>
</div>

