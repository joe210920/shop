<!DOCTYPE html>
<html lang='zh-tw'>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
 	<title>@yield('title')</title>

	<!-- jquery網路載入 -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->
    <!-- 本機載入 -->
	<script src="{{env('APP_URL').'/js/jquery-3.6.2.js'}}"></script>
	<!-- 載入身分字號驗證checkId -->
	<script src="{{env('APP_URL').'/js/checkId.js'}}"></script>
	
</head>
<body>
	@yield('content')

	<script type="text/javascript">
	<!-- 將session的值秀出來後，消除key為msg的值，使之為空 -->
	@if(session('msg'))
		$(function() {
			alert("{{ session('msg') }}");
			{{session() -> forget('msg')}}
		});
	@endif
	</script>
</body>
</html>
