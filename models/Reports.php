<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "reports".
 *
 * @property integer $id
 * @property integer $student_id
 * @property string $report
 * @property string $date
 *
 * @property Students $student
 */
class Reports extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'reports';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['student_id', 'report'], 'required'],
            [['student_id'], 'integer'],
            [['report'], 'string'],
            [['date'], 'safe'],
            [['student_id'], 'exist', 'skipOnError' => true, 'targetClass' => Students::className(), 'targetAttribute' => ['student_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [    
            'id' => Yii::t('app', 'ID'),
            'student_id' => Yii::t('app', 'Student ID'),
            'report' => Yii::t('app', 'Report'),
            'date' => Yii::t('app', 'Date'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelationStudent()
    {
        return $this->hasOne(Students::className(), ['id' => 'student_id']);
    }

    public function getStudent()
    {
        return $this->getRelationStudent()->one();
    }
}
