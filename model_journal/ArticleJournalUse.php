<?php
/**
 * ArticleJournalUse
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2017 Ommu Platform (www.ommu.co)
 * @created date 20 July 2017, 06:51 WIB
 * @link https://github.com/ommu/plu-article-journal
 *
 * This is the template for generating the model class of a specified table.
 * - $this: the ModelCode object
 * - $tableName: the table name for this class (prefix is already removed if necessary)
 * - $modelClass: the model class name
 * - $columns: list of table columns (name=>CDbColumnSchema)
 * - $labels: list of attribute labels (name=>label)
 * - $rules: list of validation rules
 * - $relations: list of relations (name=>relation declaration)
 *
 * --------------------------------------------------------------------------------------
 *
 * This is the model class for table "ommu_article_journal_use".
 *
 * The followings are the available columns in table 'ommu_article_journal_use':
 * @property integer $use_id
 * @property integer $publish
 * @property integer $name
 * @property integer $desc
 * @property string $creation_date
 * @property string $creation_id
 * @property string $modified_date
 * @property string $modified_id
 *
 * The followings are the available model relations:
 * @property ArticleJournals[] $article_journals
 * @property Users[] $creation;
 * @property Users[] $modified;
 */
class ArticleJournalUse extends CActiveRecord
{
	public $defaultColumns = array();
	public $title_i;
	public $description_i;

	// Variable Search	
	public $creation_search;
	public $modified_search;

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ArticleJournalUse the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ommu_article_journal_use';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('
				title_i, description_i', 'required'),
			array('publish, name, desc', 'numerical', 'integerOnly'=>true),
			array('creation_id, modified_id', 'length', 'max'=>11),
			array('
				title_i', 'length', 'max'=>32),
			array('
				description_i', 'length', 'max'=>128),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('use_id, publish, name, desc, creation_date, creation_id, modified_date, modified_id, 
				title_i, description_i, creation_search, modified_search', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'title' => array(self::BELONGS_TO, 'OmmuSystemPhrase', 'name'),
			'description' => array(self::BELONGS_TO, 'OmmuSystemPhrase', 'desc'),
			'creation' => array(self::BELONGS_TO, 'Users', 'creation_id'),
			'modified' => array(self::BELONGS_TO, 'Users', 'modified_id'),
			'journals' => array(self::HAS_MANY, 'ArticleJournals', 'use_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'use_id' => Yii::t('attribute', 'Use'),
			'publish' => Yii::t('attribute', 'Publish'),
			'name' => Yii::t('attribute', 'Name'),
			'desc' => Yii::t('attribute', 'Desc'),
			'creation_date' => Yii::t('attribute', 'Creation Date'),
			'creation_id' => Yii::t('attribute', 'Creation'),
			'modified_date' => Yii::t('attribute', 'Modified Date'),
			'modified_id' => Yii::t('attribute', 'Modified'),
			'title_i' => Yii::t('attribute', 'Used'),
			'description_i' => Yii::t('attribute', 'Description'),
			'creation_search' => Yii::t('attribute', 'Creation'),
			'modified_search' => Yii::t('attribute', 'Modified'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		// Custom Search
		$defaultLang = OmmuLanguages::getDefault('code');
		if(isset(Yii::app()->session['language']))
			$language = Yii::app()->session['language'];
		else 
			$language = $defaultLang;
		$criteria->with = array(
			'title' => array(
				'alias'=>'title',
				'select'=>$language,
			),
			'description' => array(
				'alias'=>'description',
				'select'=>$language,
			),
			'creation' => array(
				'alias'=>'creation',
				'select'=>'displayname'
			),
			'modified' => array(
				'alias'=>'modified',
				'select'=>'displayname'
			),
		);
		
		$criteria->compare('t.use_id', $this->use_id);
		if(Yii::app()->getRequest()->getParam('type') == 'publish')
			$criteria->compare('t.publish', 1);
		elseif(Yii::app()->getRequest()->getParam('type') == 'unpublish')
			$criteria->compare('t.publish', 0);
		elseif(Yii::app()->getRequest()->getParam('type') == 'trash')
			$criteria->compare('t.publish', 2);
		else {
			$criteria->addInCondition('t.publish', array(0,1));
			$criteria->compare('t.publish', $this->publish);
		}
		$criteria->compare('t.name', $this->name);
		$criteria->compare('t.desc', $this->desc);
		if($this->creation_date != null && !in_array($this->creation_date, array('0000-00-00 00:00:00','1970-01-01 00:00:00','0002-12-02 07:07:12','-0001-11-30 00:00:00')))
			$criteria->compare('date(t.creation_date)', date('Y-m-d', strtotime($this->creation_date)));
		if(Yii::app()->getRequest()->getParam('creation'))
			$criteria->compare('t.creation_id', Yii::app()->getRequest()->getParam('creation'));
		else
			$criteria->compare('t.creation_id', $this->creation_id);
		if($this->modified_date != null && !in_array($this->modified_date, array('0000-00-00 00:00:00','1970-01-01 00:00:00','0002-12-02 07:07:12','-0001-11-30 00:00:00')))
			$criteria->compare('date(t.modified_date)', date('Y-m-d', strtotime($this->modified_date)));
		if(Yii::app()->getRequest()->getParam('modified'))
			$criteria->compare('t.modified_id', Yii::app()->getRequest()->getParam('modified'));
		else
			$criteria->compare('t.modified_id', $this->modified_id);
		
		$criteria->compare('title.'.$language, strtolower($this->title_i), true);
		$criteria->compare('description.'.$language, strtolower($this->description_i), true);
		$criteria->compare('creation.displayname', strtolower($this->creation_search), true);
		$criteria->compare('modified.displayname', strtolower($this->modified_search), true);

		if(!Yii::app()->getRequest()->getParam('ArticleJournalUse_sort'))
			$criteria->order = 't.use_id DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>30,
			),
		));
	}


	/**
	 * Get column for CGrid View
	 */
	public function getGridColumn($columns=null) {
		if($columns !== null) {
			foreach($columns as $val) {
				/*
				if(trim($val) == 'enabled') {
					$this->defaultColumns[] = array(
						'name'  => 'enabled',
						'value' => '$data->enabled == 1? "Ya": "Tidak"',
					);
				}
				*/
				$this->defaultColumns[] = $val;
			}
		} else {
			//$this->defaultColumns[] = 'use_id';
			$this->defaultColumns[] = 'publish';
			$this->defaultColumns[] = 'name';
			$this->defaultColumns[] = 'desc';
			$this->defaultColumns[] = 'creation_date';
			$this->defaultColumns[] = 'creation_id';
			$this->defaultColumns[] = 'modified_date';
			$this->defaultColumns[] = 'modified_id';
		}

		return $this->defaultColumns;
	}

	/**
	 * Set default columns to display
	 */
	protected function afterConstruct() {
		if(count($this->defaultColumns) == 0) {
			/*
			$this->defaultColumns[] = array(
				'class' => 'CCheckBoxColumn',
				'name' => 'id',
				'selectableRows' => 2,
				'checkBoxHtmlOptions' => array('name' => 'trash_id[]')
			);
			*/
			$this->defaultColumns[] = array(
				'header' => 'No',
				'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
			);
			$this->defaultColumns[] = array(
				'name' => 'title_i',
				'value' => 'Phrase::trans($data->name)',
			);
			/*
			$this->defaultColumns[] = array(
				'name' => 'description_i',
				'value' => 'Phrase::trans($data->desc)',
			);
			*/
			if(!Yii::app()->getRequest()->getParam('creation')) {
				$this->defaultColumns[] = array(
					'name' => 'creation_search',
					'value' => '$data->creation->displayname',
				);
			}
			$this->defaultColumns[] = array(
				'name' => 'creation_date',
				'value' => 'Utility::dateFormat($data->creation_date)',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => Yii::app()->controller->widget('application.libraries.core.components.system.CJuiDatePicker', array(
					'model'=>$this,
					'attribute'=>'creation_date',
					'language' => 'en',
					'i18nScriptFile' => 'jquery-ui-i18n.min.js',
					//'mode'=>'datetime',
					'htmlOptions' => array(
						'id' => 'creation_date_filter',
					),
					'options'=>array(
						'showOn' => 'focus',
						'dateFormat' => 'yy-mm-dd',
						'showOtherMonths' => true,
						'selectOtherMonths' => true,
						'changeMonth' => true,
						'changeYear' => true,
						'showButtonPanel' => true,
					),
				), true),
			);
			if(!Yii::app()->getRequest()->getParam('type')) {
				$this->defaultColumns[] = array(
					'name' => 'publish',
					'value' => 'Utility::getPublish(Yii::app()->controller->createUrl(\'publish\', array(\'id\'=>$data->use_id,\'plugin\'=>\'journal\')), $data->publish)',
					'htmlOptions' => array(
						'class' => 'center',
					),
					'filter'=>array(
						1=>Yii::t('phrase', 'Yes'),
						0=>Yii::t('phrase', 'No'),
					),
					'type' => 'raw',
				);
			}
		}
		parent::afterConstruct();
	}

	/**
	 * User get information
	 */
	public static function getInfo($id, $column=null)
	{
		if($column != null) {
			$model = self::model()->findByPk($id, array(
				'select' => $column,
			));
 			if(count(explode(',', $column)) == 1)
 				return $model->$column;
 			else
 				return $model;
			
		} else {
			$model = self::model()->findByPk($id);
			return $model;
		}
	}

	/**
	 * before validate attributes
	 */
	protected function beforeValidate() 
	{
		if(parent::beforeValidate()) {
			if($this->isNewRecord)
				$this->creation_id = Yii::app()->user->id;
			else
				$this->modified_id = Yii::app()->user->id;
		}
		return true;
	}
	
	/**
	 * before save attributes
	 */
	protected function beforeSave() 
	{
		$currentModule = strtolower(Yii::app()->controller->module->id.'/'.Yii::app()->controller->id);
		$location = Utility::getUrlTitle($currentModule);
		
		if(parent::beforeSave()) {
			if($this->isNewRecord || (!$this->isNewRecord && $this->name == 0)) {
				$title=new OmmuSystemPhrase;
				$title->location = $location.'_title';
				$title->en_us = $this->title_i;
				if($title->save())
					$this->name = $title->phrase_id;
				
			} else {
				$title = OmmuSystemPhrase::model()->findByPk($this->name);
				$title->en_us = $this->title_i;
				$title->save();
			}
			
			if($this->isNewRecord || (!$this->isNewRecord && $this->desc == 0)) {
				$desc=new OmmuSystemPhrase;
				$desc->location = $location.'_description';
				$desc->en_us = $this->description_i;
				if($desc->save())
					$this->desc = $desc->phrase_id;
				
			} else {
				$desc = OmmuSystemPhrase::model()->findByPk($this->desc);
				$desc->en_us = $this->description_i;
				$desc->save();
				
			}
		}
		return true;
	}

}