<?php
/**
 * Article Journal Uses (article-journal-use)
 * @var $this UseController
 * @var $model ArticleJournalUse
 * @var $form CActiveForm
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2017 Ommu Platform (opensource.ommu.co)
 * @created date 20 July 2017, 06:52 WIB
 * @link https://github.com/ommu/plu-article-journal
 *
 */

	$this->breadcrumbs=array(
		'Article Journal Uses'=>array('manage'),
		$model->name=>array('view','id'=>$model->use_id),
		'Update',
	);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
