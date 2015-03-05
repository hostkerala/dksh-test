<?php

class m141228_184630_category_populate extends CDbMigration
{
	public function safeUp()
	{
		$root = Category::model()->findByPk(1);
		$category = new Category('create');
		$category->category_title = 'SubInCategory 1.4';
		$category->category_type = Category::TYPE_DEFAULT;
		$category->nested_parent = $root->id;
		$category->appendTo($root);

		$secondCategory = new Category('create');
		$secondCategory->category_title = 'SubInCategory 1.5';
		$secondCategory->category_type = Category::TYPE_DEFAULT;
		$secondCategory->nested_parent = $root->id;
		$secondCategory->insertAfter($category);
	}

	public function safeDown()
	{
		Category::model()->findByAttributes(array('category_title' => 'SubInCategory 1.4'))->deleteNode();
		Category::model()->findByAttributes(array('category_title' => 'SubInCategory 1.5'))->deleteNode();
	}
}