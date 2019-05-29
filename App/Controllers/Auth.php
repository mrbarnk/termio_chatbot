<?php 


/**
  * @author Bankole Emmanuel (mrbarnk1)
  */
use Illuminate\Http\Request;
use Gumlet\ImageResize;
 class Auth extends Controller
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
 		 			'username' => 'required',
 		 			'password' => 'required',
 		 			'email' => 'email',
 		 //			'role' => 'required',
 		 			'company_id' => 'required'
 		 		]);
 		if($val) {
 			die('Form cannot be empty');
 		} else {
 			$user = User::where('email', $request->email);
 			$company = $this->model('Companies');
 			if($company->where('company_key', $request->company_id)->count() < 1) {
 			    return exit('Company id is invalid');
 			}
 			if ($user->count() > 0) {
 				die("User with that email exists");
 			} elseif (User::where('username', $request->username)->count() > 0) {
 				die("User with that username exists");
 			} else {
 				$password = Hash::make($request->password);
 				$user = new User;

 				$user->username = $request->username;
 				$user->email = $request->email;
 			// 	$user->user_role = $request->role;
 				$user->status = false;
 				$user->password_ = $password;
 				$user->company_id = $request->company_id;

 				if ($user->save()) {
 					session()->put('id', $user->id);
 					session()->put('username', $user->username);
 					die('ok');
 				} else {
 					die('Unable to register user * Contact developer.');
 				}
 			}
 		}

 	}

 	public function log()
	{
 		$request = Request::capture();
 		$val = $this->validateToJson($request->all(), [
 		 			'username' => 'required',
 		 			'password' => 'required'
 		 		]);
 		if($val) {
 			die('Form cannot be empty');
 		} else {
 			$user = new User;//
 			$userD = $user->where('email', $request->username);

 			if($userD->count() == 0) {
 				$userD = $user->where('username', $request->username);
 			}
 			if ($userD->count() == 0) {
 				die("User with that email/username does not exist.");
 			} else {
 				$password = $userD->first()->password_;

 			// 	$user = new User;

 				if (Hash::check($request->password, $password)) {
 					session()->put('id', $userD->first()->id);
 					session()->put('username', $userD->first()->username);
                    $sssk = User::find(session()->get('id'));
                    
                    if($sssk) {
                        $sssk->last_online = date("Y-m-d h:i:s");
                        $sssk->save();
                    }
 					die('ok');
 				} else {
 					die('Incorrect password');
 				}
 			}
 		}

 	}
 	public function updateaccount()
 	{
 		$request = Request::capture();
		$user = User::find(session()->get('id'));

		$user->first_name = $request->first_name;
		$user->last_name = $request->last_name;
		$user->bio = $request->bio;

		$image = $request->file('file');

		if ($image) {
    			$images = File::store($image, 'profiles', 'image');
    // 			if (!empty($images)) {
    				$user->profile_picture = $images;
    				$imagesR =__DIR__.'/../../public/'.$images;
                    $imageR = new ImageResize($imagesR);
                    $imageR->resize(40, 40, $allow_enlarge = True);
                    $imageR->save($imagesR);
    // 			}
    		}
		if ($user->save()) {
			return exit('ok');
		} else {
			return exit('Unable to save');
		}
 	}
 }