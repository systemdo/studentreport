<?php

namespace app\controllers;

use Yii;
use app\models\Students;
use app\models\DAO\StudentsDAO;
use app\models\DAO\ReportsDAO;

use app\models\Shedules;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
/**
 * StudentsController implements the CRUD actions for Students model.
 */
class StudentsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Students models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StudentsDAO();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Students model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
         $reportsDAO = new ReportsDAO();
         
        return $this->render('view', [
            'model' => $this->findModel($id),
            'reports' => $reportsDAO->getAllReportByStudent($id),
        ]);
    }

    /**
     * Creates a new Students model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Students();
        $shedules = new Shedules;
        $shedulesList = Shedules::find()->all();
        if ($model->load(Yii::$app->request->post())) {
                $data = explode('/',$model->birthday);  
                $model->birthday = $data[2].'-'.$data[1]."-".$data[0];
                $model->save();
                return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'shedules' =>  ArrayHelper::map($shedulesList,'id','shedules')
            ]);
        }
    }

    /**
     * Updates an existing Students model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $shedulesList = Shedules::find()->all();
       
        if ($model->load(Yii::$app->request->post())){  
            $data = explode('/',$model->birthday);  
            $model->birthday = $data[2].'-'.$data[1]."-".$data[0];
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'shedules' => ArrayHelper::map($shedulesList,'id','shedules')
            ]);
        }
    }

    /**
     * Deletes an existing Students model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Students model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Students the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Students::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionReport($idStudent){
        $pdf = Yii::$app->pdf;
        $html = $this->getHtmlReport($idStudent);
        
        $pdf->content = $html;
        // format content from your own css file if needed or use the
        // enhanced bootstrap css built by Krajee for mPDF formatting 
         $pdf->cssFile = '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css';
        // any css to be embedded if required
        $pdf->cssInline = '.kv-heading-1{font-size:18px}';

         // set mPDF properties on the fly
        $pdf->options = [
                            'title' => 'Relatório de Alunos',
                            'subject' => 'Relatório',
                        ];
         // call mPDF methods on the fly
        $pdf->methods = [ 
            'SetHeader'=>['Sesc Relatorio || Júlia '. date("d/m/Y h:i:s")],
            'SetFooter'=>['|página: {PAGENO}|'],
        ];
        

        $pdf->getApi()->SetWatermarkImage(Yii::$app->urlManager->createAbsoluteUrl("img/marca-senac.jpg"));
        $pdf->getApi()->watermarkImageAlpha = 0.5;
        $pdf->getApi()->showWatermarkImage = true;

        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        Yii::$app->response->headers->add('Content-Type', 'application/pdf');
        
        return $pdf->render();
    }

    protected function getHtmlReport($id){
        $reportsDAO = new ReportsDAO();
        $model = $this->findModel($id);
        $html ='';
        $reports = $reportsDAO->getAllReportByStudent($id);
        $html .='O aluno '. $model->name;
        foreach ($reports as $key => $report) {
            $html .= '<p>'. $report->report.'</p>';
        }
        return $html;
    }
}
