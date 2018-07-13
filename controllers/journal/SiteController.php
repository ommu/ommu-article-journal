<?php
/**
 * SiteController
 * @var $this SiteController
 * @var $model ArticleJournals
 * @var $form CActiveForm
 *
 * Reference start
 * TOC :
 *	Index
 *	View
 *	Manage
 *	Add
 *	Edit
 *	RunAction
 *	Delete
 *	Publish
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

class SiteController extends Controller
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
		if(!Yii::app()->user->isGuest) {
			if(Yii::app()->user->level == 1) {
				$arrThemes = $this->currentTemplate('admin');
				Yii::app()->theme = $arrThemes['folder'];
				$this->layout = $arrThemes['layout'];
			} else
				throw new CHttpException(404, Yii::t('phrase', 'The requested page does not exist.'));
		} else
			$this->redirect(Yii::app()->createUrl('site/login'));
		
		/*
		$arrThemes = $this->currentTemplate('public');
		Yii::app()->theme = $arrThemes['folder'];
		$this->layout = $arrThemes['layout'];
		*/
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
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array(),
				'users'=>array('@'),
				'expression'=>'isset(Yii::app()->user->level)',
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('manage','add','edit','runaction','delete','publish','headline'),
				'users'=>array('@'),
				'expression'=>'isset(Yii::app()->user->level) && (Yii::app()->user->level == 1)',
				//'expression'=>'isset(Yii::app()->user->level) && (in_array(Yii::app()->user->level, array(1,2)))',
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
		$arrThemes = $this->currentTemplate('public');
		Yii::app()->theme = $arrThemes['folder'];
		$this->layout = $arrThemes['layout'];
		$this->applyCurrentTheme($this->module);
		
		$setting = ArticleJournals::model()->findByPk(1, array(
			'select' => 'meta_description, meta_keyword',
		));

		$criteria=new CDbCriteria;
		$criteria->condition = 'publish = :publish';
		$criteria->params = array(':publish'=>1);
		$criteria->order = 'creation_date DESC';

		$dataProvider = new CActiveDataProvider('ArticleJournals', array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>10,
			),
		));

		$this->pageTitle = Yii::t('phrase', 'Article Journals');
		$this->pageDescription = $setting->meta_description;
		$this->pageMeta = $setting->meta_keyword;
		$this->render('front_index', array(
			'dataProvider'=>$dataProvider,
		));
		//$this->redirect(array('manage'));
	}
	
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id) 
	{
		$arrThemes = $this->currentTemplate('public');
		Yii::app()->theme = $arrThemes['folder'];
		$this->layout = $arrThemes['layout'];
		$this->applyCurrentTheme($this->module);
		
		$setting = VideoSetting::model()->findByPk(1, array(
			'select' => 'meta_keyword',
		));

		$model=$this->loadModel($id);

		$this->pageTitle = Yii::t('phrase', 'View Article Journals');
		$this->pageDescription = '';
		$this->pageMeta = $setting->meta_keyword;
		$this->render('front_view', array(
			'model'=>$model,
		));
		/*
		$this->render('admin_view', array(
			'model'=>$model,
		));
		*/
	}	

	/**
	 * Manages all models.
	 */
	public function actionManage() 
	{
		$model=new ArticleJournals('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ArticleJournals'])) {
			$model->attributes=$_GET['ArticleJournals'];
		}

		$columns = $model->getGridColumn($this->gridColumnTemp());

		$this->pageTitle = Yii::t('phrase', 'Article Journals');
		$this->pageDescription = '';
		$this->pageMeta = '';
		$this->render('admin_manage', array(
			'model'=>$model,
			'columns' => $columns,
		));
	}	
	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionAdd() 
	{
		$model=new ArticleJournals;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['ArticleJournals'])) {
			$model->attributes=$_POST['ArticleJournals'];

			/* 
			$jsonError = CActiveForm::validate($model);
			if(strlen($jsonError) > 2) {
				//echo $jsonError;
				$errors = $model->getErrors();
				$summary['msg'] = "<div class='errorSummary'><strong>".Yii::t('phrase', 'Please fix the following input errors:')."</strong>";
				$summary['msg'] .= "<ul>";
				foreach($errors as $key => $value) {
					$summary['msg'] .= "<li>{$value[0]}</li>";
				}
				$summary['msg'] .= "</ul></div>";

				$message = json_decode($jsonError, true);
				$merge = array_merge_recursive($summary, $message);
				$encode = json_encode($merge);
				echo $encode;

			} else {
				if(Yii::app()->getRequest()->getParam('enablesave') == 1) {
					if($model->save()) {
						echo CJSON::encode(array(
							'type' => 5,
							'get' => Yii::app()->controller->createUrl('manage', array('plugin'=>'journal')),
							'id' => 'partial-article-journals',
							'msg' => '<div class="errorSummary success"><strong>'.Yii::t('phrase', 'Article Journals success created.').'</strong></div>',
						));
					} else {
						print_r($model->getErrors());
					}
				}
			}
			Yii::app()->end();
			*/

			if(Yii::app()->getRequest()->getParam('enablesave') == 1) {
				if($model->save()) {
					Yii::app()->user->setFlash('success', Yii::t('phrase', 'ArticleJournals success created.'));
					//$this->redirect(array('view','id'=>$model->journal_id));
					$this->redirect(array('manage'));
				}
			}
		}
		
		$this->dialogDetail = true; 
		$this->dialogGroundUrl = Yii::app()->controller->createUrl('manage', array('plugin'=>'journal')); 
		$this->dialogWidth = 600; 

		$this->pageTitle = Yii::t('phrase', 'Create Article Journals');
		$this->pageDescription = '';
		$this->pageMeta = '';
		$this->render('admin_add', array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionEdit($id) 
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['ArticleJournals'])) {
			$model->attributes=$_POST['ArticleJournals'];

			/* 
			$jsonError = CActiveForm::validate($model);
			if(strlen($jsonError) > 2) {
				//echo $jsonError;
				$errors = $model->getErrors();
				$summary['msg'] = "<div class='errorSummary'><strong>".Yii::t('phrase', 'Please fix the following input errors:')."</strong>";
				$summary['msg'] .= "<ul>";
				foreach($errors as $key => $value) {
					$summary['msg'] .= "<li>{$value[0]}</li>";
				}
				$summary['msg'] .= "</ul></div>";

				$message = json_decode($jsonError, true);
				$merge = array_merge_recursive($summary, $message);
				$encode = json_encode($merge);
				echo $encode;

			} else {
				if(Yii::app()->getRequest()->getParam('enablesave') == 1) {
					if($model->save()) {
						echo CJSON::encode(array(
							'type' => 5,
							'get' => Yii::app()->controller->createUrl('manage', array('plugin'=>'journal')),
							'id' => 'partial-article-journals',
							'msg' => '<div class="errorSummary success"><strong>'.Yii::t('phrase', 'Article Journals success updated.').'</strong></div>',
						));
					} else {
						print_r($model->getErrors());
					}
				}
			}
			Yii::app()->end();
			*/

			if(Yii::app()->getRequest()->getParam('enablesave') == 1) {
				if($model->save()) {
					Yii::app()->user->setFlash('success', Yii::t('phrase', 'ArticleJournals success updated.'));
					//$this->redirect(array('view','id'=>$model->journal_id));
					$this->redirect(array('manage'));
				}
			}
		}
		
		$this->dialogDetail = true; 
		$this->dialogGroundUrl = Yii::app()->controller->createUrl('manage', array('plugin'=>'journal')); 
		$this->dialogWidth = 600; 

		$this->pageTitle = Yii::t('phrase', 'Update Article Journals');
		$this->pageDescription = '';
		$this->pageMeta = '';
		$this->render('admin_edit', array(
			'model'=>$model,
		));
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionRunAction() {
		$id       = $_POST['trash_id'];
		$criteria = null;
		$actions  = Yii::app()->getRequest()->getParam('action');

		if(count($id) > 0) {
			$criteria = new CDbCriteria;
			$criteria->addInCondition('journal_id', $id);

			if($actions == 'publish') {
				ArticleJournals::model()->updateAll(array(
					'publish' => 1,
				),$criteria);
			} elseif($actions == 'unpublish') {
				ArticleJournals::model()->updateAll(array(
					'publish' => 0,
				),$criteria);
			} elseif($actions == 'trash') {
				ArticleJournals::model()->updateAll(array(
					'publish' => 2,
				),$criteria);
			} elseif($actions == 'delete') {
				ArticleJournals::model()->deleteAll($criteria);
			}
		}

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!Yii::app()->getRequest()->getParam('ajax')) {
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('manage'));
		}
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id) 
	{
		$model=$this->loadModel($id);
		
		if(Yii::app()->request->isPostRequest) {
			// we only allow deletion via POST request
			$model->publish = 2;
			
			if($model->save()) {
				echo CJSON::encode(array(
					'type' => 5,
					'get' => Yii::app()->controller->createUrl('manage', array('plugin'=>'journal')),
					'id' => 'partial-article-journals',
					'msg' => '<div class="errorSummary success"><strong>'.Yii::t('phrase', 'Article Journals success deleted.').'</strong></div>',
				));
			}

		} else {
			$this->dialogDetail = true;
			$this->dialogGroundUrl = Yii::app()->controller->createUrl('manage', array('plugin'=>'journal'));
			$this->dialogWidth = 350;

			$this->pageTitle = Yii::t('phrase', 'Delete Article Journals');
			$this->pageDescription = '';
			$this->pageMeta = '';
			$this->render('admin_delete');
		}
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionPublish($id) 
	{
		$model=$this->loadModel($id);
		
		$title = $model->publish == 1 ? Yii::t('phrase', 'Unpublish') : Yii::t('phrase', 'Publish');
		$replace = $model->publish == 1 ? 0 : 1;

		if(Yii::app()->request->isPostRequest) {
			// we only allow deletion via POST request
			//change value active or publish
			$model->publish = $replace;

			if($model->update()) {
				echo CJSON::encode(array(
					'type' => 5,
					'get' => Yii::app()->controller->createUrl('manage', array('plugin'=>'journal')),
					'id' => 'partial-article-journals',
					'msg' => '<div class="errorSummary success"><strong>'.Yii::t('phrase', 'Article Journals success updated.').'</strong></div>',
				));
			}

		} else {
			$this->dialogDetail = true;
			$this->dialogGroundUrl = Yii::app()->controller->createUrl('manage', array('plugin'=>'journal'));
			$this->dialogWidth = 350;

			$this->pageTitle = Yii::t('phrase', '$title Article Journals', array('$title'=>$title));
			$this->pageDescription = '';
			$this->pageMeta = '';
			$this->render('admin_publish', array(
				'title'=>$title,
				'model'=>$model,
			));
		}
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
