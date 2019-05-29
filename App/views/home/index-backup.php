<?php includeFile('inc.head'); ?>
<style type="text/css">
	.me {
		/*float: right;*/
		/*background-color: #007bff;*/
	}
	.them {
		/*float: left;*/
		/*background: #6c757d;*/
	}
</style>
	<body>
		<!-- Layout -->
		<div class="layout">
			<!-- Start of Navigation -->
			<nav class="navigation">
				<div class="container">
					<a href="#" class="logo" rel="home"></a>
					<ul class="nav" role="tablist">
						<li  data-toggle="tooltip" data-placement="right" title="Profile"><a class="btn" href="#settings" data-toggle="tab" role="tab" aria-controls="settings" aria-selected="false"><img src="<?php echo(url('/'.User::find(session()->get('id'))->profile_picture)) ?>" alt="avatar"><i data-eva="radio-button-on"></i></a></li>
						<li  data-toggle="tooltip" data-placement="right" title="Messages"><a href="#conversations" class="active fa fa-comment fa-2x" data-toggle="tab" role="tab" aria-controls="conversations" aria-selected="true"><i class="" data-eva="message-square" data-eva-animation="pulse"></i></a></li>
						<li  data-toggle="tooltip" data-placement="right" title="Set profile"><a class="fa fa-gear fa-2x" href="#settings" data-toggle="tab" role="tab" aria-controls="settings" aria-selected="false"><i data-eva="settings" data-eva-animation="pulse"></i></a></li>
						<li  data-toggle="tooltip" data-placement="right" title="Switch dark mode"><button type="button" class="btn mode"><i class="fa fa-lightbulb-o fa-2x" data-eva="bulb" data-eva-animation="pulse"></i></button></li>
						<li  data-toggle="tooltip" data-placement="right" title="Friends"><a href="#friends" data-toggle="tab" role="tab" aria-controls="friends" aria-selected="true"><i class="fa fa-users fa-2x" data-eva="people" data-eva-animation="pulse"></i></a></li>
						<li  data-toggle="tooltip" data-placement="right" title="Logout"><a href="<?=url('logout')?>" data-toggle="" role="tab" aria-controls="notifications" aria-selected="false"><i class="fa fa-sign-out fa-2x" data-eva="bell" data-eva-animation="pulse"></i></a></li>
					</ul>
				</div>
			</nav>
			<!-- End of Navigation -->
			<!-- Start of Sidebar -->
			<div class="sidebar">
				<div class="">
					<div class="tab-content">
						<!-- Start of Discussions -->
						<div class="tab-pane fade show active" id="conversations" role="tabpanel">
							<div class="top">
								<form>
									<input type="search" class="form-control" placeholder="Search">
									<button type="submit" class="btn prepend"><i class="fa fa-search" data-eva="search"></i></button>
								</form>
								<ul class="nav" role="tablist">
									<li><a href="#direct" class="filter-btn active" data-toggle="tab" data-filter="direct">Chat </a></li>
								</ul>
								
								<div class="middle">
								<h4>Discussions</h4>
								<button type="button" class="btn round" data-toggle="modal" data-target="#compose"><i class="fa fa-comments" data-eva="edit-2"></i></button>&nbsp;
								<button type="button" class="btn round" data-toggle="modal" data-target="#create_group"><i class="fa fa-plus" data-eva="edit-2"></i></button>
								</div>
							</div>
								
									<div>
								<ul class="nav discussions" role="tablist" id="contactLists">
									<?php 

									// $Messages = Messages::where(function ($query) {
								 //            return $query->where('from_id', session()->get('id'))->orWhere('to_id', session()->get('id'))->distinct();
								 //        });//
								        // ->first();
								        // print_r($Messages);
								        // exit;
        $messages = Contacts::where('user_id', session()->get('id'))->orWhere('contact_id', session()->get('id'))->orderBy('id', 'DESC');
										if ($messages->count() > 0) {

									foreach ($messages->get() as $keyvalue) {
										$id = ($keyvalue->user_id == session()->get('id')) ? $keyvalue->contact_id : $keyvalue->user_id;

											$lastMessage = $messages->orderby('created_at', 'desc')->first();

											// $lastMessage = strtotime($lastMessage);

											// $lastMessage = getdate($lastMessage);
											$day = getdate(strtotime($lastMessage->created_at));
											$lastMessageFromUser = Messages::where(function ($query) use ($id) {
											    $query->where('from_id', '=', session()->get('id'))
											          ->where('to_id', '=', $id);
											})->orWhere(function ($query) use ($id) {
											    $query->where('from_id', '=', $id)
											          ->where('to_id', '=', session()->get('id'));
											})->orderBy('id', 'DESC')->first();

											$lastSent = (substr($lastMessage->created_at, 0, 10) == date("Y-m-d") ? 'Today' : $day['month'].'/'.$day['mday']);
											
									?>
									<li id="chatOpen" chat-id="<?=$id?>">
										<a href="#chat1" class="filter direct" data-chat="open" data-toggle="tab" role="tab" aria-controls="chat1" aria-selected="true">
											<div class="status online"><img src="<?php echo url('/'.User::find($id)->profile_picture) ?>" alt="avatar"><i data-eva="radio-button-on"></i></div>
											<div class="content">
												<div class="headline">
													<h5><?php echo htmlentities(User::find($id)->username); ?></h5>
													<span><?php //echo htmlentities(substr($lastSent,0,20)); ?>&nbsp;&nbsp;</span>
												</div>
												<p id="lastMessage<?=$id?>"><?php echo htmlentities(strip_tags(substr($lastMessageFromUser->message,0,20))) ?></p>
											</div>
										</a>
									</li>
									<?php }} ?>
								</ul>
							</div>
						</div>
						<!-- End of Discussions -->
						<!-- Start of Friends -->
							<!-- add people -->
							<div class="tab-pane fade" id="friends" role="tabpanel">
							<div class="top">
								<form>
									<input type="search" class="form-control" placeholder="Search">
									<button type="submit" class="btn prepend"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-search"><g data-name="Layer 2"><g data-name="search"><rect width="24" height="24" opacity="0"></rect><path d="M20.71 19.29l-3.4-3.39A7.92 7.92 0 0 0 19 11a8 8 0 1 0-8 8 7.92 7.92 0 0 0 4.9-1.69l3.39 3.4a1 1 0 0 0 1.42 0 1 1 0 0 0 0-1.42zM5 11a6 6 0 1 1 6 6 6 6 0 0 1-6-6z"></path></g></g></svg></button>
								</form>
								<div class="middle">
								<h4>Friends</h4>
								
								</div>
							</div>
							
								
									<div >
								<ul class="users">
								    <?php 

								    	$us = User::find(session()->get('id'));
								    	// echo $us->company_id;
										$users = User::where('company_id',$us->company_id);

										foreach ($users->get() as $user) {

										 ?>
										 <?php if($user->id != session()->get('id')) { 
										 
										$last_online = $user->last_online;
                                    	// $start_date = new DateTime($last_online);
                                     //    $since_start = $start_date->diff(new DateTime());
                                        // echo $since_start->days.' days total<br>';
                                        // echo $since_start->d.' days<br>';
                                        // echo $since_start->h.' hours<br>';
                                        // echo $since_start->i.' minutes<br>';
                                        // echo $since_start->s.' seconds<br>';
                                    	// die($id);
                                    	
										$last_online = $user->last_online;
								    	$onlineStatus = timeAgo($last_online);
                                    	// if($since_start->i > 60) {
                                    	//     $minutesAgo = $since_start->h.' hours ago';
                                    	// } elseif ($since_start->h > 24) {
                                    	//     $minutesAgo = $since_start->days.' days ago';
                                    	// } else {
                                     //    	$minutesAgo = $since_start->i.' minutes ago';
                                    	// }
                                    	// if  ($since_start->i < 1) {
                                    	//     $onlineStatus = 'Online <i class="fa fa-circle fa-green"></i>';
                                    	// } else {
                                    	//     $onlineStatus = 'Away <i class="fa fa-circle fa-orange"></i> '.$minutesAgo;
                                    	// }
    	?>
										<li id="chatOpen" chat-id="<?php echo $user->id ?>"  data-dismiss="modal">
									    <a href="#">
											<div class="status online"><img src="<?php echo url($user->profile_picture); ?>" alt="avatar"><i data-eva="radio-button-on"></i></div>
											<div class="content">
												<h5><?php echo $user->username ?></h5>
												<span><?php echo $onlineStatus; ?></span>
											</div>
											<div class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-person"><g data-name="Layer 2"><g data-name="person"><rect width="24" height="24" opacity="0"></rect><path d="M12 11a4 4 0 1 0-4-4 4 4 0 0 0 4 4z"></path><path d="M18 21a1 1 0 0 0 1-1 7 7 0 0 0-14 0 1 1 0 0 0 1 1z"></path></g></g></svg></div>
											<!--<div class="custom-control custom-checkbox">-->
												<!--<input type="checkbox" class="custom-control-input" id="user1">-->
												<!--<label class="custom-control-label" for="user1"></label>-->
											</a>
										</li>
									<?php } ?>
									<?php } ?>
									<!--<li chat-id="<?php echo $user->id ?>"  data-dismiss="modal">-->
									<!--	<a href="#">-->
									<!--		<div class="status online"><img src="dist/img/avatars/avatar-male-1.jpg" alt="avatar"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-radio-button-on"><g data-name="Layer 2"><g data-name="radio-button-on"><rect width="24" height="24" opacity="0"></rect><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm0 18a8 8 0 1 1 8-8 8 8 0 0 1-8 8z"></path><path d="M12 7a5 5 0 1 0 5 5 5 5 0 0 0-5-5z"></path></g></g></svg></div>-->
									<!--		<div class="content">-->
									<!--			<h5>Ham Chuwon</h5>-->
									<!--			<span>Florida, US</span>-->
									<!--		</div>-->
									<!--		<div class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-person"><g data-name="Layer 2"><g data-name="person"><rect width="24" height="24" opacity="0"></rect><path d="M12 11a4 4 0 1 0-4-4 4 4 0 0 0 4 4z"></path><path d="M18 21a1 1 0 0 0 1-1 7 7 0 0 0-14 0 1 1 0 0 0 1 1z"></path></g></g></svg></div>-->
									<!--	</a>-->
									<!--</li>-->
								</ul>
							</div>
						</div>
						<!-- ! end of friend list -->
						<!-- End of Friends -->
						<!-- Start of Notifications -->
						<!-- End of Notifications -->
						<!-- Start of Settings -->
						<div class="settings tab-pane fade" id="settings" role="tabpanel">
							<div class="user">
								<label>
									<input type="file">
									<img src="<?php echo(url('/'.User::find(session()->get('id'))->profile_picture)) ?>" alt="avatar">
								</label>
								<div class="content">
									<?php 
										$u = User::find(session()->get('id'));
									 ?>
									<h5><?php echo $u->username; ?></h5>
									<span><?php echo $u->user_role ?></span>
								</div>
							</div>
							<h4>Settings</h4>
							<ul id="preferences">
								<!-- Start of Account -->
								<li>
									<a href="#" class="headline" data-toggle="collapse" aria-expanded="false" data-target="#account" aria-controls="account">
										<div class="title">
											<!-- <h5>Account</h5> -->
											<p>Update your profile details</p>
										</div>
										<i data-eva="arrow-ios-forward"></i>
										<i data-eva="arrow-ios-downward"></i>
									</a>
									<div class="content collapse show" id="account" data-parent="#preferences">
										<div class="inside">
											<form class="account" form-type="account">
												<?php 
													$user = User::find(session()->get('id'));
												 ?>
												<div class="form-row">
													<div class="col-sm-6">
														<div class="form-group">
															<label>First Name</label>
															<input name="first_name" type="text" class="form-control" placeholder="First name" value="<?php echo $user->first_name ?>">
														</div>
													</div>
													<div class="col-sm-6">
														<div class="form-group">
															<label>Last Name</label>
															<input name="last_name" type="text" class="form-control" placeholder="Last name" value="<?php echo $user->last_name ?>">
														</div>
													</div>
												</div>
												<div class="form-group">
													<label>Email Address</label>
													<input name="email" type="email" class="form-control" placeholder="Enter your email address" value="<?php echo $user->email ?>">
												</div>
												<div class="form-group">
													<label>Profile Picture</label>
									
           <div class="previewv text-center">
                <img class="preview-imgv" src="
                <?php
                if($user->profile_picture == "profiles/avatar.png"):
                ?>
                <?=url('/dist/img/icons8-administrator-male-90.png')?>
                <?php
                else:
                ?>
                <?=$user->profile_picture;?>
                <?php
                endif;
                ?>
                ">
                <div class="browse-buttonv">
                    <i class="fa fa-pencil"></i>
                    <input class="browse-inputv" type="file" required="" name="file" id="file">
                </div>
                <span class="Error"></span>
            </div>		
												
												</div>
												<div class="form-group">
													<label>Biography</label>
													<textarea class="form-control" placeholder="Tell us a little about yourself" name="bio"><?php echo $user->bio ?></textarea>
												</div>
												<button type="submit" id="button-account" class="btn primary">Save settings</button>
											</form>
										</div>
									</div>
								</li>
								<!-- End of Account -->
								<!-- End of Appearance -->
							</ul>
						</div>
						<!-- End of Settings -->
					</div>
				</div>
			</div>
			<!-- End of Sidebar -->
			<!-- Start of Chat -->
			<div class="chat" id="chatparent">
				<div style="text-align: center; margin-top: calc(50vw - 50%);">
					<!--<img src="<?=url('profiles/avatar.png')?>">-->
                    <i class="fa fa-users fa-5x"></i>
					<h2 class="center">Start a chat with someone.</h2>
					<p>Click on the user you want to chat with :)</p>
				</div>
			</div>
			<!-- End of Chat -->
			<!-- Start of Compose -->
			<div class="modal fade" id="compose" tabindex="-1" role="dialog" aria-labelledby="compose" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5>Compose</h5>
							<button type="button" class="btn round" data-dismiss="modal" aria-label="Close">
								<i class="fa fa-times" data-eva="close"></i>
							</button>
						</div>
						<div class="modal-body">
							<ul class="nav" role="tablist">
								<!-- <li><a href="#details" class="active" data-toggle="tab" role="tab" aria-controls="details" aria-selected="false">Details</a></li> -->
								<li><a href="#participants" class="active" data-toggle="tab" role="tab" aria-controls="participants" aria-selected="true">Participants</a></li>
							</ul>
							<div class="tab-content">
								<!-- Start of Details -->
								<div class="details tab-pane fade" id="details" role="tabpanel">
									<form>
										<div class="form-group">
											<label>Title</label>
											<input type="text" class="form-control" placeholder="What's the topic?">
										</div>
										<div class="form-group">
											<label>Message</label>
											<textarea class="form-control" placeholder="Hmm, are you friendly?"></textarea>
										</div>
									</form>
								</div>
								<!-- End of Details -->
								<!-- Start of Participants -->
								<div class="participants tab-pane fade show active" id="participants" role="tabpanel">
									<div class="search">
										<form>
											<input type="search" class="form-control" placeholder="Search">
											<button type="submit" class="btn prepend"><i class="fa fa-search" data-eva="search"></i></button>
										</form>
									</div>
									<h4>Users</h4>
									<hr>
									<ul class="users">
										<?php 

								    	$u = User::find(session()->get('id'));
										$users = User::where('company_id',$u->company_id);


										foreach ($users->get() as $user) {

										 ?>
										 <?php if($user->id != session()->get('id')) { 
										 
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
    	?>
										<li id="chatOpen" chat-id="<?php echo $user->id ?>"  data-dismiss="modal">
											<div class="status online"><img src="<?php echo url($user->profile_picture); ?>" alt="avatar"><i data-eva="radio-button-on"></i></div>
											<div class="content">
												<h5><?php echo $user->username ?></h5>
												<span><?php echo $onlineStatus; ?></span>
											</div>
											<div class="custom-control custom-checkbox">
												<input type="checkbox" class="custom-control-input" id="user1">
												<label class="custom-control-label" for="user1"></label>
											</div>
										</li>
									<?php } ?>
									<?php } ?>
									</ul>
								</div>
								<!-- End of Participants -->
							</div>
						</div>
						<div class="modal-footer">
							<button type="submit" class="btn primary">Compose</button>
						</div>
					</div>
				</div>
			</div>
			<!-- End of Compose -->
			<!-- Start of create groups -->

						<div class="modal fade" id="create_group" tabindex="-1" role="dialog" aria-labelledby="compose" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5>Create groups</h5>
							<button type="button" class="btn round" data-dismiss="modal" aria-label="Close">
								<i class="fa fa-times" data-eva="close"></i>
							</button>
						</div>
						<div class="modal-body">
							<ul class="nav" role="tablist">
								<!-- <li><a href="#details" class="active" data-toggle="tab" role="tab" aria-controls="details" aria-selected="false">Details</a></li> -->
								<li><a href="#participants" class="active" data-toggle="tab" role="tab" aria-controls="participants" aria-selected="true">Group name?</a></li>
							</ul>
							<div class="tab-content">
								<!-- Start of Participants -->
								<div class="participants tab-pane fade show active" id="participants" role="tabpanel">
									<div class="search">
										<!-- <form>
											<input type="search" class="form-control" placeholder="Search">
											<button type="submit" class="btn prepend"><i class="fa fa-search" data-eva="search"></i></button>
										</form> -->
									</div>

									<form autocomplete="off" action="<?=url('group/store')?>" form-type="create_group" enctype="multipart/form-data" method="POST">
										<div class="form-group">
											<label>Group name</label>
											<input type="text" name="username" class="form-control" placeholder="" required="">
										</div>

						                <div class="previewv text-center">
						                <img class="preview-imgv" src="<?=url('/dist/img/icons8-administrator-male-90.png')?>">
						                <div class="browse-buttonv">
						                    <i class="fa fa-pencil"></i>
						                    <input class="browse-inputv" type="file" required="" name="file" id="file">
						                </div>
						                <span class="Error"></span>
						            </div>	
								</div>
								<!-- End of Participants -->
							</div>
						</div><br /><br /><br />
						<div class="modal-footer">
							<button type="submit" id="button-group" class="btn primary">Create</button>
						</div>
					</form>
					</div>
				</div>
			</div>

			<!-- End of create groups -->
		</div>
		<!-- Layout -->
		<!-- Start of Utility -->
							<!-- End of Utility -->
							
						
<?php includeFile('inc.footer'); ?>					

   <script src="<?=url('dist/js/jquery.js')?>"></script>
   <script src="<?=url('js/ion.sound.js')?>"></script>
			        <script src="<?=url('js/sweetalert.js')?>"></script>	
			        <?php $time = (getdate(strtotime(Date("Y-m-d h:i:s"))));
													$okDates = 24-$time['hours']>12?$time['hours']:24-$time['hours'];
													$pm = 24-$time['hours']<12?'pm':'am';
													// print_r($time);?>
													
					<script src="<?=url('dist/js/vendor/bootstrap.min.js')?>"></script>
						<script type="text/javascript">
							function updateContact() {
								urlCont = "<?=url('message/contactLists')?>";
								$.get(urlCont, function (data) {
								            $("#contactLists").html('');
											$("#contactLists").append(data);
										});
							}
							// $(".mode").toggle(function(){

						 //            $('head').append('<link href="<?=url("dist/css/dark.min.css")?>" id="dark" type="text/css" rel="stylesheet">');
							// 	});
							// $(".mode").click(function() {
    			// 				clicked = 1;
						 //        if (clicked) {
						 //            $("head").append('<link href="<?=url("dist/css/dark.min.css")?>" id="dark" type="text/css" rel="stylesheet">');
						 //            clicked = 1
						 //        } else {
						 //        	// alert();
						 //            $('#dark').remove();
						 //            clicked = 0
						 //        }
						 //    })
							// $(".modal").modal();
							function readMessages(id) {
								if (id) {
									ion.sound({
							            sounds: [
							                {name: "beer_can_opening"},
							                {name: "bell_ring"}
							            ],
							            path: "public/sounds/",
							            preload: true,
							            volume: 1.0
							        });
									// ion.sound.init();

									var url = "<?=url('message/readMessages/');?>"+id;
									setInterval(function() {
										$.get(url, function (data) {
											if(data) {
												$("#messagesLists"+id).append(data);
												ion.sound.play("bell_ring");

												$(".newMessageNotifier").removeAttr('hidden');
												// alert(($('#messagesLists').scrollHeight - $('#messagesLists').offsetHeight))
												// if ($('#messagesLists').scrollTop >= ($('#messagesLists').scrollHeight - $('#messagesLists').offsetHeight)) {
												// 		alert($('#scroll').scrollTop)
												// 	    // $('#scroll').scrollTop = $('#scroll').scrollHeight;
												// 	}
											}
										});
									var urls = "<?=url('message/lastMessages/');?>"+id;
									$.get(urls, function (datas) {
											if(datas) {
												$("#lastMessage"+id).html(datas.substr(0,20))
											}
										});
									}, 5000);
								}
							}
							
							
							// setInterval(function(url) {
							// var url = "<?=url('message/readMessages/');?>"+mMe;
							// // alert('ss');
							// 	$.get(url, function (data) {
							// 		$("#messagesLists").append(data);
							// 	});
							// }, 500);

							$(document).delegate('#chatOpen', 'click', function () {
								var id = $(this).attr('chat-id');
								// alert(id);
								 updateContact();
								readMessages(id)
								$.ajax({
									url: "<?=url('Message/fetchMessage')?>/"+id,
									data: {id: id},
									type: "POST",
									cache: false,
									contentType: false,
									processData: false,
									beforeSend: function () {
										$("#chatparent").html("<div class='message-loader'>Loading data <i class='fa fa-spinner fa-spin '></i></div>");
									},
									success: function (data) {
										$("#chatparent").empty();
										$("#chatparent").append(data);
											 $("#scroll").animate({
										        scrollTop: $('#scroll')[0].scrollHeight}, 10);
										
									}
								});
								// $("#chatparent").load("<?php //url('Message/sendMesage')?>", function () {

								// $("#chatparent").animate({
							 //        scrollTop: $('#chatparent')[0].scrollHeight}, 1);
								// });
								// chatparent
							});
							$(document).delegate("form", 'submit', function (e) {
								e.preventDefault();
								var type = $(this).attr('form-type');
								if (type) {
									if (type == 'message') {
								var message = $("#messageToSend").val();
								var time = '<?php echo $okDates.":".$time['minutes'].$pm; ?>';
								var tto_id = $("#to_id").val();
								if (message) {
									$.ajax({
										url: "<?=url('Message/sendMessage')?>/",
										data: new FormData(this),
										type: "POST",
										cache: false,
										contentType: false,
										processData: false,
										beforeSend: function () {
										},
									success: function (message) {
									    
											var  data = '<li class="me"><div class="content"><div class="message"><div class="bubble"><p>'+message+'</p></div></div><span>'+time+'<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="eva eva-done-all"><g data-name="Layer 2"><g data-name="done-all"><rect width="24" height="24" opacity="0"></rect><path d="M16.62 6.21a1 1 0 0 0-1.41.17l-7 9-3.43-4.18a1 1 0 1 0-1.56 1.25l4.17 5.18a1 1 0 0 0 .78.37 1 1 0 0 0 .83-.38l7.83-10a1 1 0 0 0-.21-1.41z"></path><path d="M21.62 6.21a1 1 0 0 0-1.41.17l-7 9-.61-.75-1.26 1.62 1.1 1.37a1 1 0 0 0 .78.37 1 1 0 0 0 .78-.38l7.83-10a1 1 0 0 0-.21-1.4z"></path><path d="M8.71 13.06L10 11.44l-.2-.24a1 1 0 0 0-1.43-.2 1 1 0 0 0-.15 1.41z"></path></g></g></svg></span></div></li>';


											$("#messagesLists"+tto_id).append(data);
											updateContact();

											 $("#scroll").animate({
										        scrollTop: $('#scroll')[0].scrollHeight}, 10);
											$("#lastMessage"+tto_id).html('you: '+message.substr(0,20))
											// this.reset();//$("form").resetForm();
											 $("#fileToSend").val('');
											 $("#messageToSend").val('');
										// if(data) {

										// var  text = '<li><div class="content"><div class="message"><div class="bubble"><p>'+data+'</p></div></div><span>'+time+'</span></div></li>';


										// $("#messagesLists").append(text);
										// }

										 $("#scroll").animate({
									        scrollTop: $('#scroll')[0].scrollHeight}, 10);
										
									}
								});
								}
									} else if (type == 'account') {
										url = "<?=url('auth/updateaccount')?>";
										$.ajax({
											url: url,
											type: "POST",
											data: new FormData(this),
											cache: false,
											processData: false,
											contentType: false,
											beforeSend: function () {
												$("#button-account").attr('disabled', 'disabled');
												$("#button-account").html('Sending...');
											},
											success: function (data) {
												$("#button-account").removeAttr('disabled', 'disabled');
												$("#button-account").html('Save settings');
												if (data == 'ok') {
													Swal.fire(
													  'Saved',
													   'Success, account updated.',
													  'success'
													)
												} else {
													Swal.fire(
													  'Error',
													   data,
													  'error'
													)
												}
											},
											error: function (e) {
												console.log(e);
													Swal.fire(
													  'Error',
													   'Check console',
													  'error'
													)
												$("#button-account").removeAttr('disabled', 'disabled');
												$("#button-account").html('Save settings');
											}
										});
									} else if (type == 'create_group') {
										url = $(this).attr('action');//"<?php //url('auth/updateaccount')?>";
										$.ajax({
											url: url,
											type: "POST",
											data: new FormData(this),
											cache: false,
											processData: false,
											contentType: false,
											beforeSend: function () {
												$("#button-group").attr('disabled', 'disabled');
												$("#button-group").html('Sending...');
											},
											success: function (data) {
												$("#button-group").removeAttr('disabled', 'disabled');
												$("#button-group").html('Save settings');
												if (data == 'ok') {
													Swal.fire(
													  'Saved',
													   'Success, group created..',
													  'success'
													)
												} else {
													Swal.fire(
													  'Error',
													   data,
													  'error'
													)
												}
											},
											error: function (e) {
												console.log(e);
													Swal.fire(
													  'Error',
													   'Check console',
													  'error'
													)
												$("#button-account").removeAttr('disabled', 'disabled');
												$("#button-account").html('Save settings');
											}
										});
									}
								}
							});

							
							setInterval(function () {
								updateContact();
							}, 10000);

							var mMe = $("#to_id").val();
							if(mMe) {
								readMessages(id);
							}
							// }, 1000)
						</script>					