@extends('layouts.main')

@section('title', '登入購物車')

@section('content')
		<script type="text/javascript">
			$(function(){
				$("#send").click(function(){
					if(!$("#account").val()) {
						alert("請輸入帳號");
						$("#account").focus();
						return false;
					}

					if(!$("#password").val()) {
						alert("請輸入密碼");
						$("#password").focus();
						return false;
					}
				});
			});
		</script>
	
		
		<form action="{{ url('shopCar') }}/loginShopCar" method="POST" id="loginShopCar" name="loginShopCar"> 
			@csrf
			<h1>歡迎登入購物車</h1>
			帳號:<input type="text" name="account" id="account">	<br><br>
			密碼:<input type="password" name="password" id="password"><br><br>
			<input type="submit" name="send" id="send" value="登入">&nbsp&nbsp&nbsp
			<input type="reset"  name="reset" id="reset">
		</form>
@endsection