<?php
/**
 * FormController
 * @var $this FormController
 * @var $model ArticleJournals
 * @var $form CActiveForm
 *
 * Reference start
 * TOC :
 *	Index
 *	Request
 *
 *	LoadModel
 *	performAjaxValidation
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2017 Ommu Platform (www.ommu.co)
 * @created date 20 July 2017, 06:52 WIB
 * @link https://github.com/ommu/plu-article-journal
 *
 *----------------------------------------------------------------------------------------------------------
 */

class FormController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	//public $layout='//layouts/column2';
	public $defaultAction = 'index';

	/**
	 * Initialize admin page theme
	 */
	public function init() 
	{
		$arrThemes = $this->currentTemplate('public');
		Yii::app()->theme = $arrThemes['folder'];
		$this->layout = $arrThemes['layout'];
	}

	/**
	 * @return array action filters
	 */
	public function filters() 
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			//'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules() 
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','request'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array(),
				'users'=>array('@'),
				'expression'=>'isset(Yii::app()->user->level)',
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array(),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	/**
	 * Lists all models.
	 */
	public function actionIndex() 
	{
		$this->redirect(array('request'));
	}
	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionRequest() 
	{
		$model=new ArticleJournals;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['ArticleJournals'])) {
			$model->attributes=$_POST['ArticleJournals'];
			
			if($model->save()) {
				$url = Yii::app()->controller->createUrl('request', array('email'=>$model->user_email, 'name'=>$model->user_displayname));
				$this->redirect($url);
			}
		}

		$this->pageTitleShow = true;
		$this->pageTitle = Yii::t('phrase', 'Form Request Artikel Luar Negeri');
		$this->pageDescription = isset($_GET['email']) ? (isset($_GET['name']) ? Yii::t('phrase', 'Hi <strong>$1 ($2)</strong>, terimakasih telah menggunakan form request artikel luar negeri.', array('$1'=>$_GET['name'], '$2'=>$_GET['email'])) : Yii::t('phrase', 'Hi <strong>$1</strong>, terimakasih menggunakan form request artikel luar negeri.', array('$1'=>$_GET['email']))) : '';
		$this->pageMeta = '';
		$this->render('front_request', array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id) 
	{
		$model = ArticleJournals::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404, Yii::t('phrase', 'The requested page does not exist.'));
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model) 
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='article-journals-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
