<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "roles".
 *
 * @property int $user_access_id
 * @property string $name
 *
 * @property User[] $users
 */
class Roles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'roles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_access_id' => 'User Access ID',
            'name' => 'Name',
        ];
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery|\app\models\query\UserQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::class, ['user_access' => 'user_access_id']);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\RolesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\RolesQuery(get_called_class());
    }
}
