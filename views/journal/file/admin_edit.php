<?php
/**
 * Article Journal Files (article-journal-file)
 * @var $this FileController
 * @var $model ArticleJournalFile
 * @var $form CActiveForm
 * version: 0.0.1
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @copyright Copyright (c) 2017 Ommu Platform (opensource.ommu.co)
 * @created date 20 July 2017, 06:52 WIB
 * @link http://opensource.ommu.co
 * @contact (+62)856-299-4114
 *
 */

	$this->breadcrumbs=array(
		'Article Journal Files'=>array('manage'),
		$model->file_id=>array('view','id'=>$model->file_id),
		'Update',
	);
?>

<div class="form" name="post-on">
	<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
