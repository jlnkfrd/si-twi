<?php namespace SiTwi\Models;

use \Illuminate\Database\Eloquent\Model;

class User extends Model
{
	protected $table = "users";

	protected $fillable = array('username', 'password');

}