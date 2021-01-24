<?php


namespace app\models;


use yii\base\Model;

class IndexForm extends Model
{


    public $auto;

    public function rules()
    {
        return [
            ['auto', 'required', 'message' => ''],
            ['auto', 'trim'],
            ['auto', 'string', 'max' => 100],

        ];
    }

    public function attributeLabels()
    {
        return [
            'auto' => 'Dadata.ru',
        ];
    }
}