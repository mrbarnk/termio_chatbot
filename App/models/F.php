<?php 


/**
 * @author Bankole Emmanuel (mrbarnk1@gmail.com)
 */
use Illuminate\Database\Eloquent\Model;

class F extends Model
{
	protected $table = 'files';
	protected $fillable = ['file_key'];
}