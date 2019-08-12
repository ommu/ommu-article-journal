<?php
/**
 * Article Journals (article-journals)
 * @var $this FormController
 * @var $model ArticleJournals
 * @var $form CActiveForm
 *
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2017 Ommu Platform (www.ommu.co)
 * @created date 20 July 2017, 06:52 WIB
 * @link https://github.com/ommu/plu-article-journal
 *
 */

	$this->breadcrumbs=array(
		'Article Journals'=>array('manage'),
		Yii::t('phrase', 'Create'),
	);
?>

<p>Kepada seluruh pemustaka BPAD DIY, <br/>Anda dapat meminta fullteks artikel jurnal internasional untuk keperluan riset dan pendidikan.  Layanan ini bersifat gratis dengan ketentuan sebagai berikut:</p>
<ol>
	<li>Permintaan artikel maksimal 2 (dua) judul per hari.</li>
	<li>TIDAK digunakan untuk keperluan komersil.</li>
	<li>Isikan identitas Anda selengkap dan sejelas mungkin.</li>
	<li>Mohon mengirimkan reply e-mail pengiriman artikel untuk membantu kami dalam menyusun statistik. </li>
</ol>

<div class="sep-form">
	<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>