<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use backend\models\User;

/**
 * User
 */
class UserFirstLogin extends Usuario
{
   public $confirm_password;
    /**
     * @inheritdoc
     */
    public function rules()
    {
       return [
            [['email', 'name', 'password_hash', 'confirm_password'], 'required'],
            [['username'], 'string', 'max' => 255],
            [['confirm_password', 'password_hash'], 'string', 'min' => 6],

            ];
    }
   
    
}
