<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\helpers\Json;

?>
<?php Pjax::begin(); ?>

<div class="container" id="page-content">

    <div class="row">

        <div class="col-md-6">

            <div class="row container d-flex justify-content-center">

                <div class="col-md-6">

                    <div class="card card-bordered">

                        <div class="jumbotron">

                        <div class="card-header">

                            <h4 class="card-title"><strong>Чат</strong></h4>

                        </div>

                        </div>

                        <div class="ps-container ps-theme-default ps-active-y" id="chat-content" style="overflow-y: scroll !important; height:400px !important;">

                            <?php foreach (Json::decode($chat) as $chats => $value){?>

                            <div class="media media-chat"> <img class="avatar" src="https://img.icons8.com/color/36/000000/administrator-male.png" alt="...">

                                <div class="media-body">

                                    <?php if ($value['rules'] == "admin") :?>

                                    <div class="alert-danger">

                                        <?php endif;?>

                                    <p class="meta">

                                        <time datetime="2021">

                                            <?php echo $value['tdata'] ?>

                                            <?php if (Yii::$app->user->can('admin')) :?>

                                            <?=Html::a('На проверку',["site/chat", 'id' => $value['id']],['class'=>'big-button'])?>

                                            <?php endif;?>

                                        </time>
                                    </p>

                                    <p><?php echo $value['text'] ?></p>

                                    <hr>

                                        <?php if ($value['rules'] == "admin") :?>

                                    </div>

                                        <?php endif;?>

                                </div>

                            </div>

                            <?php } ?>

                        </div>

                        <div class="box-footer">

                            <?php $form = ActiveForm::begin(['options' => ['data-pjax' => true, 'id'=>'form-text']]); ?>

                            <div class="input-group">

                                <?php  if (!Yii::$app->user->isGuest)  :?>

                                <?= $form->field($model, 'text')->textInput(['autocomplete' => 'off', 'class'=>'form-control', 'type'=>'text','placeholder'=>'Введите сообщение...'])->label(false) ?>

                                <span class="input-group-btn">

                                    <?= Html::submitButton('Отправить', ['class' => 'pull-right btn btn-success ', 'id' =>'btn_send', 'name' => 'btn_send']) ?>

                                </span>

                                <?php else : ?>

                                    <div class="info">
                                        <p>
                                            Авторизируйтесь, чтобы писать сообщения!
                                        </p>
                                    </div>

                                <?php endif; ?>
                            </div>

                            <?php ActiveForm::end(); ?>

                        </div>

                </div>

            </div>

        </div>

        </div>

        <?php if (Yii::$app->user->can('admin')) {?>

            <div class="col-md-6">

                <div class="row container d-flex justify-content-center">

                    <div class="col-md-6">

                        <div class="card card-bordered">

                            <div class="jumbotron">

                                <div class="card-header">

                                    <h4 class="card-title"><strong>На проверке</strong></h4>

                                </div>
                            </div>

                            <div class="ps-container ps-theme-default ps-active-y" id="chat-content" style="overflow-y: scroll !important; height:400px !important;">

                                <?php foreach (Json::decode($fault) as $name => $faults){?>

                                    <div class="media media-chat">

                                        <img class="avatar" src="https://img.icons8.com/color/36/000000/administrator-male.png" alt="...">

                                        <div class="media-body">

                                            <p class="meta"><time datetime="2018"><?php echo $faults['tdata'] ?></time></p>

                                            <?=Html::a('Вернуть',["site/chat", 'add_id' => $faults['id']],['class'=>'big-button'])?>

                                            <?=Html::a('Удалить',["site/chat", 'del_id' => $faults['id']],['class'=>'big-button'])?>

                                            <p><?php echo $faults['text'] ?></p>

                                            <hr>

                                        </div>

                                    </div>
                                <?php }?>

                            </div>

                        </div>

                    </div>

                </div>

                <?php } ?>

    </div>

    </div>
</div>

    <?php Pjax::end(); ?>

