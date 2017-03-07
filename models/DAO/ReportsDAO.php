<?php

namespace app\models\DAO;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Reports;
use app\models\Students;
use app\myclasses\MakeObject;
use yii\db\Query;
use yii\db\Connection;


/**
 * ReportsDAO represents the model behind the search form about `app\models\Reports`.
 */
class ReportsDAO extends Reports
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'student_id'], 'integer'],
            [['report', 'date'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Reports::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'student_id' => $this->student_id,
            'date' => $this->date,
        ]);

        $query->andFilterWhere(['like', 'report', $this->report]);

        return $dataProvider;
    }

    function getAllReportByStudent($idStudent){
        $db = Yii::$app->db;
        $query = "  
                    SELECT id, student_id, report ,`date`, 
                            DATE_FORMAT(`date`,'%d/%m/%y') as dataformatada,
                            DATE_FORMAT(`date`,'%d/%m/%Y %T') as dataHoraFormatada
                    FROM reports WHERE student_id = $idStudent ORDER BY `date` DESC
                   
                ";

        $model = $db->createCommand($query);
        $result = $model->queryAll();
        return MakeObject::becomeArrayToObject($result);
    }
}
