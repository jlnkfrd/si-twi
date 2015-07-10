<?php namespace SiTwi\Models;

use \Illuminate\Database\Eloquent\Model;

class Post extends Model
{
	protected $table = "posts";
	
	protected $fillable = array('username', 'content');
}