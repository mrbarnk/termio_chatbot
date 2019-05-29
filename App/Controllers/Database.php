<?php

/**
 *
 */
 use Illuminate\Database\Capsule\Manager as Capsule;
class Database extends Controller
{

  public function __construct()
  {
    $this->middleware('Authentication');
  }

  public function index() {
    // $this->down();
    // 
    Capsule::schema()->table('messages', function ($table)
    {
      $table->text('images')->nullable();
    });
    // Capsule::schema()->table('users', function ($table) {
        // $table->string('first_name')->unique()->before('created_at');
        // $table->string('first_name')->before('created_at')->nullable();
        // $table->string('last_name')->before('created_at')->nullable();
        // $table->string('bio')->before('created_at')->nullable();
        // $table->string('gender')->before('created_at')->nullable();
        // $table->string('profile_picture')->default('profiles/avatar.png')->before('created_at')->nullable();
      // });
    return $this->up();
  }
  public function up()
  {
    // Capsule::schema()->create('users', function ($table) {
    //     $table->increments('id')->index();
    //     $table->string('username');
    //     $table->string('password_');
    //     $table->string('status');
    //     $table->string('user_role');
    //     $table->string('email')->unique();
        // $table->string('first_name')->unique();
        // $table->string('first_name')->nullable();
        // $table->string('last_name')->nullable();
        // $table->string('bio')->nullable();
        // $table->string('gender')->nullable();
        // $table->string('profile_picture')->default('profiles/avatar.png')->before('created_at')->nullable();
        // $table->timestamp('last_online');
        // $table->string('company_id');
    //     $table->timestamps();
    // });

    // Capsule::schema()->create('messages', function ($table)
    // {
    //     $table->increments('id')->index();
    //     $table->string('from_id');
    //     $table->string('to_id');
    //     $table->string('is_seen_by_me');
    //     $table->string('is_deleted_by_me');
    //     $table->integer('status');
    //     $table->string('is_deleted');
    //     $table->text('message');
    //     $table->text('images')->nullable();
    //     $table->timestamps();
    // });

    // Capsule::schema()->create('contacts', function ($table)
    // {
    //   $table->increments('id')->index();
    //   $table->string('user_id');
    //   $table->string('contact_id');
    //   $table->string('status');
    //   $table->string('last_activity');
    //   $table->timestamps();
    // });

  }

  public function down() {
    // Capsule::schema()->drop('users');
    // Capsule::schema()->drop('categories');
    // Capsule::schema()->drop('posts');
    // Schema::drop('flights');
  }
}
