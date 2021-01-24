<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Json;
?>

<table class="table">
    <thead>
    <tr>
        <th scope="col">id</th>
        <th scope="col">Логин</th>
        <th scope="col">Почта</th>
        <th scope="col">Права</th>
    </tr>
    </thead>
    <tbody>

        <?php foreach (Json::decode($model) as $users => $value):
            $form = ActiveForm::begin();
        ?>

            <tr>
               <th scope="row"><?php echo $value['id']?></th>
                    <th scope="row"><?php echo $value['username']?></th>
                    <th scope="row"><?php echo $value['email']?></th>
                    <th scope="row">
                        <?php for ($i=0;$i<count($rules);$i++){
                            if ($rules[$i]['user_id'] == $value['id']){
                                $status_user = '';
                                if ($rules[$i]->item_name=="admin") $status_user = 'editor';
                                else $status_user = 'admin';
                                $items = [
                                    $value['id'].'_'.$rules[$i]->item_name => $rules[$i]->item_name,
                                    $value['id'].'_'.$status_user => $status_user,];
                                echo Html::dropDownList('status', 'null', $items);
                            }
                            }

                            echo Html::submitButton('применить', ['class' => 'pull-right', 'id' => 'btn_yes', 'name' => 'btn_send']);

                            ActiveForm::end();
                        ?>
               </th>
            </tr>
        <?php endforeach;?>
    </tbody>
</table>
