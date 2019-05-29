<?php 



/**
 * @author Bankole Emmanuel (mrbarnk1@gmail.com)
 */
use Illuminate\Http\Request;
use Gumlet\ImageResize;

class Group extends Controller
{
	public function __construct()
	{
		$this->middleware('Authentication');

		if (!$_POST) {
 			return exit('Invalid request type.');
 		}
	}
	public function find($id)
	{
		$user = User::where('id',$id);

		die($user->get([
			'id' => 'id',
			'username' => 'username',
			'bio' => 'bio',
			'profile_picture' => 'profile_picture'
		])[0]->toJson());
	}
	public function store()
	{
		$request = Request::capture();

		if ( $this->validateToJson($request->all(), [
					'username' => 'required'
				]) ) {
			die('Form cannot be empty!');
		} else {
				$group = new User;

				$user = User::find(session()->get('id'));

				$email = uniqid().'@gmail.com';


				$image = $request->file('file');
				
				// print_r($image);
				// die();
				if ($image) {
	    			$images = File::store($image, 'groups', 'image');

	    			if ($images == '0') {
	    				return exit('Not an image.');
	    			}
	    				// $user->profile_picture = $images;
	    				$imagesR =__DIR__.'/../../public/'.$images;
	                    // return exit($imagesR);
	                    $imageR = new ImageResize($imagesR);
	                    $imageR->resize(40, 40, $allow_enlarge = True);
	                    $imageR->save($imagesR);
	    		} else {
	    			$images = '';
	    		}

				$group = User::create([
					'username' => $request->username,
					'email' => $email,
					'profile_picture' => $images,
					'status' => false,
					'password_' => $user->password_,
					'type' => 'group',
					'company_id' => $user->company_id
				]);


 			// 	$group->username = $request->username;
 			// 	$group->email = $user->email;
 			// // 	$user->user_role = $request->role;
 			// 	$group->status = false;
 			// 	$group->password_ = $password;
 			// 	$group->type = 'group';
 			// 	$group->company_id = $user->company_id;

 				if ( $group ) {

 					if (groups_members::where([
	 					'group_id' => $group->id,
	 					'user_id' => session()->get('id')
	 				])->count() > 0) {
 						die('Already in the group.');
 					}
 					$group = groups_members::create([
	 					'group_id' => $group->id,
	 					'user_id' => session()->get('id')
	 				]);

	 				if (!$group) {
	 					die('Group created but unable to add you as a member.');
	 				}

 					die('ok');
 				} else {
 					die('Something wen\'t wrong');
 				}
		}
	}
 	public function update()
 	{
 		$request = Request::capture();
 		$id = $request->id;
		$user = User::find($id);

		if (!$user) {
			die('No group id found.');
		} elseif ($user->company_id != User::find(session()->get('id'))->company_id) {
			die('Please verify that you are in the group of the this company.');
		}
		// $user->first_name = $request->first_name;
		// $user->last_name = $request->last_name;
		$user->bio = $request->bio;

		$image = $request->file('file');

		if ($image) {
			$images = File::store($image, 'groups', 'image');
// 			if (!empty($images)) {
			// $user->profile_picture = $images;
			$imagesR =__DIR__.'/../../public/'.$images;
            $imageR = new ImageResize($imagesR);
            $imageR->resize(40, 40, $allow_enlarge = True);
            $imageR->save($imagesR);

            $user->profile_picture = $images != '' ? $images : $user->profile_picture;
    // 			}
    		}
		if ($user->save()) {
			return exit('ok');
		} else {
			return exit('Unable to save');
		}
 	}
}