<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "students".
 *
 * @property integer $id
 * @property string $name
 * @property string $birthday
 * @property integer $schedule
 *
 * @property Reports[] $reports
 * @property Shedules $id0
 */
class Students extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'students';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        [['name', 'birthday', 'schedule'], 'required'],
        [['birthday'], 'safe'],
        [['schedule'], 'integer'],
        [['name'], 'string', 'max' => 300],
        [['id'], 'exist', 'skipOnError' => true, 'targetClass' => Shedules::className(), 'targetAttribute' => ['id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            //'id' => Yii::t('app', 'ID'),
        'name' => Yii::t('app', 'Nome'),
        'birthday' => Yii::t('app', 'Data de Nascimento'),
        'schedule' => Yii::t('app', 'Turno'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReports()
    {
        return $this->hasMany(Reports::className(), ['student_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelationShedules()
    {
        return $this->hasOne(Shedules::className(), ['id' => 'schedule']);
    }
    
    public function getShedules()
    {
        return $this->getRelationShedules()->one();
    }

    public function getFormatedBirthday(){
        $date = explode("-",$this->birthday);
        return $date[2]."/".$date[1]."/".$date[0];
    }

    public function getHtmlBotaoEscreverRelatorio(){
        $html  = '<a href="'.Yii::$app->getUrlManager()->getBaseUrl().'/reports/create?idStudent='.$this->id.'" class="btn btn-success">Escrever</a>';
        return $html;
    }

     public function getHtmlBotaoGerarRelatorio(){

        $html  = '<a target="_new" href="'.Yii::$app->getUrlManager()->getBaseUrl().'/students/report?idStudent='.$this->id.'" class="btn btn-info">Gerar Relatório</a>';
                
        return $html;
    }


}
