<?php
/**
 * Article Journal Uses (article-journal-use)
 * @var $this UseController
 * @var $model ArticleJournalUse
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
		'Article Journal Uses'=>array('manage'),
		'Create',
	);
?>

<div class="form" name="post-on">
	<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
