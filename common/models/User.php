<?php
namespace common\models;

use Yii;
use yii\helpers\Html;
use yii\db\ActiveRecord;
use yii\web\HttpException;
use yii\web\IdentityInterface;
use yii\base\NotSupportedException;

/**
 * @property int $id
 * @property string|null $username
 * @property string|null $auth_key
 * @property string|null $password_hash
 * @property string|null $password_reset_token
 * @property string|null $name
 * @property string|null $phone
 * @property string|null $email
 * @property int|null $status
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $deleted_at
 * @property string|null $verification
 * @property string|null $role
 * @property int|null $user_created_id
 * @property string|null $user_created
 * @property int|null $user_updated_id
 * @property string|null $user_updated
 * @property int|null $user_deleted_id
 *
 * @property User $userCreated
 * @property User[] $users
 * @property User $userUpdated
 * @property User[] $users0
 * @property User $userDeleted
 * @property User[] $users1
 * @property UserRole[] $userRoles
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;

    public $roles;

    public static function tableName()
    {
        return '{{%user}}';
    }

    public function rules()
    {
        return [
            [['username', 'password_hash', 'status', 'roles'], 'required', 'message' => '{attribute} không được để trống'],
            [['email'], 'email', 'message' => '{attribute} chưa đúng định dạng'],
            [['status', 'user_created_id', 'user_updated_id', 'user_deleted_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['role'], 'string'],
            [['username', 'auth_key', 'password_hash', 'password_reset_token', 'name', 'email', 'verification', 'user_created',
                'user_updated'], 'string', 'max' => 100],
            [['phone'], 'string', 'max' => 20],
            [['user_created_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_created_id' => 'id']],
            [['user_updated_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_updated_id' => 'id']],
            [['user_deleted_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_deleted_id' => 'id']],
            [['username'], 'duplicateAttribute'],
            [['username'], 'validateUsername'],
        ];
    }

    public function duplicateAttribute($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = self::find()->andFilterWhere(["{$attribute}" => $this->$attribute])
                ->andFilterWhere(['in', 'status', [self::STATUS_ACTIVE, self::STATUS_INACTIVE]]);
            if(!$this->isNewRecord){
                $user->andFilterWhere(['<>', 'id', $this->id]);
            }

            if(!is_null($user->one())){
                $this->addError($attribute, "{$this->getAttributeLabel($attribute)} đã tồn tại");
            }
        }
    }

    public function validateUsername($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if(!preg_match("/^[a-z0-9]+$/", $this->{$attribute})){
                $this->addError($attribute, 'Trường chỉ bao gồm ký tự a-z và 0-9');
            }
        }
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Tên đăng nhập',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Mật khẩu',
            'password_reset_token' => 'Password Rest Token',
            'name' => 'Họ tên',
            'phone' => 'Điện thoại',
            'email' => 'Email',
            'status' => 'Trạng thái',
            'created_at' => 'Ngày tạo',
            'updated_at' => 'Ngày cập nhật',
            'deleted_at' => 'Ngày xóa',
            'verification' => 'Vertication',
            'role' => 'Vai trò',
            'user_created_id' => 'User Created ID',
            'user_created' => 'User Created',
            'user_updated_id' => 'User Updated ID',
            'user_updated' => 'User Updated',
            'user_deleted_id' => 'User Deleted ID',
            'roles' => 'Vai trò',
        ];
    }

    public function getUserCreated()
    {
        return $this->hasOne(User::className(), ['id' => 'user_created_id']);
    }

    public function getUsers()
    {
        return $this->hasMany(User::className(), ['user_created_id' => 'id']);
    }

    public function getUserUpdated()
    {
        return $this->hasOne(User::className(), ['id' => 'user_updated_id']);
    }

    public function getUsers0()
    {
        return $this->hasMany(User::className(), ['user_updated_id' => 'id']);
    }

    public function getUserDeleted()
    {
        return $this->hasOne(User::className(), ['id' => 'user_deleted_id']);
    }

    public function getUsers1()
    {
        return $this->hasMany(User::className(), ['user_deleted_id' => 'id']);
    }

    public function getUserRoless()
    {
        return $this->hasMany(UserRole::className(), ['user_id' => 'id']);
    }

    public static function getListStatus(){
        return [
            self::STATUS_ACTIVE => 'Hoạt động',
            self::STATUS_INACTIVE => 'Không hoạt động',
        ];
    }

    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    public static function findByVerificationToken($token) {
        return static::findOne([
            'verification_token' => $token,
            'status' => self::STATUS_INACTIVE
        ]);
    }

    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    public function generateEmailVerificationToken()
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public function beforeSave($insert)
    {
        if($insert){
            $this->created_at = date('Y-m-d H:i:s');
            $this->setPassword($this->password_hash);
            $this->user_created_id = Yii::$app->user->id;
            $this->user_created = $this->userCreated->name;
        }else{
            $this->updated_at = date('Y-m-d H:i:s');

            $old_user = User::findOne($this->id);
            $this->user_updated_id = Yii::$app->user->id;
            $this->user_updated = $this->userUpdated->name;
            if($this->password_hash !== $old_user->password_hash){
                $this->setPassword($this->password_hash);
            }
        }

        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }

    public function afterSave($insert, $changedAttributes)
    {
        if ($this->id != 1) {
            $role_arr = [];
            UserRole::deleteAll(['user_id' => $this->id]);
            foreach ($this->roles as $role) {
                $user_role = new UserRole();
                $user_role->role_id = intval($role);
                $user_role->user_id = $this->id;
                if (!$user_role->save()) {
                    throw new HttpException(500, Html::errorSummary($user_role));
                } else {
                    $role_arr[] = $user_role->role->name;
                }
            }
            $this->updateAttributes(['role' => implode(', ', $role_arr)]);
        }

        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
    }
}
