@extends('layouts.main')

@section('title', '訂單明細')

@section('content')
		<h1>訂單明細</h1>
		<table border="1">
		<thead>
			<tr>
				<th>訂單編號</th>
				<th>購買數量</th>
				<th>價錢</th>
				<th>訂購時間</th>
				<th colspan="5">商品詳細資料</th>
			</tr>
			
		</thead>
		@foreach($details as $detail) 
		<tr>
			<td>{{ $detail->order_product_id }}</td>
			<td>{{ $detail->qty }}</td>
			<td>{{ $detail->total }}</td>
			<td>{{ $detail->created_at }}</td>
			<td>1.商品編號: {{ $detail->product->id }}</td>
			<td>2.商品名稱: {{ $detail->product->name }}</td>
			<td>3.庫存: {{ $detail->product->stock }}</td>
			<td>4.單價: {{ $detail->product->price }}</td>
			<td>5.照片:<img src="{{ env('ASSET_PUBLIC_URL') . $detail->product->img_path }}" alt="無圖片" width="100"></td>
			
		</tr>
		@endforeach
	
		
		</table>
		<br>
		
		<input type="button" id="off" name="off" value="關閉視窗" onClick="window.close()">
		
@endsection