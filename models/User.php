<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $fk_employee_id
 * @property string $email
 * @property string $password_hash
 * @property int|null $status
 * @property string|null $password_reset_token
 * @property string|null $user_access
 * @property int $availability
 * @property string $created_at
 * @property string|null $updated_at
 * @property string|null $auth_key
 * @property string|null $verification_token
 * @property string|null $managers_code
 */
class User extends ActiveRecord implements IdentityInterface
{
    public $old_password;
    public $new_password;
    public $confirm_new_password;

    public $password;
    public $confirmPassword;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'email', 'password_hash'], 'required'],
            [['status', 'availability', 'user_access'], 'integer'],
            [['username', 'email', 'password_hash'], 'string', 'max' => 100],
            ['email', 'email'],
            ['username', 'unique', 'message' => 'This username has already been taken.'],
            [['fk_employee_id'], 'string', 'max' => 30],
            [['password_reset_token', 'created_at', 'updated_at', 'auth_key', 'verification_token', 'managers_code'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'fk_employee_id' => 'Fk Employee ID',
            'email' => 'Email',
            'password_hash' => 'Password Hash',
            'status' => 'Status',
            'password_reset_token' => 'Password Reset Token',
            'user_access' => 'User Access',
            'availability' => 'Availability',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'auth_key' => 'Auth Key',
            'verification_token' => 'Verification Token',
            'managers_code' => 'Managers Code',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return self::find()->where(['accessToken' => $token])->one();
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return self::findOne(['username' => $username]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password_hash password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password_hash)
    {
        return Yii::$app->security->validatePassword($password_hash, $this->password_hash);
    }

    public function getRoles()
    {
        return $this->hasOne(Roles::class, ['user_access_id' => 'user_access']);
    }

    public function fetchAndMapData($modelClass, $valueField, $textField)
    {
        $data = $modelClass::find()->select([$valueField, $textField])->asArray()->all();
        return \yii\helpers\ArrayHelper::map($data, $valueField, $textField);
    }


}
