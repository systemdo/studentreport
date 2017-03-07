<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Students */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Students'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>

</style>
<div class="students-view">
        <div class="row">
            <!--<h3><?php //Html::encode($this->title) ?></h2>-->
          
                <div class="col-md-8 grid-relatorios">

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs nav-pills tab-reports" role="tablist">
                        <?php 
                        foreach ($reports as $key => $report) {
                         if($key==0){
                            $class = "active";
                        }else{
                            $class ='';
                        }   
                        ?>    
                        <li role="presentation" class="<?php echo $class?>"><a href="#tab_<?php echo $key?>" aria-controls="tab_<?php echo $key?>" role="tab" data-toggle="tab"><?php echo $report->dataformatada ?></a></li>
                        <?php }?>

                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <?php foreach ($reports as $key => $report) {
                         if($key==0){
                            $class = "active";
                        }else{
                            $class ='';
                        }   
                        ?>    
                        <div role="tabpanel" class="tab-pane <?php echo $class?>"   id="tab_<?php echo $key?>">
                            <h5><b>Criado em:<?php echo $report->dataHoraFormatada?></b></h5>
                            <div class="text-report">
                                <p><?php echo $report->report?></p>
                                <p>
                                    <?= Html::a(Yii::t('app', 'Update'), ['reports/update', 'id' => $report->id, 'idStudent' => $model->id], ['class' => 'btn btn-primary']) ?>
                                    
                                </p>
                            </div>  
                        </div>
                        <?php }?>
                    </div>

                </div>
                <div class="col-md-4"> 

                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                //'id',
                        'name',
                        'birthday:date',
                        [
                        'attribute' => 'schedule', 
                        'value'=> $model->getShedules()->shedules,
                        ],

                        ],
                        ]) ?>
                       <p class="btn-left">
                            <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                            <?= $model->getHtmlBotaoEscreverRelatorio() ?>
                            <?= $model->getHtmlBotaoGerarRelatorio(); ?>
                            <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                                'class' => 'btn btn-danger',
                                'data' => [
                                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                                'method' => 'post',
                                ],
                                ]) ?>
                        </p>
   
                </div>    
        
            </div>
        </div>

        <script src="/studentreport/web/js/ckeditor/ckeditor.js"></script>

        <!--<script src="//cdn.ckeditor.com/4.6.2/full/ckeditor.js"></script>-->

        <script type="text/javascript">
       // Sample: Massive Inline Editing

    // This code is generally not necessary, but it is here to demonstrate
    // how to customize specific editor instances on the fly. This fits this
    // demo well because some editable elements (like headers) may
    // require a smaller number of features.

    // The "instanceCreated" event is fired for every editor instance created.
    /*CKEDITOR.on( 'instanceCreated', function ( event ) {
        var editor = event.editor,
        element = editor.element;

        // Customize editors for headers and tag list.
        // These editors do not need features like smileys, templates, iframes etc.
        if ( element.is( 'h1', 'h2', 'h3' ) || element.getAttribute( 'id' ) == 'taglist' ) {
            // Customize the editor configuration on "configLoaded" event,
            // which is fired after the configuration file loading and
            // execution. This makes it possible to change the
            // configuration before the editor initialization takes place.
            editor.on( 'configLoaded', function () {

                // Remove redundant plugins to make the editor simpler.
                editor.config.removePlugins = 'colorbutton,find,flash,font,' +
                        'forms,iframe,image,newpage,removeformat,' +
                        'smiley,specialchar,stylescombo,templates';

                // Rearrange the toolbar layout.
                editor.config.toolbarGroups = [
                    { name: 'editing', groups: [ 'basicstyles', 'links' ] },
                    //{ name: 'undo' },
                    { name: 'clipboard', groups: [ 'selection', 'clipboard' ] },
                    //{ name: 'about' }
                ];
            } );
        }
    } );*/
</script>

