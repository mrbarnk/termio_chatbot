<?php

use Illuminate\Database\Eloquent\Model;
class User extends Model{

protected $fillable = ['username', 'password_', 'status', 'user_role', 'email', 'first_name', 'last_name', 'bio', 'gender', 'profile_picture', 'last_online','company_id', 'type'];


}
