<?php

/**
 * Migration needed to convert old category titles
 * Category / Subcategory to InCategory / SubInCategory
 *
 * @author
 */
class m141126_082100_update_category_title extends CDbMigration
{
    public function up()
    {
        // Not using builtin CdbCommand class because REPLACE function is db dependent
        $conversionPattern = array('Category' => 'InCategory', 'Subcategory' => 'SubInCategory');

        $categories = Category::model()->findAll();
        foreach ($categories as $category) {
            $category->saveAttributes(array(
                'category_title' => str_replace(array_keys($conversionPattern), $conversionPattern, $category->category_title)
            ));
        }
    }

    public function down()
    {
        // Not using builtin CdbCommand class because REPLACE function is db dependent
        $conversionPattern = array('SubInCategory' => 'Subcategory', 'InCategory' => 'Category');

        $categories = Category::model()->findAll();
        foreach ($categories as $category) {
            $category->saveAttributes(array(
                'category_title' => str_replace(array_keys($conversionPattern), $conversionPattern, $category->category_title)
            ));
        }
    }

}


