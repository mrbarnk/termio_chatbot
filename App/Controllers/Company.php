<?php 


/**
  * @author Bankole Emmanuel (mrbarnk1)
  */
use Illuminate\Http\Request;
use Gumlet\ImageResize;
 class Company extends Controller
 {
 	function __construct()
 	{
 		if (!$_POST) {
 			return exit('Invalid request type.');
 		}
 	}
 	public function reg()
 	{
 		$request = Request::capture();
 		$val = $this->validateToJson($request->all(), [
 		 			'company_name' => 'required',
 		 			'email' => 'email',
 		 			'company_size' => 'required'
 		 		]);
 		if($val) {
 			die('Form cannot be empty');
 		} else {
 			$company = $this->model('Companies');
 			$user = $company->where('company_email', $request->email);
 		
 			if ($user->count() > 0) {
 				die("Company with that email exists");
 			} else {
 			    
 				$user = $company;//new User;
                $key = uniqid();
 				$user->company_name = $request->company_name;
 				$user->company_email = $request->email;
 			// 	$user->user_role = $request->role;
 				$user->company_size = $request->company_size;
 				$user->company_key = $key;

 				if ($user->save()) {
 					session()->put('c_id', $user->id);
 			// 		session()->put('username', $user->username);
 					die('ok');
 				} else {
 					die('Unable to register * Contact developer.');
 				}
 			}
 		}

 	}

 	public function log()
	{
 		$request = Request::capture();
 		$val = $this->validateToJson($request->all(), [
 		 			'email' => 'required',
 		 			'key' => 'required'
 		 		]);
 		if($val) {
 			die('Form cannot be empty');
 		} else {
 			$company = $this->model('Companies');
 			$userD = $company->where('company_email', $request->email);
 			$user = $company;//new User;//
 			// $userD = $user->where('email', $request->username);

 			
 			if ($userD->count() == 0) {
 				die("Company with that email does not exist.");
 			} else {
 				$key = $userD->first()->company_key;

 			// 	$user = new User;

 				if ($company->where('company_key'.$request->key)->count() > 0) {
 					session()->put('c_id', $userD->first()->id);
 			// 		session()->put('username', $userD->first()->username);
                
 					die('ok');
 				} else {
 					die('Incorrect key');
 				}
 			}
 		}

 	}
 	
 	
    public function dashboard() {
        if(session()->has('c_id')) {
            $com = $this->model('Companies');
            // print_r($com->first()->company_key);
        } else {
            $this->view('companies/auth');
        }
    }
//  	public function updateaccount()
//  	{
//  		$request = Request::capture();
// 		$user = User::find(session()->get('id'));

// 		$user->first_name = $request->first_name;
// 		$user->last_name = $request->last_name;
// 		$user->bio = $request->bio;

// 		$image = $request->file('file');

// 		if ($image) {
//     			$images = File::store($image, 'profiles');
//     // 			if (!empty($images)) {
//     				$user->profile_picture = $images;
//     				$imagesR ='/home/betafkrx/chat.betacodings.com/public/'.$images;
//                     $imageR = new ImageResize($imagesR);
//                     $imageR->resize(40, 40, $allow_enlarge = True);
//                     $imageR->save($imagesR);
//     // 			}
//     		}
// 		if ($user->save()) {
// 			return exit('ok');
// 		} else {
// 			return exit('Unable to save');
// 		}
//  	}
 }