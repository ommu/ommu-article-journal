<?php
/**
 * Article Journals (article-journals)
 * @var $this FormController
 * @var $model ArticleJournals
 * @var $form CActiveForm
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2017 Ommu Platform (www.ommu.co)
 * @created date 20 July 2017, 06:52 WIB
 * @link https://github.com/ommu/plu-article-journal
 *
 */
?>

<?php if(!Yii::app()->getRequest()->getParam('email')) {
$form=$this->beginWidget('application.libraries.yii-traits.system.OActiveForm', array(
	'id'=>'article-journals-form',
	'enableAjaxValidation'=>true,
	//'htmlOptions' => array('enctype' => 'multipart/form-data')
)); ?>

<?php //begin.Messages ?>
<div id="ajax-message">
	<?php echo $form->errorSummary($model); ?>
</div>
<?php //begin.Messages ?>

<fieldset>
		
	<div class="clearfix">
		<?php echo $form->labelEx($model,'user_displayname'); ?>
		<div class="desc">
			<?php echo $form->textField($model,'user_displayname', array('maxlength'=>32, 'class'=>'span-6')); ?>
			<?php echo $form->error($model,'user_displayname'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>
	
	<div class="clearfix">
		<?php echo $form->labelEx($model,'user_email'); ?>
		<div class="desc">
			<?php echo $form->textField($model,'user_email', array('maxlength'=>32, 'class'=>'span-6')); ?>
			<?php echo $form->error($model,'user_email'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>
	
	<div class="clearfix">
		<?php echo $form->labelEx($model,'user_organization'); ?>
		<div class="desc">
			<?php echo $form->textField($model,'user_organization', array('maxlength'=>128, 'class'=>'span-8')); ?>
			<?php echo $form->error($model,'user_organization'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'journal_title'); ?>
		<div class="desc">
			<?php echo $form->textField($model,'journal_title', array('rows'=>6, 'cols'=>50, 'class'=>'span-10')); ?>
			<?php echo $form->error($model,'journal_title'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'journal_url'); ?>
		<div class="desc">
			<?php echo $form->textArea($model,'journal_url', array('rows'=>6, 'cols'=>50, 'class'=>'span-10 smaller')); ?>
			<?php echo $form->error($model,'journal_url'); ?>
			<?php /*<div class="small-px silent"></div>*/?>
		</div>
	</div>

	<div class="clearfix">
		<?php echo $form->labelEx($model,'use_id'); ?>
		<div class="desc">
			<?php
			$used = ArticleJournalUse::getUse();
			echo $form->radioButtonList($model,'use_id', $used);?>
			<?php echo $form->error($model,'use_id'); ?>
		</div>
	</div>

	<div class="submit clearfix">
		<label>&nbsp;</label>
		<div class="desc">
			<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('phrase', 'Create') : Yii::t('phrase', 'Save'), array('onclick' => 'setEnableSave()')); ?>
		</div>
	</div>

</fieldset>
<?php $this->endWidget();
} else {?>
	<div class="message success"><?php echo $this->pageDescription;?></div>
<?php }?>


