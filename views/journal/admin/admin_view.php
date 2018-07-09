<?php
/**
 * Article Journals (article-journals)
 * @var $this AdminController
 * @var $model ArticleJournals
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2017 Ommu Platform (www.ommu.co)
 * @created date 20 July 2017, 06:52 WIB
 * @link https://github.com/ommu/plu-article-journal
 *
 */

	$this->breadcrumbs=array(
		'Article Journals'=>array('manage'),
		$model->journal_id,
	);
?>

<?php //begin.Messages ?>
<?php
if(Yii::app()->user->hasFlash('success'))
	echo $this->flashMessage(Yii::app()->user->getFlash('success'), 'success');
?>
<?php //end.Messages ?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array(
			'name'=>'journal_id',
			'value'=>$model->journal_id,
		),
		array(
			'name'=>'publish',
			'value'=>$model->publish == '1' ? CHtml::image(Yii::app()->theme->baseUrl.'/images/icons/publish.png') : CHtml::image(Yii::app()->theme->baseUrl.'/images/icons/unpublish.png'),
			'type'=>'raw',
		),
		array(
			'name'=>'use_id',
			'value'=>$model->use_id ? $model->use->column_name_relation : '-',
		),
		array(
			'name'=>'user_organization',
			'value'=>$model->user_organization,
			//'value'=>$model->user_organization ? $model->user_organization : '-',
		),
		array(
			'name'=>'journal_title',
			'value'=>$model->journal_title ? $model->journal_title : '-',
			//'value'=>$model->journal_title ? CHtml::link($model->journal_title, Yii::app()->request->baseUrl.'/public/visit/'.$model->journal_title, array('target' => '_blank')) : '-',
			'type'=>'raw',
		),
		array(
			'name'=>'journal_url',
			'value'=>$model->journal_url ? $model->journal_url : '-',
			//'value'=>$model->journal_url ? CHtml::link($model->journal_url, Yii::app()->request->baseUrl.'/public/visit/'.$model->journal_url, array('target' => '_blank')) : '-',
			'type'=>'raw',
		),
		array(
			'name'=>'creation_date',
			'value'=>!in_array($model->creation_date, array('0000-00-00 00:00:00','1970-01-01 00:00:00','0002-12-02 07:07:12','-0001-11-30 00:00:00')) ? $this->dateFormat($model->creation_date, true) : '-',
		),
		array(
			'name'=>'creation_id',
			'value'=>$model->creation_id ? $model->creation->displayname : '-',
		),
		array(
			'name'=>'modified_date',
			'value'=>!in_array($model->modified_date, array('0000-00-00 00:00:00','1970-01-01 00:00:00','0002-12-02 07:07:12','-0001-11-30 00:00:00')) ? $this->dateFormat($model->modified_date, true) : '-',
		),
		array(
			'name'=>'modified_id',
			'value'=>$model->modified_id ? $model->modified->displayname : '-',
		),
		array(
			'name'=>'slug',
			'value'=>$model->slug ? $model->slug : '-',
			//'value'=>$model->slug ? CHtml::link($model->slug, Yii::app()->request->baseUrl.'/public/visit/'.$model->slug, array('target' => '_blank')) : '-',
			'type'=>'raw',
		),
	),
)); ?>

<div class="box">
</div>
<div class="dialog-content">
</div>
<div class="dialog-submit">
	<?php echo CHtml::button(Yii::t('phrase', 'Close'), array('id'=>'closed')); ?>
</div>