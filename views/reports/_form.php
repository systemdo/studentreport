<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Reports */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="reports-form">

	<?php $form = ActiveForm::begin(); ?>

	<?php //$form->field($model, 'student_id')->hiddenInput()?>

	<?php // $form->field($model, 'report')->textarea(['rows' => 6]) ?>
	<p><?php echo $model->getStudent()->name;?></p>
	<p>Data de Aniversário: <?php echo $model->getStudent()->getFormatedBirthday()?></p>
	<div class="form-group field-reports-report">
		<label class="control-label" for="reports-report">Relatório</label>
		<textarea id="reports-report" class="form-control" name="Reports[report]" rows="6" aria-required="true" aria-invalid="true">
		<?php if(!empty($model->report)) {
		echo $model->report;
		}?>	
		</textarea>
	</div>
	<?php echo $form->field($model, 'student_id')->hiddenInput(["value" => $model->getStudent()->id])->label(false)?>
	<div class="form-group">
		<?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	</div>

	<?php ActiveForm::end(); ?>

</div>

<script src="/studentreport/web/js/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
	var id = document.getElementById('reports-report');
	CKEDITOR.replace(id,
	{   				language:'pt-BR',
                        //enterMode: Number(2),
                        toolbarGroups: [
                            //{ name: 'document', groups: [ 'mode', 'document' ] },			// Displays document group with its two subgroups.
                            {name: 'clipboard', groups: ['clipboard', 'undo']},//items: ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo']

                            {name: 'editing', groups: ['find', 'selection', 'spellchecker']},
                            {name: 'basicstyles', groups: ['basicstyles', 'cleanup','Bold', 'Italic', 'Strike', '-', 'RemoveFormat']},
                            { name: 'colors', groups : [ 'TextColor','BGColor' ] },
                            '/',
                            {name: 'paragraph', groups: ['list', 'indent', 'align', 'bidi','NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote']},
                            {name: 'styles', groups: ['Styles', 'Format']},


                            //{ name: 'links' }
                            ]

                        });

for (var instanceName in CKEDITOR.instances)
        CKEDITOR.instances[instanceName].updateElement();

</script>
