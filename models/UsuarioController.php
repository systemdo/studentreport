<?php

namespace backend\controllers;

use Yii;
use backend\models\Usuario;
use backend\models\UsuarioQuery;
use backend\models\UserFirstLogin;
use backend\models\UserMudarSenha;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\filters\AccessControl;


/**
 * UsuarioController implements the CRUD actions for Usuario model.
 */
class UsuarioController extends Controller
{
    public $menu_active_usuario='active';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','view', 'updade', 'delete', 'edite-senha'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                                return Usuario::authorization('ADMINISTRADOR');
                        },

                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Usuario models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UsuarioQuery();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Usuario model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Usuario model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Usuario();
       
        $model->generatePasswordResetToken();
        
        var_dump(Yii::$app->request->post());
        if ($model->load(Yii::$app->request->post())) {
            $model->setDesactiveStatus();
            
           var_dump($model);die();
            //enviar por email
            $model->save();
            
            $this->sendEmail($model->email, 'novo_usuario', 'Acesso Site Jtecncologia' );

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('_form', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Usuario model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            
            //enviar por email
            //$this->sendEmail($model->email, 'novo_usuario', 'Acesso Site Jtecncologia' );
            
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('_form', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Usuario model.
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
     * Finds the Usuario model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Usuario the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Usuario::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    //Cadastro feito pelo o usuário após recibimento do email.
    public function actionFirstlogin($id,$token)
    {
        $this->layout = 'main';
        if(Yii::$app->user){
            Yii::$app->user->logout();
        }
        $model = UserFirstLogin::findOne($id);
         if (!$model) 
                throw new NotFoundHttpException('Usuário Inexistente. Favor entrar em contato com a administrador');
         
        if ($model->load(Yii::$app->request->post())&& $id && $token) {
           
            //enviar por email
            if($model->password_hash === $model->confirm_password){
                $model->password_hash = md5($model->password_hash);
                //$model->password_reset_token = "CONFIRMADO";
                $model->status = $model::STATUS_ACTIVE;
                $model->save();
                //enviar email;
                return $this->redirect([Url::to("/login")]);
            }else{
                    $model->addError('confirm_password', 'Esse campo tem que ser igual ao de Senha.');
                    return $this->render('_form_first_login', [
                        'model' => $model,
                    ]);
            }    
        }
        if ($model !== null) {
            if($model->password_reset_token === $token ){
                return $this->render('_form_first_login', [
                    'model' => $model,
                ]);
            }else{
                    throw new NotFoundHttpException('Token para cadastro inválido. Favor entrar em contato com o administrador');
            }
        } else {
            throw new NotFoundHttpException('Usuário não existe.');
        }
    }
    
    //Editar sua propria senha.
    public function actionEditarSenha()
    {
        //$model = new UserMudarSenha;
        $old_model = Usuario::findOne(Yii::$app->user->identity->id);
        $model = UserMudarSenha::findOne(Yii::$app->user->identity->id);

         if (!$model) 
                throw new NotFoundHttpException('Ocorre algum erro, Favor entrar em contato com o administrador');
         
        if ($model->load(Yii::$app->request->post())) {
           
            //enviar por email
            if(md5($model->password_hash) === $old_model->password_hash){
                if($model->new_password_hash === $model->confirm_password){
                    $model->password_hash = md5($model->new_password_hash);
                    //$model->password_reset_token = "CONFIRMADO";
                    $model->status = $model::STATUS_ACTIVE;
                    $model->save();
                    //enviar email;
                    Yii::$app->user->logout();
                    return $this->redirect([Url::to("/login")]);
                }else{
                        $model->addError('confirm_password', 'Esse campo tem que ser igual ao de Nova Senha.');

                }    
            }else{
                $model->addError('password_hash', 'Senha Inválida.');
            }
        } 
        $model->password_hash = "";
        return $this->render('_form_mudar_senha', [
            'model' => $model,
        ]);
           
    }
    
     /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param  string  $email the target email address
     * @return boolean whether the email was sent
     */
    public function sendEmail($email, $path_html, $subject )
    {
        return 
            Yii::$app->mailer->compose(['html' => 'usuario/'.$path_html.'.php'], ['model' => $this])
            ->setTo($email)
            ->setFrom('lucas@jsolucoesti.com.br')
            ->setSubject($subject)
           // ->setTextBody($body)
            ->send();
    }
    
}
