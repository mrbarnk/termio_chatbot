<?php 


/**
 * 
 */
use Illuminate\Database\Eloquent\Model;

class Companies extends Model
{
    protected $fillable = ['company_name','company_size','company_email','company_key'];
}