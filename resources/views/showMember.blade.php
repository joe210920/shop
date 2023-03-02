@extends('layouts.main')

@section('title', '修改會員資料')

@section('content')
    
    <script type="text/javascript">
		function toEdit(id) {
			
			window.location.href = "{{url('member')}}/" + id + "/edit";			
		}
		function del(id) {
			 $("#form").attr("action","{{url('member')}}/"+id);
			 $("#form").submit();
		}
    </script>
  
    	<h1>歡迎光臨 {{ session('member')->name }}進入會員編輯畫面</h1>
    	<table border="1">
    		<tr>
    			<td>會員編號</td>
    			<td>姓名</td>
    			<td>帳號</td>
    			<td>密碼</td>
    			<td>身分字號</td>
    			<td>手機號碼</td>
    			<td>建立時間</td>
    			<td>修改時間</td>
    			<td align="center">功能</td>
    		</tr>
    		 
    	@foreach ($members as $member)
    		<tr>
    			<td>{{$member->id}}</td>
    			<td>{{$member->name}}</td>
    			<td>{{$member->account}}</td>
    			<td>{{$member->password}}</td>
    			<td>{{$member->user_id}}</td>
    			<td>{{$member->phone_number}}</td>
    			<td>{{$member->created_at}}</td>
    			<td>{{$member->updated_at}}</td>
    			<td>
    				<input type="button" value="編輯" onclick="toEdit({{$member->id}})"/>
    				<input type="button" value="刪除" onclick="del({{$member->id}})"/>
    			</td>
    		</tr>
		@endforeach	
		</table>
     <form action="" method="POST" id="form">
          @csrf
 		 {{ method_field('DELETE') }}
	 </form>

@endsection