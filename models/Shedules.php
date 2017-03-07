<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "shedules".
 *
 * @property integer $id
 * @property string $shedules
 *
 * @property Students $students
 */
class Shedules extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shedules';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['shedules'], 'required'],
            [['shedules'], 'string', 'max' => 15],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'shedules' => Yii::t('app', 'Shedules'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudents()
    {
        return $this->hasOne(Students::className(), ['id' => 'id']);
    }
}
