<?php 


use Illuminate\Database\Eloquent\Model;

/**
 * 
 */
class Messages extends Model
{
	protected $fillable = ['from_id', 'to_id', 'is_seen_by_me', 'is_deleted_by_me', 'status', 'is_deleted', 'message', 'images'];
}