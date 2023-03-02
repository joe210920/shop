@extends('layouts.main') 

@section('tilte', '修改畫面')

@section('content')	
<script type="text/javascript">
	$(function() {
		
		$("#send").click(function() {
			 if(!$("#account").val()) {
				alert("請輸入帳號!");
				$("#account").focus();
				return false;
			 }

			if(!$("#password").val()) {
				alert("請輸入密碼");
				$("#password").focus();
				return false;
			}
			if(!$("#check_password").val()) {
				alert("請再次輸入密碼");
				$("#check_password").focus();
				return false;
			}
			
			if($("#password").val() != $("#check_password").val()) {
				alert("兩次密碼輸入不一致，請重新輸入");
				$("#password").val("");
				$("#check_password").val("");
				return false;
			}
			
			if(!$("#name").val()) {
				alert("請輸入名子");
				$("#name").focus();
				return false;
			}
			if(!$("#phone_number").val()) {
				alert("請輸入電話號碼");
				$("#phone_number").focus();
				return false;
			}
			
			$user_id = $("#user_id").val();

			if(check_user_id($user_id) == 0) {
			    alert("身分字號輸入錯誤");
			    $("#user_id").val("");
			    return false;
			}
		});
		
	});
</script>
		<form action="{{url('/member')}}/{{$member->id}}" method="POST" id="myform" name="myform">
		    @csrf
		    <input type="hidden" name="_method" value="PUT">
			<h2>會員資料修改</h2>	
			編號: <input type="text" name="id" id="id" id="id" value="{{$member->id}}"><br>
			帳號: <input type="text" name="account" id="account" value="{{$member->account}}"><br>
			密碼: <input type="password" name="password" id="password" value="{{$member->password}}"><br>
			再次輸入密碼: <input type="password" name="check_password" id="check_password"><br>
			名子: <input type="text" name="name" id="name" value="{{$member->name}}"><br>
			身分字號: <input type="text" name="user_id" id="user_id" value="{{$member->user_id}}"><br>
			手機號碼: <input type="text" name="phone_number" id="phone_number" value="{{$member->phone_number}}"><br>
			<input type="submit" id="send" value="修改完成">
		</form>
@endsection