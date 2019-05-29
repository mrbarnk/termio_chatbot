<?php


/**
 *
 */
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
  protected $table = 'menus';
  protected $fillable = ['title', 'url', 'parent_id', 'type', 'status', 'user_id'];
}
