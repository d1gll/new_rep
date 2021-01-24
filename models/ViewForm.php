<?php


namespace app\models;


use yii\db\ActiveRecord;


class ViewForm extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%new_xml}}';
    }

    public function del(){
        return ViewForm::deleteAll([
            'status' => '0'
        ]);
    }
    public function changeStatus(){
        return ViewForm::updateAll(['status' => 0]);

    }

    public function countRec($i){
        return ViewForm::find()->where(['status' => $i])->count();
    }

    public function addXML(){
       \Yii::$app->response->format = \yii\web\Response::FORMAT_XML;
        $xml=new \DomDocument('1.0','utf-8');
        $data = ViewForm::find()->all();

        foreach ($data as $dates){
        $sorts = $xml->appendChild($xml->createElement('user'));
        $name = $sorts->appendChild($xml->createElement('login'));
        $name->appendChild($xml->createTextNode($dates->user));
        $name = $sorts->appendChild($xml->createElement('password'));
        $name->appendChild($xml->createTextNode($dates->password));
        $name = $sorts->appendChild($xml->createElement('email'));
        $name->appendChild($xml->createTextNode($dates->email));
        $name = $sorts->appendChild($xml->createElement('name'));
        $name->appendChild($xml->createTextNode($dates->name));
        }
        $xml->formatOutput = true;
        $xml->save(\Yii::getAlias('@webroot') . '/files/123.xml');

    }


    public function searchEmail($user, $email, $int){
        $tableXml = new ViewForm();
        if (!empty($email)) {
            $check = $tableXml->findOne(['user' => $user, 'email' => $email]);
            if (!$check) {
                $check = $tableXml->findOne(['user' => $user]);
                $check->email = $email;
                $check->save();
                $int++;
            }
        }
        return $int;
    }
    public function searchName($user, $name, $int)
    {
        $tableXml = new ViewForm();
        if (!empty($name)) {
            $check = $tableXml->findOne(['user' => $user, 'name' => $name]);
            if (!$check) {
                $check = $tableXml->findOne(['user' => $user]);
                $check->name = $name;
                $check->save();
                $int++;
            }
        }
        return $int;
    }


}