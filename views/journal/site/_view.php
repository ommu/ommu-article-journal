<?php
/**
 * Article Journals (article-journals)
 * @var $this SiteController
 * @var $data ArticleJournals
 *
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2017 Ommu Platform (www.ommu.co)
 * @created date 20 July 2017, 06:52 WIB
 * @link https://github.com/ommu/plu-article-journal
 *
 */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('journal_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->journal_id), array('view', 'id'=>$data->journal_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('publish')); ?>:</b>
	<?php echo CHtml::encode($data->publish); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('use_id')); ?>:</b>
	<?php echo CHtml::encode($data->use->column_name_relation); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('author_id')); ?>:</b>
	<?php echo CHtml::encode($data->author_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('author_organization')); ?>:</b>
	<?php echo CHtml::encode($data->author_organization); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('journal_title')); ?>:</b>
	<?php echo CHtml::encode($data->journal_title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('journal_url')); ?>:</b>
	<?php echo CHtml::encode($data->journal_url); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('creation_date')); ?>:</b>
	<?php echo CHtml::encode($this->dateFormat($data->creation_date)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('creation_id')); ?>:</b>
	<?php echo CHtml::encode($data->creation->displayname); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('modified_date')); ?>:</b>
	<?php echo CHtml::encode($this->dateFormat($data->modified_date)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('modified_id')); ?>:</b>
	<?php echo CHtml::encode($data->modified->displayname); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('slug')); ?>:</b>
	<?php echo CHtml::encode($data->slug); ?>
	<br />


</div>