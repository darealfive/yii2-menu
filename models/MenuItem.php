<?php

namespace darealfive\menu\models;

/**
 * Class Navigation
 *
 * @package backend\models
 *
 * The followings are the available model relations:
 * @property MenuItem   $parent   the parent navigation element
 * @property MenuItem[] $children the child navigation elements
 */
class MenuItem extends base\MenuItem
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        $this->beforeSave();

        return [
            [['parent_id'], 'exist', 'targetAttribute' => 'id'],
            [['title'], 'required'],
            [['title'], 'string'],
            [['position'], 'integer'],
        ];
    }

    /**
     * Before saving the record update the value of position dependent on whether the parent record has changed, to the
     * highest position available within the new Navigation record set automatically.
     *
     * @param bool $insert
     *
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

            /*
             * If parent has changed determine the next highest position.
             */
            if (is_null($this->position) || $this->isAttributeChanged('parent_id')) {

                $this->position = $this::find()->where(['parent_id' => $this->parent_id])->max('position') + 1;
            }

            return true;
        }

        return false;
    }
}