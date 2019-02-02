<?php 
	header('Access-Control-Allow-Origin: *');  

	header('Origin: https://facebook.com');
?>
<html lang="vi">
	<head>
		<meta charset="utf-8">
		<title>Xoá status</title>
		<!-- ===== Bootstrap CSS ===== -->
		<link href="bootstrap.min.css?ver=2" rel="stylesheet">
		
		<link href="toast-master/css/jquery.toast.css" rel="stylesheet">
		
		<link href="daterangepicker.css" rel="stylesheet" type="text/css" />
		<!-- ===== Plugin CSS ===== -->
		<!-- ===== Animation CSS ===== -->
		<link href="animate.css?ver=2" rel="stylesheet">
		<!-- ===== Custom CSS ===== -->
		<link href="style.css?ver=2" rel="stylesheet">
		<!-- ===== Color CSS ===== -->
		<link href="default.css?ver=2" id="theme" rel="stylesheet">
		<style>
			iframe{
				margin-top:50px;
				margin-bottom:50px;
			}
			</style>
		
	</head>
	<body class="mini-sidebar no-header">
    <div id="wrapper">
			<div class="container-fluid">
				<div class="row" id="logindiv">
					<div class="col-md-12">
						<div class="white-box">
							<h3 class="box-title">Đăng nhập bằng tài khoản Facebook</h3>
							<div>
								<div class="form-group">
									<label>Username</label>
									<div class="input-group">
										<div class="input-group-addon"><i class="ti-user"></i></div>
										<input type="text" class="form-control" id="user" placeholder="Username"> 
									</div>
								</div>
								<div class="form-group">
									<label >Pass</label>
									<div class="input-group">
										<div class="input-group-addon"><i class="icon-key"></i></div>
										<input type="password" class="form-control" id="pass" placeholder="Password"> 
									</div>
								</div>
								<button id="submit" class="btn btn-success waves-effect waves-light m-r-10">Đăng nhập</button>
								<br>
								<div id="loginform" hidden>
									<iframe id="login" width="100%" ></iframe>
									<div class="form-group">
										<label class="col-md-12">Coppy nội dung vào đây</label>
										<div class="col-md-12">
											<textarea class="form-control" rows="5" id="tokenpaste"></textarea>
										</div>
									</div>
								</div>
								<!-- height="0px" width="0px" hidden -->
							</div>
						</div>
					</div>
				</div>
				<div class="row" id="tokendiv" hidden>
					<div class="col-md-12">
						<div class="white-box">
							<h3 class="box-title">Thực hiện xoá</h3>
							<div>
								<div class="form-group">
									<label >Token của bạn</label>
									<div class="input-group">
										<div class="input-group-addon"><i class="ti-key"></i></div>
										<input type="text" class="form-control" id="token" disabled> 
									</div>
								</div>
								<div class="form-group">
                                    <div class="example">
                                        <h5 class="box-title m-t-30">Xoá các Status trong phạm vi</h5>
                                        <input type="text" id="phamvi" class="form-control input-daterange-datepicker" name="daterange" value="<? echo date('d/m/Y - d/m/Y');?>" /> </div>
                                </div>
								<button id="xoa" class="btn btn-success waves-effect waves-light m-r-10">Thực hiện</button>
							</div>
						</div>
					</div>
				</div>
				<div class="row" id="trangthai" hidden>
					<div class="col-md-12">
						<div class="white-box">
							<h3 class="box-title" id="title">Đang thực hiện</h3>
							
								<div class="form-group">
									<label id="sum">Tìm thấy : 0 bài viết</label><br>
									<label id="info">Đã xoá được : 0 bài viết</label><br>
									
									<label id="loi">Lỗi : 0 bài viết</label><br>
									<div class="col-md-12 col-sm-12 p-r-40" id="loadbar">
									<div class="progress progress-lg">
										<div class="progress-bar progress-bar-info active progress-bar-striped" height="100px" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%" role="progressbar"> <span class="sr-only"></span> </div>
									</div>
								</div>
								</div>
								
						</div>
					</div>
				</div>

				
			</div>
			<!-- /.container-fluid -->
			<footer class="footer t-a-c"> © 2019 Thanh Bình
			</footer>
</div>
		<script src="jquery.min.js"></script>
		<!-- ===== Bootstrap JavaScript ===== -->
		<script src="bootstrap.min.js"></script>
		<!-- ===== Slimscroll JavaScript ===== -->
		<script src="jquery.slimscroll.js"></script>
		<!-- ===== Wave Effects JavaScript ===== -->
		<script src="waves.js"></script>
		
		<script src="toast-master/js/jquery.toast.js"></script>
		
		<script src="moment/moment.js"></script>
		<script src="daterangepicker.js"></script>
		<script type="text/javascript">
		function setCookie(name,value,days) {
			var expires = "";
			if (days) {
				var date = new Date();
				date.setTime(date.getTime() + (days*24*60*60*1000));
				expires = "; expires=" + date.toUTCString();
			}
			document.cookie = name + "=" + (value || "")  + expires + "; path=/";
		}
		function getCookie(name) {
			var nameEQ = name + "=";
			var ca = document.cookie.split(';');
			for(var i=0;i < ca.length;i++) {
				var c = ca[i];
				while (c.charAt(0)==' ') c = c.substring(1,c.length);
				if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
			}
			return null;
		}
		function eraseCookie(name) {   
			document.cookie = name+'=; Max-Age=-99999999;';  
		}
		
		function getOther(url){
			resp = "";
			$.ajax({
				async: false,
				type: 'GET',
				url: url,
				success: function(data) {
					resp = data;
				}
			});
			return resp;
		}
		function validateEmail(email) {
			var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
			return re.test(String(email).toLowerCase());
		}
		function phonecheck(p) {
			var phoneRe = /^[(]{0,1}[0-9]{3}[)]{0,1}[-\s\.]{0,1}[0-9]{3}[-\s\.]{0,1}[0-9]{4}$/;
			var digits = p.replace(/\D/g, "");
			return phoneRe.test(digits);
			}
		//end function 
		$(document).ready(function(){
			$('.input-daterange-datepicker').daterangepicker({
				buttonClasses: ['btn', 'btn-sm'],
				applyClass: 'btn-danger',
				cancelClass: 'btn-inverse'
			});
			if(getCookie('token') != null){
				$("#tokendiv").prop("hidden",false);
				$('#logindiv').prop("hidden",true);
				$('#token').val(getCookie('token'));
			} else {

				$("#submit").click(function(){
					
					$('#user').prop("disabled",true);
					$('#pass').prop("disabled",true);
					$("#submit").prop("disabled",true);
					var user = $("#user").val();
						pass = $("#pass").val();
					if(validateEmail(user) || phonecheck(user)){
						$.toast({
										heading: 'Đang đăng nhập !',
										text: 'Vui lòng chờ vài giây',
										position: 'top-right',
										loaderBg: '#1e7f2d',
										icon: 'info',
										hideAfter: 4000,
										stack: 6
									});
						$.post("gettoken.php", {
							u: user,
							p: pass
						}).done(function(data){
							
							resp = "Username and Password not correct" ;
							$("#login").attr("src", data);
							$("#login").on('load',function(data){
								
							$("#loginform").prop("hidden",false);
								$.toast({
										heading: 'Thành công !',
										text: 'Coppy tất cả nội dung khung vào ô bên dưới',
										position: 'top-right',
										loaderBg: '#1e7f2d',
										icon: 'success',
										hideAfter: 4000,
										stack: 6
									});
									$('#tokenpaste').on('paste', function () {
										var element = this;
										setTimeout(function () {
											var text = $(element).val();
											$.get("checktoken.php",{
											token:$("#tokenpaste").val()
										}).done(function(data){
											if(data != "Username and Password not correct"){
												$.toast({
													heading: 'Thành công',
													text: 'Đã lấy được Token',
													position: 'top-right',
													loaderBg: '#1e7f2d',
													icon: 'success',
													hideAfter: 2000,
													stack: 6
												});
												$("#tokendiv").prop("hidden",false);
												$('#logindiv').prop("hidden",true);
												$('#token').val(data);
												setCookie('token',data,1);
											} else {
												$.toast({
													heading: 'Lỗi',
													text: data,
													position: 'top-right',
													loaderBg: '#ff6849',
													icon: 'error',
													hideAfter: 3000
												});
														
												$("#loginform").prop("hidden",true);
												$('#user').prop("disabled",false);
												$('#pass').prop("disabled",false);
												$("#tokenpaste").val("");
												$('#submit').prop("disabled",false);
											}
										})
										}, 100);
										});
									// $("#tokenpaste").on('change',function(){
										
										
									// })
								
							})
							
						})
						
					} else {
						$.toast({
									heading: 'Lỗi',
									text: 'Bạn phải nhập email hoặc số điện thoại của tài khoản',
									position: 'top-right',
									loaderBg: '#ff6849',
									icon: 'error',
									hideAfter: 3000
								});
								
								$('#user').prop("disabled",false);
								$('#pass').prop("disabled",false);
								$("#tokenpaste").val("");
								$("#submit").prop("disabled",false);
					}
					console.log("Login Facebook Request");
					
				})
			} // end else getCookie token
			// start Xoa Task
			$("#xoa").click(function(){
				new Promise(function(resolve, reject) {
					console.log("Start task Remove");
					var i = 1;
					sum = 0
					$.toast({
									heading: 'Đang tìm kiếm bài viết',
									text: 'Quá trình có thể mất đến 30 giây',
									position: 'top-right',
									loaderBg: '#3d5aa0',
									icon: 'info',
									hideAfter: 1000,
									stack: 6
						});
					list = [];
					$('#trangthai').prop("hidden",false);
					$.get('https://graph.facebook.com/me/feed', {
						limit:'1000',
						access_token: $("#token").val()
					}).done(function(data){
						list[i] = data.data;
						if(data.paging.next != undefined ) paging = data.paging.next;
						
						$.toast({
									heading: 'Thành công',
									text: i+'. Tìm thấy '+list.length+' bài',
									position: 'top-right',
									loaderBg: '#1e7f2d',
									icon: 'success',
									hideAfter: 1000,
									stack: 6
						});
						sum += list[i].length;
						$("#sum").html("Tìm thấy : "+sum+" bài viết");
						while(paging != "" & paging != null){
							i+=1;
							nextpg = getOther(paging);
							if(nextpg.paging != undefined){
								if (nextpg.paging.next != undefined){
									paging = nextpg.paging.next;
								} else {
									paging = "";
								}
							} else {
								paging = "";
							}
							list[i]= nextpg.data;
								
							sum += list[i].length;
							$("#sum").html("Tìm thấy : "+sum+" bài viết");
						} 
						n = i-1;
						console.log(list);
						range = $("#phamvi").val().split(" - ");
						start = new Date(range[0]);
						end = new Date(range[1]);
						token = $("#token").val();
						success = 0;
						fail = 0;
						for(i=1; i<=n;++i){
							son = list[i];
							son.forEach(function(post){
								date = new Date(post.created_time);
								if((date > start ) & (date < end )){
									Task = new Promise(function(resolve,reject){
										$.ajax({
											url: "https://graph.facebook.com/" + post.id,
											type: 'DELETE',
											success: function(data){
												resolve(data);
											},
											error: function(error){
												reject(error);
											},
											data: {access_token:token}
										});
									}).then(function(suc){
										if(suc){
											success += 1;
											$("#info").html("Đã xoá được : "+success+" bài viết");
											console.log("Xoa bai viet : "+ post.id);
										} 
									},function(error){
										fail += 1;
										$("#loi").html("Lỗi : "+fail+" bài viết");
									})
								}
							})
							
						}
						$("#loadbar").prop("hidden",true);
						$("#title").html("Đã hoàn thành. Xoá thành công " + success + " bài viết");
					});
					
				})
			})
				
			
		})
		</script>
    
	</body>