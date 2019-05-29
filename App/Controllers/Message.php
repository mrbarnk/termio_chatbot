<?php

/*        // get all users except the authenticated one
        $contacts = User::where('id', '!=', auth()->id())->get();
        // get a collection of items where sender_id is the user who sent us a message
        // and messages_count is the number of unread messages we have from him
        $unreadIds = Message::select(\DB::raw('`from` as sender_id, count(`from`) as messages_count'))
            ->where('to', auth()->id())
            ->where('read', false)
            ->groupBy('from')
            ->get();
        // add an unread key to each contact with the count of unread messages
        $contacts = $contacts->map(function($contact) use ($unreadIds) {
            $contactUnread = $unreadIds->where('sender_id', $contact->id)->first();
            $contact->unread = $contactUnread ? $contactUnread->messages_count : 0;
            return $contact;
            */

use Illuminate\Http\Request;
use Gumlet\ImageResize;

class Message extends Controller
{	
    public function __construct() {
        $this->middleware('Authentication');
        $sssk = User::find(session()->get('id'));
        
        if($sssk) {
            $sssk->last_online = date("Y-m-d h:i:s");
            $sssk->save();
        }
    }
    function reS() {
        $images ='/home/betafkrx/chat.betacodings.com/public/uploaded/profiles/png_files/5ce8260d5b1890.79817124.png';
    			$imageR = new ImageResize($images);
                $imageR->resize(200, 350, $allow_enlarge = True);
                $imageR->save($images);
    }
    public function sendMessage($value='')
    {
    	$request = Request::capture();

    	
    	if(!is_null($request->message) && !is_null($request->to_id)) {
            $to_id = $request->to_id;
    		$contact =  Contacts::where(function ($query) use ($to_id) {
											    $query->where('user_id', '=', session()->get('id'))
											          ->where('contact_id', '=', $to_id);
											})->orWhere(function ($query) use ($to_id) {
											    $query->where('user_id', '=', $to_id)
											          ->where('contact_id', '=', session()->get('id'));
											});
								// 			Contacts::where('user_id', session()->get('id'))->orWhere('contact_id', $request->to_id);


    		if ($contact->count() < 1) {
	    		$contact = Contacts::create([
	    			'user_id' => session()->get('id'),
					'contact_id' => $request->to_id,
					'status' => '0',
					'last_activity' => date('Y-m-d h:i:s')
	 			]);
    		} else {
    			$contact->update([
    				'last_activity' => date("Y-m-d h:i:s")
    			]);
    		}
    		$image = $request->file('file');

    		if ($image || isset($request->message)) {
    			
    		if ($image) {
    			$images = File::store($image, 'messages');
                
                
				$imagesR =__DIR__.'/../../public/'.$images;
                // $imageR = new ImageResize($imagesR);
                // $imageR->resize(200, 350, $allow_enlarge = True);
                // $imageR->save($imagesR);
    			// die(File::store($image));
	    		$image = $image->getClientOriginalName();
	    		$xts = explode('.', $image);
	    		$exts = '<i class="icon-'.strtolower(end($xts)).'"></i>&nbsp;&nbsp;';

    		} else {
    			$images = '';
    			$image = '';
    			$exts = '';
    		}

    		$f = F::create([
    			'file_key' => $images
    		]);
    		if(@is_array(getimagesize($imagesR))){
    		// if (exif_imagetype($imagesR) != IMAGETYPE_GIF) {
			    $image = '<img src="'.url('file/path/').$f->id.'">';
			} else {
				$image = '<a href="'.url('file/path/').$f->id.'">'.$exts.$image.'</a>';
			}

    		$message = Messages::create([
				'from_id' => session()->get('id'), 
	    		'to_id' => $request->to_id, 
	    		'is_seen_by_me' => '0', 
	    		'is_deleted_by_me' => '0', 
	    		'status' => '1', 
	    		'is_deleted' => '0', 
	    		'message' => addslashes(htmlentities($request->message)).'<br /><br />'.$image,
	    		'images' => ''//$images
	    	]);

	    	if($message) {
	    // 	    if (!empty($images)) {
					// $xt = explode('.', $images);
					// $xt = strtolower(($xt[0]));
					// $ac = ['jpeg', 'jpg', 'png', 'gif'];
					// // if (in_array($xt, $ac)) {
					// // $me= '<br /><img src="'.url($images).'">';
					// // } else {
					// // 	$me= '<br /><i class="icon-'.$xt.'-alt"></i><a href="'.url($images).'">'.substr($images, 19).'</a>';
					// // 	}
	    // 		return exit((formatText ($message->message)).$me);
					// 					} else {
										    $me = isset($me) ? $me : '';

	    		return exit((formatText ($message->message)).$me);
										// }
		    	} else {
	    	    	return exit('an error occured.');
		    	}
    		}
    	}
    }
    public function fetchMessage($id) {
        $sssk = User::find(session()->get('id'));
        
        if($sssk) {
            $sssk->last_online = date("Y-m-d h:i:s");
            $sssk->save();
        }
    	$to_id = $id;
    	$request = Request::capture();
    	$user = User::find($id);
    	if (!empty($user->first_name.$user->last_name)) {
    		$name = $user->first_name.' '.$user->last_name;
    	} else {
    		$name = $user->username;
    	}
    	$last_online = $user->last_online;
    	$start_date = new DateTime($last_online);
        $since_start = $start_date->diff(new DateTime());
        // echo $since_start->days.' days total<br>';
        // echo $since_start->d.' days<br>';
        // echo $since_start->h.' hours<br>';
        // echo $since_start->i.' minutes<br>';
        // echo $since_start->s.' seconds<br>';
    	// die($id);
    	if($since_start->h > 0) {
    	    $minutesAgo = $since_start->h.' hours ago';
    	} elseif ($since_start->h > 24) {
    	    $minutesAgo = $since_start->days.' days ago';
    	} else {
        	$minutesAgo = $since_start->i.' minutes ago';
    	}
    	if  ($since_start->i < 1) {
    	    $onlineStatus = 'Online <i class="fa fa-circle fa-green"></i>';
    	} else {
    	    $onlineStatus = 'Away <i class="fa fa-circle fa-orange"></i> '.$minutesAgo;
    	}
    	$onlineStatus = timeAgo($user->last_online);
        ?>
    <div class="tab-content">
					<!-- Start of Chat Room -->
					<div class="tab-pane fade show active" id="chat1" role="tabpanel">
						<div class="item">
							<div class="content">
								<div class="">
									<div class="top">
										<div class="headline">
											<img src="<?php echo url('/'.$user->profile_picture) ?>" alt="avatar">
											<div class="content">
												<h5><?php echo ($name); ?></h5>
												<span><?php echo $user->type == 'user' ? $onlineStatus : ""?></span>
											</div>
										</div>
										<ul>
											<li><button type="button" class="btn"><i class="eva-hover fa fa-video-call"></i></button></li>
											<?php if ($user->type == 'group'): ?>
												<li data-id="<?=$id?>" id="updategroup"><button data-id="<?=$id?>" type="button" class="btn"><i class="eva-hover fa fa-edit"></i></button></li>
											<?php endif ?>
											<li><button type="button" class="btn" data-toggle="modal" data-target="#compose"><i class="eva-hover fa fa-user-plus"></i></button></li>
											<li><button type="button" class="btn" data-utility="open"><i class="eva-hover fa fa-info-circle"></i></button></li>
											<li><button type="button" id="oooP" class="btn round" data-chat="open"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-arrow-ios-back"><g data-name="Layer 2"><g data-name="arrow-ios-back"><rect width="24" height="24" transform="rotate(90 12 12)" opacity="0"></rect><path d="M13.83 19a1 1 0 0 1-.78-.37l-4.83-6a1 1 0 0 1 0-1.27l5-6a1 1 0 0 1 1.54 1.28L10.29 12l4.32 5.36a1 1 0 0 1-.78 1.64z"></path></g></g></svg></button></li>
											<li><button type="button" class="btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="eva-hover"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-more-vertical eva-animation eva-icon-hover-pulse"><g data-name="Layer 2"><g data-name="more-vertical"><rect width="24" height="24" transform="rotate(-90 12 12)" opacity="0"></rect><circle cx="12" cy="12" r="2"></circle><circle cx="12" cy="5" r="2"></circle><circle cx="12" cy="19" r="2"></circle></g></g></svg></i></button>
												<div class="dropdown-menu">
													<button type="button" class="dropdown-item"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-video"><g data-name="Layer 2"><g data-name="video"><rect width="24" height="24" opacity="0"></rect><path d="M21 7.15a1.7 1.7 0 0 0-1.85.3l-2.15 2V8a3 3 0 0 0-3-3H5a3 3 0 0 0-3 3v8a3 3 0 0 0 3 3h9a3 3 0 0 0 3-3v-1.45l2.16 2a1.74 1.74 0 0 0 1.16.45 1.68 1.68 0 0 0 .69-.15 1.6 1.6 0 0 0 1-1.48V8.63A1.6 1.6 0 0 0 21 7.15z"></path></g></g></svg>Video call</button>
													<button type="button" class="dropdown-item"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-phone"><g data-name="Layer 2"><g data-name="phone"><rect width="24" height="24" opacity="0"></rect><path d="M17.4 22A15.42 15.42 0 0 1 2 6.6 4.6 4.6 0 0 1 6.6 2a3.94 3.94 0 0 1 .77.07 3.79 3.79 0 0 1 .72.18 1 1 0 0 1 .65.75l1.37 6a1 1 0 0 1-.26.92c-.13.14-.14.15-1.37.79a9.91 9.91 0 0 0 4.87 4.89c.65-1.24.66-1.25.8-1.38a1 1 0 0 1 .92-.26l6 1.37a1 1 0 0 1 .72.65 4.34 4.34 0 0 1 .19.73 4.77 4.77 0 0 1 .06.76A4.6 4.6 0 0 1 17.4 22z"></path></g></g></svg>Voice call</button>
													<button type="button" class="dropdown-item" data-toggle="modal" data-target="#compose"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-person-add"><g data-name="Layer 2"><g data-name="person-add"><rect width="24" height="24" opacity="0"></rect><path d="M21 6h-1V5a1 1 0 0 0-2 0v1h-1a1 1 0 0 0 0 2h1v1a1 1 0 0 0 2 0V8h1a1 1 0 0 0 0-2z"></path><path d="M10 11a4 4 0 1 0-4-4 4 4 0 0 0 4 4z"></path><path d="M16 21a1 1 0 0 0 1-1 7 7 0 0 0-14 0 1 1 0 0 0 1 1"></path></g></g></svg>Add people</button>
													<button type="button" class="dropdown-item" data-utility="open"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-info"><g data-name="Layer 2"><g data-name="info"><rect width="24" height="24" transform="rotate(180 12 12)" opacity="0"></rect><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm1 14a1 1 0 0 1-2 0v-5a1 1 0 0 1 2 0zm-1-7a1 1 0 1 1 1-1 1 1 0 0 1-1 1z"></path></g></g></svg>Information</button>
												</div>
											</li>
										</ul>
										<ul hidden="">
											<li><button type="button" class="btn"><i data-eva="video" data-eva-animation="pulse"></i></button></li>
											<li><button type="button" class="btn"><i data-eva="phone" data-eva-animation="pulse"></i></button></li>
											<li><button type="button" class="btn" data-toggle="modal" data-target="#compose"><i data-eva="person-add" data-eva-animation="pulse"></i></button></li>
											<li><button type="button" class="btn" data-utility="open"><i data-eva="info" data-eva-animation="pulse"></i></button></li>
											<li><button type="button" class="btn round" data-chat="open"><i class="fa fa-arrow-left" data-eva="arrow-ios-back"></i></button></li>
											<li><button type="button" class="btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i data-eva="more-vertical" data-eva-animation="pulse"></i></button>
												<div class="dropdown-menu">
													<button type="button" class="dropdown-item"><i data-eva="video"></i>Video call</button>
													<?php if ($user->type == 'group'): ?>
														<i class="fa fa-paperclip fa-5x"></i>
													<?php endif ?>
													<button type="button" class="dropdown-item"><i data-eva="phone"></i>Voice call</button>
													<button type="button" class="dropdown-item" data-toggle="modal" data-target="#compose"><i data-eva="person-add"></i>Add people</button>
													<button type="button" class="dropdown-item" data-utility="open"><i data-eva="info"></i>Information</button>
												</div>
											</li>
										</ul>
									</div>
								</div>
								<div class="middle" id="scroll">
									<div class="messagecontainer">
										<p class="newMessageNotifier" hidden="" id="chatOpen" chat-id="<?php echo $to_id; ?>" style="position: absolute; cursor: pointer;">new message <i class="fa fa-arrow-down"></i></p>
										<ul id="messagesLists<?=$id?>">
											<?php 
											$id = $id;

											if ($user->type == 'user') {
											
												$messages = Messages::where(function ($query) use ($to_id) {
												    $query->where('from_id', '=', session()->get('id'))
												          ->where('to_id', '=', $to_id);
												})->orWhere(function ($query) use ($to_id) {
												    $query->where('from_id', '=', $to_id)
												          ->where('to_id', '=', session()->get('id'));
												});
												$sentFrom = '';
											} else {
												$sentFrom = '';
												$messages = Messages::where('to_id', $to_id);
											}

											if ($messages->count() > 0) {
												// return exit($messages->get());
												foreach ($messages->get() as $message) {
													if ($message->from_id == session()->get('id')) {
														$me = 'me';
														$author = '';
													} else {
														$me = 'them';
														$author = $user->type == 'group' ? User::find($message->from_id)->username : "";
													}
											 ?>
											<li class="<?php echo $me ?>">
												<!-- <img src="dist/img/avatars/avatar-male-3.jpg" alt="avatar"> -->
												<div class="content">
													<div class="message">
													<span><?php echo $author; ?></span>
														<div class="bubble">
															<p><?php echo (formatText ($message->message));
/*															if (!empty($message->images)) {
																$xt = explode('.', $message->images);
																$xt = strtolower(($xt[0]));
																$ac = ['jpeg', 'jpg', 'png', 'gif'];
																if (in_array($xt, $ac)) {
																echo '<br /><img src="'.url($message->images).'">';
																} else {
																	echo '<br /><i class="icon-'.$xt.'-alt"></i><a href="'.url($message->images).'">'.substr($message->images, 19).'</a>';
																}
															}*/
															 ?></p>
													<span><?php $time = (getdate(strtotime($message->created_at)));
													$okDates = 24-$time['hours']>12?$time['hours']:24-$time['hours'];
													$pm = 24-$time['hours']<12?'pm':'am';
													// print_r($time);
													echo $okDates.":".$time['minutes'].$pm; ?></span>
														</div>
													</div>
												</div>
											</li>
										<?php }} ?>
										</ul>
									</div>
								</div>
								<div class="">
									<div class="bottom">
										<form id="sendMessage" autocomplete="off" form-type="message" action="https://chat.betacodings.com/public/Message/sendMessage/">
											<input id="to_id" type="hidden" name="to_id" value="<?=$to_id?>">

											<label for="fileToSend" class="btn filesend" ><i class="fa fa-paperclip"></i></label>
											<input type="file" name="file" id="fileToSend"/>
											<input class="form-control" placeholder="Type message..." rows="1" name="message" id="messageToSend">
											<button type="submit" class="btn btnsend"><i class="fa fa-paper-plane" data-eva="paper-plane"></i></button>
										</form>
									</div>
								</div>
							</div>
							

							<!-- Start of Utilities -->
								<div class="utility">
								<div class="container">
									<button type="button" class="close" data-utility="open"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-close"><g data-name="Layer 2"><g data-name="close"><rect width="24" height="24" transform="rotate(180 12 12)" opacity="0"></rect><path d="M13.41 12l4.3-4.29a1 1 0 1 0-1.42-1.42L12 10.59l-4.29-4.3a1 1 0 0 0-1.42 1.42l4.3 4.29-4.3 4.29a1 1 0 0 0 0 1.42 1 1 0 0 0 1.42 0l4.29-4.3 4.29 4.3a1 1 0 0 0 1.42 0 1 1 0 0 0 0-1.42z"></path></g></g></svg></button>
									<button type="button" class="btn primary" data-toggle="modal" data-target="#compose">Add people</button>
									<ul class="nav" role="tablist">
										<li><a href="#users2" class="active" data-toggle="tab" role="tab" aria-controls="users2" aria-selected="true">Users</a></li>
										<li><a href="#files2" data-toggle="tab" role="tab" aria-controls="files2" aria-selected="false">Files</a></li>
									</ul>
									<div class="tab-content">
										<!-- Start of Users -->
										<div class="tab-pane fade active show" id="users2" role="tabpanel">
											<h4>Users</h4>
											<hr>
											<ul class="users">
												<li>
													<div class="status online"><img src="dist/img/avatars/avatar-male-1.jpg" alt="avatar"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-radio-button-on"><g data-name="Layer 2"><g data-name="radio-button-on"><rect width="24" height="24" opacity="0"></rect><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm0 18a8 8 0 1 1 8-8 8 8 0 0 1-8 8z"></path><path d="M12 7a5 5 0 1 0 5 5 5 5 0 0 0-5-5z"></path></g></g></svg></div>
													<div class="content">
														<h5>Ham Chuwon</h5>
														<span>Florida, US</span>
													</div>
													<div class="dropdown">
														<button type="button" class="btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-more-vertical"><g data-name="Layer 2"><g data-name="more-vertical"><rect width="24" height="24" transform="rotate(-90 12 12)" opacity="0"></rect><circle cx="12" cy="12" r="2"></circle><circle cx="12" cy="5" r="2"></circle><circle cx="12" cy="19" r="2"></circle></g></g></svg></button>
														<div class="dropdown-menu dropdown-menu-right">
															<button type="button" class="dropdown-item">Edit</button>
															<button type="button" class="dropdown-item">Share</button>
															<button type="button" class="dropdown-item">Delete</button>
														</div>
													</div>
												</li>
												<li>
													<div class="status offline"><img src="dist/img/avatars/avatar-male-2.jpg" alt="avatar"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-radio-button-on"><g data-name="Layer 2"><g data-name="radio-button-on"><rect width="24" height="24" opacity="0"></rect><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm0 18a8 8 0 1 1 8-8 8 8 0 0 1-8 8z"></path><path d="M12 7a5 5 0 1 0 5 5 5 5 0 0 0-5-5z"></path></g></g></svg></div>
													<div class="content">
														<h5>Quincy Hensen</h5>
														<span>Shanghai, China</span>
													</div>
													<div class="dropdown">
														<button type="button" class="btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-more-vertical"><g data-name="Layer 2"><g data-name="more-vertical"><rect width="24" height="24" transform="rotate(-90 12 12)" opacity="0"></rect><circle cx="12" cy="12" r="2"></circle><circle cx="12" cy="5" r="2"></circle><circle cx="12" cy="19" r="2"></circle></g></g></svg></button>
														<div class="dropdown-menu dropdown-menu-right">
															<button type="button" class="dropdown-item">Edit</button>
															<button type="button" class="dropdown-item">Share</button>
															<button type="button" class="dropdown-item">Delete</button>
														</div>
													</div>
												</li>
												<li>
													<div class="status online"><img src="dist/img/avatars/avatar-male-3.jpg" alt="avatar"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-radio-button-on"><g data-name="Layer 2"><g data-name="radio-button-on"><rect width="24" height="24" opacity="0"></rect><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm0 18a8 8 0 1 1 8-8 8 8 0 0 1-8 8z"></path><path d="M12 7a5 5 0 1 0 5 5 5 5 0 0 0-5-5z"></path></g></g></svg></div>
													<div class="content">
														<h5>Mark Hog</h5>
														<span>Olso, Norway</span>
													</div>
													<div class="dropdown">
														<button type="button" class="btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-more-vertical"><g data-name="Layer 2"><g data-name="more-vertical"><rect width="24" height="24" transform="rotate(-90 12 12)" opacity="0"></rect><circle cx="12" cy="12" r="2"></circle><circle cx="12" cy="5" r="2"></circle><circle cx="12" cy="19" r="2"></circle></g></g></svg></button>
														<div class="dropdown-menu dropdown-menu-right">
															<button type="button" class="dropdown-item">Edit</button>
															<button type="button" class="dropdown-item">Share</button>
															<button type="button" class="dropdown-item">Delete</button>
														</div>
													</div>
												</li>
												<li>
													<div class="status offline"><img src="dist/img/avatars/avatar-male-4.jpg" alt="avatar"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-radio-button-on"><g data-name="Layer 2"><g data-name="radio-button-on"><rect width="24" height="24" opacity="0"></rect><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm0 18a8 8 0 1 1 8-8 8 8 0 0 1-8 8z"></path><path d="M12 7a5 5 0 1 0 5 5 5 5 0 0 0-5-5z"></path></g></g></svg></div>
													<div class="content">
														<h5>Sanne Viscaal</h5>
														<span>Helena, Montana</span>
													</div>
													<div class="dropdown">
														<button type="button" class="btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-more-vertical"><g data-name="Layer 2"><g data-name="more-vertical"><rect width="24" height="24" transform="rotate(-90 12 12)" opacity="0"></rect><circle cx="12" cy="12" r="2"></circle><circle cx="12" cy="5" r="2"></circle><circle cx="12" cy="19" r="2"></circle></g></g></svg></button>
														<div class="dropdown-menu dropdown-menu-right">
															<button type="button" class="dropdown-item">Edit</button>
															<button type="button" class="dropdown-item">Share</button>
															<button type="button" class="dropdown-item">Delete</button>
														</div>
													</div>
												</li>
												<li>
													<div class="status offline"><img src="dist/img/avatars/avatar-male-5.jpg" alt="avatar"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-radio-button-on"><g data-name="Layer 2"><g data-name="radio-button-on"><rect width="24" height="24" opacity="0"></rect><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm0 18a8 8 0 1 1 8-8 8 8 0 0 1-8 8z"></path><path d="M12 7a5 5 0 1 0 5 5 5 5 0 0 0-5-5z"></path></g></g></svg></div>
													<div class="content">
														<h5>Alex Just</h5>
														<span>London, UK</span>
													</div>
													<div class="dropdown">
														<button type="button" class="btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-more-vertical"><g data-name="Layer 2"><g data-name="more-vertical"><rect width="24" height="24" transform="rotate(-90 12 12)" opacity="0"></rect><circle cx="12" cy="12" r="2"></circle><circle cx="12" cy="5" r="2"></circle><circle cx="12" cy="19" r="2"></circle></g></g></svg></button>
														<div class="dropdown-menu dropdown-menu-right">
															<button type="button" class="dropdown-item">Edit</button>
															<button type="button" class="dropdown-item">Share</button>
															<button type="button" class="dropdown-item">Delete</button>
														</div>
													</div>
												</li>
												<li>
													<div class="status online"><img src="dist/img/avatars/avatar-male-6.jpg" alt="avatar"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-radio-button-on"><g data-name="Layer 2"><g data-name="radio-button-on"><rect width="24" height="24" opacity="0"></rect><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm0 18a8 8 0 1 1 8-8 8 8 0 0 1-8 8z"></path><path d="M12 7a5 5 0 1 0 5 5 5 5 0 0 0-5-5z"></path></g></g></svg></div>
													<div class="content">
														<h5>Arturo Thomas</h5>
														<span>Vienna, Austria</span>
													</div>
													<div class="dropdown">
														<button type="button" class="btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-more-vertical"><g data-name="Layer 2"><g data-name="more-vertical"><rect width="24" height="24" transform="rotate(-90 12 12)" opacity="0"></rect><circle cx="12" cy="12" r="2"></circle><circle cx="12" cy="5" r="2"></circle><circle cx="12" cy="19" r="2"></circle></g></g></svg></button>
														<div class="dropdown-menu dropdown-menu-right">
															<button type="button" class="dropdown-item">Edit</button>
															<button type="button" class="dropdown-item">Share</button>
															<button type="button" class="dropdown-item">Delete</button>
														</div>
													</div>
												</li>
											</ul>
										</div>
										<!-- End of Users -->
										<!-- Start of Files -->
										<div class="tab-pane fade" id="files2" role="tabpanel">
											<h4>Files</h4>
											<div class="upload">
												<label>
													<input type="file">
													<span>Drag &amp; drop files here</span>
												</label>
											</div>
											<ul class="files">
												<li>
													<ul class="avatars">
														<li><button class="btn round"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-file-text"><g data-name="Layer 2"><g data-name="file-text"><rect width="24" height="24" opacity="0"></rect><path d="M19.74 7.33l-4.44-5a1 1 0 0 0-.74-.33h-8A2.53 2.53 0 0 0 4 4.5v15A2.53 2.53 0 0 0 6.56 22h10.88A2.53 2.53 0 0 0 20 19.5V8a1 1 0 0 0-.26-.67zM9 12h3a1 1 0 0 1 0 2H9a1 1 0 0 1 0-2zm6 6H9a1 1 0 0 1 0-2h6a1 1 0 0 1 0 2zm-.29-10a.79.79 0 0 1-.71-.85V4l3.74 4z"></path></g></g></svg></button></li>
														<li><a href="#"><img src="dist/img/avatars/avatar-male-1.jpg" alt="avatar"></a></li>
													</ul>
													<div class="meta">
														<a href="#"><h5>workbox.js</h5></a>
														<span>2kb</span>
													</div>
													<div class="dropdown">
														<button type="button" class="btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-more-vertical"><g data-name="Layer 2"><g data-name="more-vertical"><rect width="24" height="24" transform="rotate(-90 12 12)" opacity="0"></rect><circle cx="12" cy="12" r="2"></circle><circle cx="12" cy="5" r="2"></circle><circle cx="12" cy="19" r="2"></circle></g></g></svg></button>
														<div class="dropdown-menu dropdown-menu-right">
															<button type="button" class="dropdown-item">Edit</button>
															<button type="button" class="dropdown-item">Share</button>
															<button type="button" class="dropdown-item">Delete</button>
														</div>
													</div>
												</li>
												<li>
													<ul class="avatars">
														<li><button class="btn round"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-folder"><g data-name="Layer 2"><g data-name="folder"><rect width="24" height="24" opacity="0"></rect><path d="M19.5 20.5h-15A2.47 2.47 0 0 1 2 18.07V5.93A2.47 2.47 0 0 1 4.5 3.5h4.6a1 1 0 0 1 .77.37l2.6 3.18h7A2.47 2.47 0 0 1 22 9.48v8.59a2.47 2.47 0 0 1-2.5 2.43z"></path></g></g></svg></button></li>
														<li><a href="#"><img src="dist/img/avatars/avatar-male-2.jpg" alt="avatar"></a></li>
													</ul>
													<div class="meta">
														<a href="#"><h5>bug_report</h5></a>
														<span>1kb</span>
													</div>
													<div class="dropdown">
														<button type="button" class="btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-more-vertical"><g data-name="Layer 2"><g data-name="more-vertical"><rect width="24" height="24" transform="rotate(-90 12 12)" opacity="0"></rect><circle cx="12" cy="12" r="2"></circle><circle cx="12" cy="5" r="2"></circle><circle cx="12" cy="19" r="2"></circle></g></g></svg></button>
														<div class="dropdown-menu dropdown-menu-right">
															<button type="button" class="dropdown-item">Edit</button>
															<button type="button" class="dropdown-item">Share</button>
															<button type="button" class="dropdown-item">Delete</button>
														</div>
													</div>
												</li>
												<li>
													<ul class="avatars">
														<li><button class="btn round"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-briefcase"><g data-name="Layer 2"><g data-name="briefcase"><rect width="24" height="24" opacity="0"></rect><path d="M7 21h10V7h-1V5.5A2.5 2.5 0 0 0 13.5 3h-3A2.5 2.5 0 0 0 8 5.5V7H7zm3-15.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5V7h-4z"></path><path d="M19 7v14a3 3 0 0 0 3-3v-8a3 3 0 0 0-3-3z"></path><path d="M5 7a3 3 0 0 0-3 3v8a3 3 0 0 0 3 3z"></path></g></g></svg></button></li>
														<li><a href="#"><img src="dist/img/avatars/avatar-male-3.jpg" alt="avatar"></a></li>
													</ul>
													<div class="meta">
														<a href="#"><h5>nuget.zip</h5></a>
														<span>7mb</span>
													</div>
													<div class="dropdown">
														<button type="button" class="btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-more-vertical"><g data-name="Layer 2"><g data-name="more-vertical"><rect width="24" height="24" transform="rotate(-90 12 12)" opacity="0"></rect><circle cx="12" cy="12" r="2"></circle><circle cx="12" cy="5" r="2"></circle><circle cx="12" cy="19" r="2"></circle></g></g></svg></button>
														<div class="dropdown-menu dropdown-menu-right">
															<button type="button" class="dropdown-item">Edit</button>
															<button type="button" class="dropdown-item">Share</button>
															<button type="button" class="dropdown-item">Delete</button>
														</div>
													</div>
												</li>
												<li>
													<ul class="avatars">
														<li><button class="btn round"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-image-2"><g data-name="Layer 2"><g data-name="image-2"><rect width="24" height="24" opacity="0"></rect><path d="M18 3H6a3 3 0 0 0-3 3v12a3 3 0 0 0 3 3h12a3 3 0 0 0 3-3V6a3 3 0 0 0-3-3zM8 7a1.5 1.5 0 1 1-1.5 1.5A1.5 1.5 0 0 1 8 7zm11 10.83A1.09 1.09 0 0 1 18 19H6l7.57-6.82a.69.69 0 0 1 .93 0l4.5 4.48z"></path></g></g></svg></button></li>
														<li><a href="#"><img src="dist/img/avatars/avatar-male-4.jpg" alt="avatar"></a></li>
													</ul>
													<div class="meta">
														<a href="#"><h5>clearfix.jpg</h5></a>
														<span>1kb</span>
													</div>
													<div class="dropdown">
														<button type="button" class="btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-more-vertical"><g data-name="Layer 2"><g data-name="more-vertical"><rect width="24" height="24" transform="rotate(-90 12 12)" opacity="0"></rect><circle cx="12" cy="12" r="2"></circle><circle cx="12" cy="5" r="2"></circle><circle cx="12" cy="19" r="2"></circle></g></g></svg></button>
														<div class="dropdown-menu dropdown-menu-right">
															<button type="button" class="dropdown-item">Edit</button>
															<button type="button" class="dropdown-item">Share</button>
															<button type="button" class="dropdown-item">Delete</button>
														</div>
													</div>
												</li>
												<li>
													<ul class="avatars">
														<li><button class="btn round"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-folder"><g data-name="Layer 2"><g data-name="folder"><rect width="24" height="24" opacity="0"></rect><path d="M19.5 20.5h-15A2.47 2.47 0 0 1 2 18.07V5.93A2.47 2.47 0 0 1 4.5 3.5h4.6a1 1 0 0 1 .77.37l2.6 3.18h7A2.47 2.47 0 0 1 22 9.48v8.59a2.47 2.47 0 0 1-2.5 2.43z"></path></g></g></svg></button></li>
														<li><a href="#"><img src="dist/img/avatars/avatar-male-5.jpg" alt="avatar"></a></li>
													</ul>
													<div class="meta">
														<a href="#"><h5>package</h5></a>
														<span>4mb</span>
													</div>
													<div class="dropdown">
														<button type="button" class="btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-more-vertical"><g data-name="Layer 2"><g data-name="more-vertical"><rect width="24" height="24" transform="rotate(-90 12 12)" opacity="0"></rect><circle cx="12" cy="12" r="2"></circle><circle cx="12" cy="5" r="2"></circle><circle cx="12" cy="19" r="2"></circle></g></g></svg></button>
														<div class="dropdown-menu dropdown-menu-right">
															<button type="button" class="dropdown-item">Edit</button>
															<button type="button" class="dropdown-item">Share</button>
															<button type="button" class="dropdown-item">Delete</button>
														</div>
													</div>
												</li>
												<li>
													<ul class="avatars">
														<li><button class="btn round"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-file-text"><g data-name="Layer 2"><g data-name="file-text"><rect width="24" height="24" opacity="0"></rect><path d="M19.74 7.33l-4.44-5a1 1 0 0 0-.74-.33h-8A2.53 2.53 0 0 0 4 4.5v15A2.53 2.53 0 0 0 6.56 22h10.88A2.53 2.53 0 0 0 20 19.5V8a1 1 0 0 0-.26-.67zM9 12h3a1 1 0 0 1 0 2H9a1 1 0 0 1 0-2zm6 6H9a1 1 0 0 1 0-2h6a1 1 0 0 1 0 2zm-.29-10a.79.79 0 0 1-.71-.85V4l3.74 4z"></path></g></g></svg></button></li>
														<li><a href="#"><img src="dist/img/avatars/avatar-male-6.jpg" alt="avatar"></a></li>
													</ul>
													<div class="meta">
														<a href="#"><h5>plugins.js</h5></a>
														<span>3kb</span>
													</div>
													<div class="dropdown">
														<button type="button" class="btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-more-vertical"><g data-name="Layer 2"><g data-name="more-vertical"><rect width="24" height="24" transform="rotate(-90 12 12)" opacity="0"></rect><circle cx="12" cy="12" r="2"></circle><circle cx="12" cy="5" r="2"></circle><circle cx="12" cy="19" r="2"></circle></g></g></svg></button>
														<div class="dropdown-menu dropdown-menu-right">
															<button type="button" class="dropdown-item">Edit</button>
															<button type="button" class="dropdown-item">Share</button>
															<button type="button" class="dropdown-item">Delete</button>
														</div>
													</div>
												</li>
											</ul>
										</div>
										<!-- End of Files -->
									</div>
								</div>
							</div>
							<!-- End of Unitilities -->
						</div>
					</div>
					<!-- End of Chat Room -->
					<!-- Start of Chat Room -->
					
					<!-- End of Chat Room -->
				</div>
        <?php
    }
    public function readMessages($to_id)
    {
    	$messages = Messages::where(function ($query) use ($to_id) {
		    $query->where('from_id', '=', session()->get('id'))
		          ->where('to_id', '=', $to_id);
		})->orWhere(function ($query) use ($to_id) {
		    $query->where('from_id', '=', $to_id)
		          ->where('to_id', '=', session()->get('id'));
		});
		if ($messages->count() > 0) {
			foreach ($messages->get() as $message) {
				if ($message->from_id != session()->get('id') && $message->is_seen_by_me == '0') {
					$m = Messages::find($message->id);
					$m->is_seen_by_me = '1';
					$m->save();
					?>
					<li class="them">
						<!-- <img src="dist/img/avatars/avatar-male-3.jpg" alt="avatar"> -->
						<div class="content">
							<div class="message">
								<div class="bubble">
									<p><?php echo (formatText ($message->message));
										/*if (!empty($message->images)) {
											$xt = explode('.', $message->images);
											$xt = strtolower(($xt[0]));
											$ac = ['jpeg', 'jpg', 'png', 'gif'];
											if (in_array($xt, $ac)) {
											echo '<br /><img src="'.url($message->images).'">';
											} else {
												echo '<br /><i class="icon-'.$xt.'-alt"></i><a href="'.url($message->images).'">'.substr($message->images, 19).'</a>';
											}
										}*/
										 ?></p>
								</div>
							</div>
							<span><?php $time = (getdate(strtotime($message->created_at)));
							$okDates = 24-$time['hours']>12?$time['hours']:24-$time['hours'];
							$pm = 24-$time['hours']<12?'pm':'am';
							// print_r($time);
							echo $okDates.":".$time['minutes'].$pm; ?></span>
						</div>
					</li>
					<?php
				}
			}
		}
    }
    public function lastMessages($to_id)
    {
    	$messages = Messages::where(function ($query) use ($to_id) {
		    $query->where('from_id', '=', session()->get('id'))
		          ->where('to_id', '=', $to_id);
		})->orWhere(function ($query) use ($to_id) {
		    $query->where('from_id', '=', $to_id)
		          ->where('to_id', '=', session()->get('id'));
		})->orderBy('id', 'DESC');
		if ($messages->count() > 0) {
			$messages = $messages->first();
			// foreach ($messages->get() as $message) {
				if ($messages->from_id == session()->get('id') ) {
					$me = 'you: ';
				} else {
					$me = '';
				}
					$m = Messages::find($messages->id);
					// $m->is_seen_by_me = '1';
					// $m->save();
					return exit((substr($me,0,20).$messages->message));
				
			}
    }
    public function contactLists()
    {
    	$messages = Contacts::where('user_id', session()->get('id'))->orWhere('contact_id', session()->get('id'))->orderBy('last_activity', 'DESC');
										if ($messages->count() > 0) {
										    $dd = 10000;

									foreach ($messages->get() as $keyvalue) {
										$id = ($keyvalue->user_id == session()->get('id')) ? $keyvalue->contact_id : $keyvalue->user_id;
                                        
                                        
                                        $last_online = $keyvalue->created_at;
                                    	$start_date = new DateTime($last_online);
                                        $since_start = $start_date->diff(new DateTime());
                                        
                                    	if($since_start->i > 1) {
                                    	
											$lastMessage = $messages->orderby('created_at', 'desc')->first();

											// $lastMessage = strtotime($lastMessage);

											// $lastMessage = getdate($lastMessage);
											// $lastMessageFromUser = Messages::where(function ($query) use ($id) {
											//     $query->where('from_id', '=', session()->get('id'))
											//           ->where('to_id', '=', $id);
											// })->orWhere(function ($query) use ($id) {
											//     $query->where('from_id', '=', $id)
											//           ->where('to_id', '=', session()->get('id'));
											// })->orderBy('id', 'DESC')->first();
											$to_id = $id;
											// $user = User::find($to_id);
											// if ($user->type == 'user') {
											
												$lastMessageFromUser = Messages::where(function ($query) use ($to_id) {
												    $query->where('from_id', '=', session()->get('id'))
												          ->where('to_id', '=', $to_id);
												})->orWhere(function ($query) use ($to_id) {
												    $query->where('from_id', '=', $to_id)
												          ->where('to_id', '=', session()->get('id'));
												})->orderBy('id', 'DESC')->first();
											// 	$sentFrom = '';
											// } else {
											// 	$sentFrom = '';
											// 	$lastMessageFromUser = Messages::where('to_id', $to_id)->orderBy('id', 'DESC')->first();
											// }

											$day = getdate(strtotime($lastMessage->created_at));
											$lastSent = (substr($lastMessage->created_at, 0, 10) == date("Y-m-d") ? 'Today' : $day['month'].'/'.$day['mday']);
											// $lastMessagesfrom_id = ($lastMessageFromUser->from_id) ? $lastMessageFromUser->from_id : "";
											if (isset($lastMessageFromUser->from_id) && isset($lastMessageFromUser->message) && $lastMessageFromUser->from_id == session()->get('id')) {
												$lsm = 'you: '.$lastMessageFromUser->message;
											} else {
												$lsm = isset($lastMessageFromUser->message) ? $lastMessageFromUser->message : "";
											}
                                    	}
											
									?>
									<li id="chatOpen" chat-id="<?=$id?>">
										<a href="#chat1" class="filter direct <?=$dd==1?'active':''?>" data-chat="open" data-toggle="tab" role="tab" aria-controls="chat1" aria-selected="true">
											<div class="status online"><img src="<?php echo url('/'.User::find($id)->profile_picture) ?>" alt="avatar"><i data-eva="radio-button-on"></i></div>
											<div class="content">
												<div class="headline">
													<h5><?php echo (User::find($id)->username); ?></h5>
													<span><?php echo isset($lastSent) ? $lastSent : ""; ?>&nbsp;&nbsp;</span>
												</div>
												<p id="lastMessage" style="color: inherit;"><?php echo isset($lsm) ? htmlentities(strip_tags(substr($lsm,0,20))) : ""; ?></p>
											</div>
										</a>
									</li>
									<?php
									 }}
    }
}
?>