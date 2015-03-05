<?php

class m141023_144830_db_refactor extends CDbMigration
{
	public function up()
	{
		// rename tables
		$this->renameTable('Users', 'user');
		$this->renameTable('Items', 'item');
		$this->renameTable('Categories', 'category');
		
		// rename columns
		$this->lowercaseColumnNames('user');
		$this->lowercaseColumnNames('item');
		$this->lowercaseColumnNames('category');
		
		// add nested tree columns to category
		$this->addColumn('category', Category::ATTR_LEVEL, 'integer');
		$this->addColumn('category', Category::ATTR_PARENT, 'integer');
		$this->addColumn('category', Category::ATTR_LEFT, 'integer');
		$this->addColumn('category', Category::ATTR_RIGHT, 'integer');
			// update table structure in cache
			$this->getDbConnection()->getSchema()->getTable('category', true);
			
		// add new column to item table
		$this->addColumn('item', 'item_end_time', 'DATETIME');
		
		// move subcategories to the category table
		
		// first get all categories
		$root_categories = array(); $i = 1;
		$_categories = Category::model()->findAll();
		foreach($_categories as $cat)
		{
			// update $cat
			$cat->scenario = 'manual';
			$cat->attributes = array(
				Category::ATTR_LEFT => $i,
				Category::ATTR_RIGHT => ++$i,
				Category::ATTR_LEVEL => '0',
				Category::ATTR_PARENT => 0,
			);
			$cat->saveNode();
			$root_categories[ $cat->id ] = $cat;
		}
		
		// now get subcategories
		$subcategories = $this->getDbConnection()->createCommand()
				->select()
				->from('Subcategories')
				->queryAll();
		$subcategories_ids_match = array();
		
		// loop the subcategories and use nested behavior to insert them
		foreach($subcategories as $subcat)
		{
			$cat = new Category;
			$cat->attributes = array(
				Category::ATTR_PARENT => $subcat['CategoryID'],
				'category_title' => $subcat['SubcategoryTitle'],
			);
			$cat->appendTo( $root_categories[ $subcat['CategoryID'] ] );
			$subcategories_ids_match[ $subcat['SubcategoryID'] ] = $cat->id;
		}

		// remove mentioning of subcategory table
		$this->renameColumn('user', 'user_subcategory_id', 'user_category_id');
		$this->renameColumn('item', 'item_subcategory_id', 'item_category_id');
		$this->alterColumn('user', 'user_category_id', 'integer NULL DEFAULT NULL');
		$this->alterColumn('item', 'item_category_id', 'integer NULL DEFAULT NULL');
		$this->getDbConnection()->createCommand( 'UPDATE `user` SET user_category_id = NULL WHERE user_category_id = 0' )->execute();
		$this->getDbConnection()->createCommand( 'UPDATE `item` SET item_category_id = NULL WHERE item_category_id = 0' )->execute();
		
		// add indexes
		$this->createIndex(Category::ATTR_PARENT, 'category', Category::ATTR_PARENT);
		$this->addForeignKey('FK_user_category_id', 'user', 'user_category_id', 'category', 'id', 'SET NULL', 'RESTRICT');
		$this->addForeignKey('FK_item_category_id', 'item', 'item_category_id', 'category', 'id', 'SET NULL', 'RESTRICT');
		
		// update user/item tables with new ids
		$need_update['user'] = $this->getDbConnection()->createCommand()
				->select()
				->from('user')
				->queryAll();
		$need_update['item'] = $this->getDbConnection()->createCommand()
				->select()
				->from('item')
				->queryAll();
		foreach($need_update as $table => $rows)
		{
			$category_field = ($table == 'users')? 'user_category_id' : 'item_category_id';
			foreach($rows as $row)
			{
				if( empty($row[$category_field]) ) continue;
				
				$new_cat_id = $subcategories_ids_match[ $row[$category_field] ];
				$update_sql = "UPDATE `$table` SET $category_field = $new_cat_id WHERE id = {$row['id']}";
				$this->getDbConnection()->createCommand( $update_sql )->execute();
			}
		}
		
		$this->dropTable('Subcategories');
	}
	
	/**
	 * get full lost of columns and run command to lowercase them
	 * @param string $table_name
	 */
	private function lowercaseColumnNames( $table_name, $force_primary_key_name = 'id' )
	{
		$table = $this->getDbConnection()->getSchema()->getTable($table_name);
		if( !empty($table) )
		{
			/* @var $column CMysqlColumnSchema */
			foreach($table->columns as $column_name => $column)
			{
				$new_column_name = strtolower(preg_replace('/(.)([A-Z])/', '$1_$2', $column_name));
				
				// rename columns to match same field prefixes
				if( strpos($new_column_name, $table_name.'_') !== 0 )
					$new_column_name = $table_name.'_'.$new_column_name;
				
				// special names for primary keys
				if( $force_primary_key_name && $column->isPrimaryKey )
					$new_column_name = $force_primary_key_name;
				
				$this->renameColumn($table_name, $column_name, $new_column_name);
			}
			
			// update table structure in cache
			$this->getDbConnection()->getSchema()->getTable($table_name, true);
		}
	}
	
	public function down()
	{
		echo "m141023_144830_db_refactor does not support migration down.\n";
		return false;
	}

}