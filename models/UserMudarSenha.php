<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use backend\models\User;

/**
 * User
 */
class UserMudarSenha extends Usuario
{
   public $confirm_password;
   public $new_password_hash;
    /**
     * @inheritdoc
     */
    public function rules()
    {
       return [
            [['new_password_hash', 'password_hash', 'confirm_password'], 'required'],
            [['confirm_password', 'password_hash'], 'string', 'min' => 6],

            ];
    }
   
    
}
