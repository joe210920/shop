@extends('layouts.main')

@section('title', '選購商品頁面')

@section('content')
		<script type="text/javascript">
			function cancel(id) {
				$("#cancel").attr("action", "{{ url('shopCar') }}/cancel/"+id);
				$("#cancel").submit();		
			}

			function back() {
				window.location.href="{{url('shopCar')}}/showShop";
			}

			function checkout() {
				
				window.location.href="{{url('shopCar') }}/checkout";

			}
		</script>	

		<h1>選購商品頁面</h1>
		<input type="button" id="back" name="back" onclick="back()" value="回上一頁">&nbsp&nbsp&nbsp
		<input type="button" id="checkout" name="checkout" onclick="checkout()" value="結帳"><br><br>
		<table border="1">
			<tr>
				<td>商品編號</td>
				<td>商品名稱</td>
				<td>商品單價</td>
				<td>商品照片</td>
				<td>購買數量</td>
				<td>功能</td>
			</tr>
			@foreach (session()->get("shopCarProducts") as $key=>$scpdt)
				<tr>
					<td>{{$scpdt->id}}</td>
					<td>{{$scpdt->name}}</td>
					<td>{{$scpdt->price}}</td>
					<td><img src="{{ env('ASSET_URL') . '/uploads/' . $scpdt->img_path }}" alt="無圖片" width="100"></td>
					<td>{{$scpdt->qty}}</td>
				    <td>
				    	<input type="button" value="取消訂購" onclick="cancel({{ $scpdt->id }})">
				    </td>
				</tr>
			@endforeach
		</table>
		<form action="" method="Post" id="cancel">
			@csrf
		</form>
@endsection
