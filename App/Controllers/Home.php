<?php


class Home extends Controller {

    public function __construct() {
        // $this->middleware('Authentication');
    }
    public function index($name = '') {

        // $post = $this->model('Posts');
        // $posts = $post::all();
        $this->view('home/index');//, ['posts' => $posts]);
    }
    public function login($params='')
    {
        // print_r(session());
      $this->view('auth/login');
    }
    public function logout() {
        session()->flush();
        redirect('login');
    }
    public function company_registration() {
        $this->view('companies/auth');
    }

}
