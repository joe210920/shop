@extends('layouts.main')

@section('title', '會員管理系統')

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

		$("#search").click(function(){
			window.location.href = "{{url('member')}}/showMember";
		});	
	});
	
	function check_user_id(user_id) {
		
		user_id = user_id.toUpperCase();
		
		var tab = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		var num = new Array(10, 11, 12, 13, 14, 15, 16, 17, 34, 18, 19, 20, 21, 22, 35, 23, 24, 25, 26, 27, 28, 29, 32, 30, 31, 33);
		if(user_id.length == 0) {
			alert("請填寫身份字號");
			return 0;
		}
		if(user_id.length > 10 && user_id.length <10) {
			alert("身份字號只有10碼");
			return 0;
		}
		var firstWordIndex = tab.indexOf(user_id.charAt(0));
		if(firstWordIndex == -1) {
			alert("身份字號第一碼為大寫英文字母");
			return 0;
		}
		var strWord = "" + num[firstWordIndex];
		
		for(var i = 1; i < user_id.length; i++) {
			strWord += user_id.charAt(i);
		}
		var sum = 0;
		for(var i = 0; i < strWord.length - 1; i++) {
			if(i == 0) {
				sum += parseInt(strWord.charAt(i)) * 1;
				continue;
			}
			sum += parseInt(strWord.charAt(i)) * (10 - i);
		}
		var checkNum = 10 - (sum % 10);
		
		if(checkNum == parseInt(strWord.charAt(10))) {
			alert("身份字號驗證正確");
			return 1;
		} else if(checkNum == 10) { 
			alert("身分字號驗證正確");
			return 1;
		} else {
			alert("身份字號驗證錯誤");
			return 0;
		}

	} 
</script>		
		<form action="{{url('member')}}" method="post" id="form" name="myform">
		    @csrf	    
			<h3>歡迎{{ session("member")->name }}登入使用者管理系統 </h3>
			帳號: <input type="text" name="account" id="account"><br>
			密碼: <input type="password" name="password" id="password"><br>
			再次輸入密碼: <input type="password" name="check_password" id="check_password"><br>
			名子: <input type="text" name="name" id="name"><br>
			身分字號: <input type="text" name="user_id" id="user_id"><br>
			手機號碼: <input type="text" name="phone_number" id="phone_number"><br>
			<input type=submit id="send" value="新增">
			<input type="button" name="search" id="search" value="顯示所有會員資料">
			<input type="reset" value="清除資料"/>	
		</form>
			
@endsection