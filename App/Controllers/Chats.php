<?php 


/**
 * @author Bankole Emmanuel
 */
class Chats extends Controller
{
	public function __construct() {
		$this->middleware('Authentication');
	}
	public function index($params = '') {
		$data = 'messages';
		$this->view('home/index', $data);
	}
	public function logout()
	{
		session()->destroy();
	}
}