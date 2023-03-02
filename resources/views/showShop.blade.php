@extends('layouts.main')

@section('title', '購物畫面')
@section('content')
		<script type=text/Javascript>
			function addShopCar(id, stock, $key) {
				var str = "#qty" + $key;
				var qty = $(str).val();	
				if(qty != 0 && qty <= stock) {
					window.location.href="{{ url('shopCar') }}/addShopCar/" + id + "/" + qty ;
				}
				else {
					alert("訂購數量為0或是超過庫存數量,請重新輸入");
				}	 
			}
			function showShopCar() {
				window.location.href="{{url('shopCar')}}/shopCarList";
			}
			function showOrder() {
				window.location.href="{{url('order')}}/showOrder";
			}
		</script>

		
			<h1>歡迎{{ session("member")->name}}進入選購</h1>
			<h1>商品列表</h1>
			<input type="button" id="showOrder" name="showOrder" value="查看訂單" onclick="showOrder()">&nbsp&nbsp&nbsp
			<input type="button" value="查看購物車" onclick="showShopCar()"><br><br>	
			<table border="1">
				<tr>
					<td>商品編號</td>
					<td>商品名稱</td>
					<td>商品庫存</td>
					<td>商品單價</td>
					<td>商品照片</td>
					<td>購買數量</td>
					<td align="center">功能</td>
				</tr>
				@foreach($products as $key => $product)			
				<tr>
					<td>{{ $product->id }}</td>
					<td>{{ $product->name }}</td>
					<td>{{ $product->stock}}</td>
					<td>{{ $product->price}}</td>
					<td><img src="{{ env('ASSET_URL') . '/uploads/' . $product->img_path }}" alt="無照片" width="100"></td>
					<td>
					<input type="number" id="qty{{$key}}" name=qty{{$key}} value="0" max="{{ $product->stock }}" min="0" size="2">
					<td>	
						<input type="button" value="加入購物車" onclick="addShopCar({{ $product->id }}, {{ $product->stock }}, {{ $key }})">
					</td>
				</tr>			
				@endforeach
			</table>
			<script type="text/javascript">
				@if(session('shopMsg'))
				$(function(){
					alert("{{session('shopMsg')}}");
					{{ session()->forget('shopMsg') }}
				});
				@endif
			</script>
		
@endsection



