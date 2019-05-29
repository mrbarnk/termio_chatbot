<?php


class Dashboard extends Controller {

    
    public function dashboard() {
        if(session()->has('c_id')) {
            $com = $this->model('Companies');
            $com = $com->where('id', session()->get('c_id'));
            die ($com->first()->company_key);
        } else {
            $this->view('companies/auth');
        }
    }
    public function register() {
        $this->view('companies/auth');
    }
}