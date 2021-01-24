<?php
namespace app\components\behaviors;

use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\helpers\HtmlPurifier;

class PurifyBehavior extends Behavior
{

    public $attributes = [];

    public $config = null;

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'beforeValidate',
        ];
    }

    public function beforeValidate()
    {
        foreach ($this->attributes as $attribute) {
            $this->owner->$attribute = HtmlPurifier::process($this->owner->$attribute, $this->config);
        }
    }
}