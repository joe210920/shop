@extends('layouts.main')

@section('title', '登入商品修改頁面')

@section('content')
    	<script type=text/Javascript>
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
		<h1>登入商品修改頁面</h1>
		<form action="{{ url('pdt') }}/loginProduct" method="POST" id="loginProduct" name="loginProduct">
		@csrf
		帳號  <input type="text" name="account" id="account" name="account"><br><br>
		密碼  <input type="password" name="password" id="password"><br><br>
		<input type="submit" id="send" value="登入">&nbsp&nbsp&nbsp
		<input type="reset" value="清除" >
		</form>
@endsection