<?php
/**
 * Article Journals (article-journals)
 * @var $this AdminController
 * @var $model ArticleJournals
 * @var $form CActiveForm
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2017 Ommu Platform (opensource.ommu.co)
 * @created date 20 July 2017, 06:52 WIB
 * @link https://github.com/ommu/plu-article-journal
 *
 */
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
	<ul>
		<li>
			<?php echo $model->getAttributeLabel('journal_id'); ?><br/>
			<?php echo $form->textField($model,'journal_id'); ?><br/>
					</li>

		<li>
			<?php echo $model->getAttributeLabel('publish'); ?><br/>
			<?php echo $form->textField($model,'publish'); ?><br/>
					</li>

		<li>
			<?php echo $model->getAttributeLabel('use_id'); ?><br/>
			<?php echo $form->textField($model,'use_id'); ?><br/>
					</li>

		<li>
			<?php echo $model->getAttributeLabel('author_id'); ?><br/>
			<?php echo $form->textField($model,'author_id'); ?><br/>
					</li>

		<li>
			<?php echo $model->getAttributeLabel('author_organization'); ?><br/>
			<?php echo $form->textField($model,'author_organization'); ?><br/>
					</li>

		<li>
			<?php echo $model->getAttributeLabel('journal_title'); ?><br/>
			<?php echo $form->textField($model,'journal_title'); ?><br/>
					</li>

		<li>
			<?php echo $model->getAttributeLabel('journal_url'); ?><br/>
			<?php echo $form->textField($model,'journal_url'); ?><br/>
					</li>

		<li>
			<?php echo $model->getAttributeLabel('creation_date'); ?><br/>
			<?php echo $form->textField($model,'creation_date'); ?><br/>
					</li>

		<li>
			<?php echo $model->getAttributeLabel('creation_id'); ?><br/>
			<?php echo $form->textField($model,'creation_id'); ?><br/>
					</li>

		<li>
			<?php echo $model->getAttributeLabel('modified_date'); ?><br/>
			<?php echo $form->textField($model,'modified_date'); ?><br/>
					</li>

		<li>
			<?php echo $model->getAttributeLabel('modified_id'); ?><br/>
			<?php echo $form->textField($model,'modified_id'); ?><br/>
					</li>

		<li>
			<?php echo $model->getAttributeLabel('slug'); ?><br/>
			<?php echo $form->textField($model,'slug'); ?><br/>
					</li>

		<li class="submit">
			<?php echo CHtml::submitButton(Yii::t('phrase', 'Search')); ?>
		</li>
	</ul>
<?php $this->endWidget(); ?>
