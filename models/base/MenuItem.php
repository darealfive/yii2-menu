<?php
/**
 * MenuItem class file
 *
 * @author Sebastian Krein <sebastian@itstrategen.de>
 */

namespace darealfive\menu\models\base;

use darealfive\base\components\CacheableActiveRecord;

/**
 * This is the model class for table "navigation".
 *
 * @package darealfive\menu\models\base
 *
 * @property int        $id
 * @property int        $parent_id
 * @property string     $title
 * @property int        $position
 *
 * The followings are the available model relations:
 * @property MenuItem   $parent   the parent menu item
 * @property MenuItem[] $children the child menu items
 */
abstract class MenuItem extends CacheableActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu_item';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'id'        => 'ID',
            'parent_id' => 'Parent ID',
            'title'     => 'Title',
            'position'  => 'Position',
        ]);
    }

    /**
     * @return ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(static::class, ['id' => 'parent_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getChildren()
    {
        return $this->hasMany(static::class, ['parent_id' => 'id']);
    }
}