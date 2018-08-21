<?php

namespace app\models;
use yii\base\Model;

class SignupForm extends Model{
 
 public $username;
 public $password;
 public $refUser;
 
 public function rules() {
 return [
	[['username', 'password'], 'required', 'message' => 'Заполните поле'],
	['username', 'unique', 'targetClass' => User::className(),  'message' => 'Этот email уже занят'],
 ];
 }
 
 public function attributeLabels() {
 return [
	 'username' => 'Email',
	 'password' => 'Пароль',
	 'refUser' => '',
 ];
 }
 
}