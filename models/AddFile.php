<?php


namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

class AddFile extends Model
{
    /**
     * @var UploadedFile
     */
    public $newFile;

    public function rules()
    {
        return [
            [['newFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'xml'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'newFile' => 'Загрузить новый файл',
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $this->newFile->saveAs(\Yii::getAlias('@webroot') . '/files/123.' . $this->newFile->extension);
            return true;
        } else {
            return false;
        }
    }

    public function add(){
        $check = new ViewForm();
        $check->deleteAll();
        $xmlData = simplexml_load_file(\Yii::getAlias('@webroot') . '/files/123.xml');
        $int = 0;
        foreach($xmlData as $key => $item) {
            if (isset($item->login) &&
                isset($item->password)) {
                $check = new ViewForm();
                $check = $check->findOne(['user' => $item->login]);
                if (empty($check)) {
                    $add = new ViewForm();
                    $add->user = $item->login;
                    $add->name = $item->login;
                    $add->password = $item->password;
                    $add->email = $item->login . '@example.com';
                    $add->save();
                    $int++;
                }
            }
            else return 'Необходимо, чтобы были поля login и password';
        }
        return 'Cейчас добавлено (записей): '.$int;
    }



}