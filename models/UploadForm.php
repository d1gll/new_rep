<?php


namespace app\models;

use yii\base\Model;


class UploadForm extends Model
{

    public $dataFile;

    public function rules()
    {
        return [
            [['dataFile'], 'file', 'skipOnEmpty' => false, 'extensions'=>['xml', 'csv'], 'checkExtensionByMimeType'=>false, 'maxSize'=>1024 * 1024 * 2],
        ];
    }

    public function attributeLabels()
    {
        return [
            'dataFile' => 'Загрузить файл для обновления',
        ];
    }


    public function upload()
    {
        if ($this->validate()) {
            $this->dataFile->saveAs(\Yii::getAlias('@webroot') . '/files/123_upload.' .$this->dataFile->extension);
            return true;
        } else {
            return false;
        }
    }

    public function replace(){

        $count_email = 0;
        $count_name = 0;
        $count = 0;
        if($this->dataFile->extension =='xml'){
            $new_xmlData_up = simplexml_load_file(\Yii::getAlias('@webroot') . '/files/123_upload.xml');
            $return = $this->xmlFile($count_email,$count_name,$count, $new_xmlData_up);
        }
        if($this->dataFile->extension =='csv'){
            $new_xmlData_up = file_get_contents(\Yii::getAlias('@webroot') . '/files/123_upload.csv');
            $return = $this->csvFile($count_email,$count_name,$count, $new_xmlData_up);
        }

        return $return;
    }


    public function xmlFile($count_email,$count_name,$count, $new_xmlData_up){
        $count_rec = 0;

        if ($new_xmlData_up[0]->user[0]->login) {
            for ($j = 0; $j < count($new_xmlData_up); $j++) {

                $tableXml = new ViewForm();
                $tableXml = $tableXml->findOne(['user' => $new_xmlData_up[0]->user[$j]->login]);
                if ($tableXml) {

                    $count_name = $tableXml->searchName($new_xmlData_up[0]->user[$j]->login, $new_xmlData_up[0]->user[$j]->name, $count_name);
                    $count_email = $tableXml->searchEmail($new_xmlData_up[0]->user[$j]->login, $new_xmlData_up[0]->user[$j]->email, $count_email);
                    $tableXml->status = 1;
                    $tableXml->save();
                }
            }
            $tableXml = new ViewForm();
            $count = $tableXml->countRec(1);
            $count_rec = $tableXml->countRec(0);
            unlink(\Yii::getAlias('@webroot') . '/files/123_upload.xml');
            if ($count > 0) {
                $tableXml = new ViewForm();
                $tableXml->del();
                $tableXml->changeStatus();
            }
            return 'Совпадений: ' . $count . '. Удалилось: ' . $count_rec . '. Обновлено (email): ' . $count_email . '. Обновлено (имен): ' . $count_name;
        }
        else {
            unlink(\Yii::getAlias('@webroot') . '/files/123_upload.xml');
            return 'Xml файл должен содержать теги login';
        }

    }


    public function csvFile($count_email,$count_name,$count, $new_xmlData_up){
        $delimiter = ';';
        $rows = explode(PHP_EOL, $new_xmlData_up);
        $data = [];
        foreach ($rows as $row)
        {
            $data[] = explode($delimiter, iconv("Windows-1251", "UTF-8", $row));
        }
        if ($data[0][0]=='login' &&
            $data[0][1]=='password' &&
            $data[0][2]=='email' &&
            $data[0][3]=='name')
        {
            for ($i=0;$i<count($data);$i++){
                $tableXml = new ViewForm();
                $tableXml = $tableXml->findOne(['user' => $data[$i][0]]);
                if ($tableXml) {
                    $count_name = $tableXml->searchName($data[$i][0], $data[$i][3], $count_name);
                    $count_email = $tableXml->searchEmail($data[$i][0], $data[$i][2], $count_email);
                    $tableXml->status = 1;
                    $tableXml->save();
                }

            }
            unlink(\Yii::getAlias('@webroot') . '/files/123_upload.csv');
            $tableXml = new ViewForm();
            $count = $tableXml->countRec(1);
            $count_rec = $tableXml->countRec(0);
            if ($count>0) {
                $tableXml = new ViewForm();
                $tableXml->del();
                $tableXml->changeStatus();
                $tableXml->addXML();
            }
            return 'Совпадений: '.$count.'. Удалилось: '.$count_rec.'. Обновлено (email): '.$count_email. '. Обновлено (имен): '.$count_name;

        }
        else
            return 'Csv файл должен содержать таблицу со столбцами login, password, email, name.';

    }



}