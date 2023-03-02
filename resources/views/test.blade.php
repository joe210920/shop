@extends('layouts.main')

@section('title', '這是測試頁面 | TEST')




@section('content')
	<form action="{{ url('member') }}/test" method="get" id="testFrom" name="testFrom">
		@csrf
		
		測試<input type="text" name="tesf" id="test">
		<input type="submit" value="送出">
	
	
	</form> 
@endsection