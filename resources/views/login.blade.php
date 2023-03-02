
@extends('layouts.main')

@section('title', '管理會員登入頁面') 

@section('content')
	<script type="text/javascript">
		$(function() {
			$("#send").click(function() {
				
				if(!$("#account").val()) {
					alert("請輸入帳號!");
					$("#account").focus();
					return;
				}

				if(!$("#password").val()) {
					alert("請輸入密碼");
					$("#password").focus(); 					
					return;
				}

				$.post("checkAndLogin", {
					"_token" : "{{ csrf_token() }}",
					account : $("#account").val(), 
					password : $("#password").val()	
				}, function(result){	
					//console.log(result);
					
					if(result['status'] == 'fail') {
						alert(result['msg']);
						return;
					}

					alert(result['msg']);
					
					var origin = $(location).attr('origin');
					window.location.href = origin + 'shop/shopCar/showShop';
					
				}, "json");
				
			});
		});
	
	</script>
		<h1>會員登入</h1>
		<form action="{{ url('member') }}/login" method="post" id=loginform name="loginform">
			@csrf
			帳號: <input type="text" name="account" id="account"><br><br>
			密碼: <input type="text" name="password" id="password"><br><br>
			<input type="button" id="send" value="登入"><br><br>
		</form>
		<input type="button" id="off" name="off" value="關閉視窗" onClick="window.close()">
@endsection







