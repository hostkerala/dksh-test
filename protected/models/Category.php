<?php

/**
 * This is the model class for table "category".
 *
 * The followings are the available columns in table 'category':
 * @property integer $id
 * @property string $category_title
 * @property integer $nested_level
 * @property integer $nested_parent
 * @property integer $nested_root
 * @property integer $nested_left
 * @property integer $nested_right
 * @property boolean $category_type
 *
 * @mixin NestedSetBehavior
 */
class Category extends CActiveRecord
{
	// IDs in DB for using in code
	const ID_IN_4 = 4;

	const ID_SUB_IN_1_1 = 6;
	const ID_SUB_IN_1_2 = 7;
	const ID_SUB_IN_1_3 = 8;
	const ID_SUB_IN_1_4 = 20;
	const ID_SUB_IN_1_5 = 21;

	const ATTR_LEFT  = 'nested_left';
	const ATTR_RIGHT = 'nested_right';
	const ATTR_LEVEL = 'nested_level';
	const ATTR_PARENT  = 'nested_parent';

    const TYPE_DEFAULT = 1;
    const TYPE_OUT = 2;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'category';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		$nested_attributes = array(
			self::ATTR_LEFT,
			self::ATTR_RIGHT,
			self::ATTR_PARENT,
			self::ATTR_LEVEL,
		);
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('category_title', 'required'),
			array('category_title', 'length', 'max'=>255),

			array(self::ATTR_PARENT, 'required'),
			array(self::ATTR_PARENT, 'numerical', 'integerOnly'=>true),

			array(implode(',', $nested_attributes), 'safe', 'on' => 'manual'),

            // The following rule is used to maintain compatibility with m141023_144830_db_refactor migration
            // Otherwise it will break for every new project member
            array('category_type', 'default', 'value' => Category::TYPE_DEFAULT, 'on'=>'create'),
            array('category_type', 'numerical', 'integerOnly'=>true, 'on'=>'create'),
            array('category_type','in','range'=>array(self::TYPE_DEFAULT,self::TYPE_OUT),'allowEmpty'=>false, 'on'=>'create'),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, category_title, category_type', 'safe', 'on'=>'search'),
		);
	}

	/**
	 *	add behaviors (tree structure)
	 */
	public function behaviors()
	{
		return array(
			'NestedSetBehavior' => array(
				'class' => 'ext.behaviors.NestedSetBehavior',
				'hasManyRoots' => false,
				'leftAttribute' => self::ATTR_LEFT,
				'rightAttribute' => self::ATTR_RIGHT,
				'levelAttribute' => self::ATTR_LEVEL,
			),
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
			'items' => array(self::HAS_MANY, 'Item', 'item_category_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'category_title' => 'Category Title',
			'nested_level' => 'Nested Level',
			'nested_parent' => 'Nested Parent',
			'nested_root' => 'Nested Root',
			'nested_left' => 'Nested Left',
			'nested_right' => 'Nested Right',
            'category_type' => 'Type',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('category_title', $this->category_title, true);
        $criteria->compare('category_type', $this->type);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Category the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getRelationalCategories()
	{
		$array = array(
			self::ID_SUB_IN_1_2 => array(self::ID_SUB_IN_1_5),
			self::ID_SUB_IN_1_3 => array(self::ID_SUB_IN_1_5),
			self::ID_SUB_IN_1_4 => array(self::ID_SUB_IN_1_1, self::ID_SUB_IN_1_2, self::ID_SUB_IN_1_3),
		);

		return array_key_exists($this->id, $array) ? $array[$this->id] : false;
	}
}