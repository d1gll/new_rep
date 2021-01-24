<?php


use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\helpers\Url;


?>



<div class="panel panel-default">
    <?php $form = ActiveForm::begin([
        'action'=>Url::toRoute('/site/add-data'),
        'id'=>'form-update'
    ]); ?>
    <?= $form->field($add, 'newFile')->fileInput() ?>

    <?= $form = Html::submitButton('Добавить', ['class' => 'btn btn-primary mb-2']) ?>

    <?php ActiveForm::end(); ?>

</div>
<br>

<div class="panel panel-default">
    <?php $form = ActiveForm::begin([
        'action'=>Url::toRoute('/site/upload'),
        'id'=>'form-update'
    ]); ?>

    <?= $form->field($model, 'dataFile')->fileInput() ?>

    <?= $form = Html::submitButton('Обновить', ['class' => 'btn btn-primary mb-2']) ?>


    <?php ActiveForm::end(); ?>
</div>
<br>

<table class="table">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Логин</th>
        <th scope="col">Email</th>
        <th scope="col">Имя</th>
    </tr>
    </thead>
    <?php
    $int = 1;
    foreach ($lists as $list) {
        ?>
        <tbody>
        <tr>
            <td><?php echo $int ?></td>
            <td><?php echo $list->user; ?></td>
            <td><?php echo $list->email; ?></td>
            <td><?php echo $list->name; ?></td>
        </tr>
        </tbody>

        <?php
        $int++;
    }
    ?>     </table> <?php
// отображаем ссылки на страницы
echo LinkPager::widget([
    'pagination' => $pages,
]);?>



