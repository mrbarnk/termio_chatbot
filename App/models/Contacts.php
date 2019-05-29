<?php 


/**
 * 
 */
use Illuminate\Database\Eloquent\Model;

class Contacts extends Model
{
	
	protected $fillable = ['user_id', 'contact_id', 'status', 'last_activity'];
}