@extends('layouts.main')

@section('title', '顯示訂單')

@section('content')
		
		<script type="text/javaScript">
			function del(id) {
				$("#del").attr("action", "{{ url('order') }}/" + id);
				$("#del").submit();
			}

		</script>
		
		<h1>{{ session("member")->name }}的所有訂單</h1>
		<table border="1">
			<tr> 
			<td>訂單編號</td>
			<td>總金額</td>
			<td>訂單明細</td>
			<td>訂購時間</td>
			<td align="center">功能</td>
			</tr>
			@foreach($orders as $key=>$order)
			<tr>
			
				<td>{{ $order->id }}</td>
				<td>{{ $order->total }}</td>
				<td><a href="{{ url('order') }}/showDetails/{{$order->id}}" target="_blank">明細</a></td>
				<td>{{ $order->created_at }}</td>
				<td>
					<input type="button" value="刪除訂單" onclick="del( {{ $order->id }} )">				
				</td>
			</tr>
		
			@endforeach
		</table>
		<form action="" method="post" id="del">
			@csrf
			{{ method_field('DELETE') }}
		</form>

@endsection