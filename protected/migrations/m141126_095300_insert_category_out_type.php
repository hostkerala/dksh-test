<?php

/**
 * Migration responsible for inserting new type of categories (OutCategories)
 *
 * @author
 */
class m141126_095300_insert_category_out_type extends CDbMigration
{
    /*
     * Fixture like data for inserting
     */
    private $outCategoriesData = array(
        array(
            'category_title' => 'OutCategory 1',
            'nested_level' => 0,
            'nested_parent' => 0
        ),
        array(
            'category_title' => 'OutCategory 2',
            'nested_level' => 0,
            'nested_parent' => 0
        ),
    );

    private $subOutCategoriesData = array(
        'OutCategory 1' => array(
            array('category_title' => 'SubOutCategory 1.1',),
            array('category_title' => 'SubOutCategory 1.2',),
            array('category_title' => 'SubOutCategory 1.3'),
        ),
        'OutCategory 2' => array(
            array('category_title' => 'SubOutCategory 2.1'),
        ),
    );


    /**
     * Migration is based on plain insert commands, to maintain backward compatibility of migrations
     * Using CActiveRecord in migrations is risky task, because it depends on the sourcecode, not plain database
     * operations. In this case, NestedSetBehavior is blocking adding new root nodes, because original developer
     * set 'hasManyRoots' option to FALSE.
     */
    public function up()
    {
        // set old records to InCategories (default)
        $this->addColumn('category', 'category_type', 'integer DEFAULT ' . Category::TYPE_DEFAULT);

        // getting max nested level
        $maxNestedLevel = Category::model()->find(array('order' => 'nested_right DESC'));
        $maxNestedLevel = (empty($maxNestedLevel)) ? 1 : $maxNestedLevel->nested_right;

        $outCategoryInsert = "
            INSERT INTO category (category_title, nested_level, nested_parent, nested_left, nested_right, category_type)
            VALUES (:category_title, :nested_level, :nested_parent, :nested_left, :nested_right, :category_type)";

        foreach ($this->outCategoriesData as $outCategoryData) {
            $insertCommand = $this->getDbConnection()->createCommand($outCategoryInsert);
            $insertCommand->bindValue(":category_title", $outCategoryData['category_title']);
            $insertCommand->bindValue(":category_type", Category::TYPE_OUT);
            $insertCommand->bindValue(":nested_level", 0);
            $insertCommand->bindValue(":nested_parent", 0);
            $insertCommand->bindValue(":nested_left", $maxNestedLevel);
            $insertCommand->bindValue(":nested_right",
                $maxNestedLevel + count($this->subOutCategoriesData[$outCategoryData['category_title']]) * 2 + 1);
            $insertCommand->execute();

            // obtain outCategoryId from current database session
            $outCategoryId = Yii::app()->db->getLastInsertId();

            foreach ($this->subOutCategoriesData[$outCategoryData['category_title']] as $subOutCategoryData) {
                $insertCommand = $this->getDbConnection()->createCommand($outCategoryInsert);
                $insertCommand->bindValue(":category_title", $subOutCategoryData['category_title']);
                $insertCommand->bindValue(":category_type", Category::TYPE_OUT);
                $insertCommand->bindValue(":nested_level", 1);
                $insertCommand->bindValue(":nested_parent", $outCategoryId);
                $insertCommand->bindValue(":nested_left", ++$maxNestedLevel);
                $insertCommand->bindValue(":nested_right", ++$maxNestedLevel);
                $insertCommand->execute();
            }
            $maxNestedLevel++;
        }
    }

    public function down()
    {
        $this->getDbConnection()->createCommand('DELETE FROM category WHERE category_type = '.Category::TYPE_OUT)->execute();
        return $this->dropColumn('category', 'category_type');
    }

}


