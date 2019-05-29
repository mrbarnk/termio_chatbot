<?php

// namespace Mbr\Middleware;
/**
 *
 */
class Authentication extends Controller
{

  public function __construct()
  {
    // echo "string";
    // session()->destroy();
    $user = User::find(session()->get('id'));

    // print_r($user);
    if (!$user || !session()->has('id')) {
      session()->flush();
      // print_r($this->parseUrl($_GET));
      // redirect('login');
        return exit($this->view('auth/login'));
    }
  }
}
