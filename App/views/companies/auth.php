<?php includeFile('inc.head'); ?>

				<div class="container">
					<div class="modal fade show" id="compose" tabindex="-1" role="dialog" aria-labelledby="compose" aria-modal="true" style="display: block; padding-left: 17px;" data-keyboard="false" data-backdrop="static">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">
						    
							<center><h5>Register company</h5></center>

						</div>
						<div class="modal-body">
						    	<div id="errorPage"></div>
							<ul class="nav" role="tablist">
								<li><a href="#details" class="active" data-toggle="tab" role="tab" aria-controls="details" aria-selected="true">Login</a></li>
								<li><a href="#participants" data-toggle="tab" role="tab" aria-controls="participants" aria-selected="false">Register</a></li>
							</ul>
							<div class="tab-content">
								<!-- Start of Login -->
								<div class="details tab-pane fade show active" id="details" role="tabpanel">
									<form action="<?=url('company/log')?>">
										<div class="form-group">
											<label>Company email</label>
											<input type="text" class="form-control" placeholder="Your email?" name="email">
											<span class="text-danger" id="loginUsername"></span>
										</div>
										<div class="form-group">
											<label>Key</label>
											<input type="password" class="form-control" placeholder="Your key?" name="key">
											<span class="text-danger" id="loginPassword"></span>
										</div>
										<div class="form-group">
												<button type="submit" name="login" class="btn primary">Submit</button>
										</div>
									</form>
								</div>
								<!-- End of Login -->
								<!-- Start of Register -->
								<div class="participants tab-pane fade" id="participants" role="tabpanel">
									<form action="<?=url('company/reg')?>">
										<div class="form-group">
											<label>Company name</label>
											<input type="text" name="company_name" class="form-control" placeholder="Company name?">
											<span class="text-danger" id="username"></span>
										</div>
										<div class="form-group">
											<label>Comapny Email</label>
											<input type="text" name="email" class="form-control" placeholder="Company email?">
											<span class="text-danger" id="username"></span>
										</div>
										<div class="form-group" stype="display:none;">
											<label>Comapny size</label>
											<select class="form-control" name="company_size">
												<option value="" selected="">Company size</option>
												<option value="10">0-10</option>
												<option value="20">10-20</option>
												<option value="100">20-100</option>
												<option value="more">100+</option>
											</select>
											<span class="text-danger" id="role"></span>
										</div>
										<div class="form-group">
												<button type="submit" name="register" class="btn primary">Submit</button>
										</div>
										<br>
									</form>
								</div>
								<!-- End of Register -->
							</div>
						</div>
						<!-- <div class="modal-footer">
							<button type="submit" class="btn primary">Submit</button>
						</div> -->
					</div>
				</div>
			</div>
				</div>
			<hr>

					<?php includeFile('inc.footer'); ?>
			        <script src="<?=url('dist/js/jquery.js')?>"></script>
			        <script src="<?=url('js/sweetalert.js')?>"></script>	
					<script src="<?=url('dist/js/vendor/bootstrap.min.js')?>"></script>
						<script type="text/javascript">
						
						$(document).ready(function(){
		$("#compose").modal();
  		$('#compose').modal({
    		backdrop: 'static',
    		keyboard: false
		});

});

						
							$(document).delegate("form", 'submit', function (e) {
								e.preventDefault();
								var url = $(this).attr('action');

								$.ajax({
									url: url,
									data: new FormData(this),
									type: "POST",
									contentType: false,
									cache: false,
									processData: false,
									beforeSend: function () {
										$("button").attr('disabled', 'disabled');
										$("button").html('Sending...');
									},
									success: function (data) {
										$("button").removeAttr('disabled', 'disabled');
										$("button").html('Submit');
										// $("#errorPage").append(data);
										if (data == 'ok') {
											location.href="dashboard";
										} else {
											Swal.fire(
											  'Error',
											   data,
											  'error'
											)
										}
									},
									error : function () {
										$("button").removeAttr('disabled', 'disabled');
										$("button").html('Submit');
									}
								});
							});
						</script>