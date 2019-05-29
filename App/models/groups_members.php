<?php 

/**
 * @author Bankole Emmanuel
 */

use Illuminate\Database\Eloquent\Model;

class groups_members extends Model
{
	protected $fillable = ['group_id', 'user_id'];
	
}