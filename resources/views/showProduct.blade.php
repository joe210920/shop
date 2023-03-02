@extends('layouts.main')

@section('tilte', '顯示所有商品')
@section('content')	
		<script type="text/javascript">
			function toEdit(id) {
				window.location.href = "{{url('pdt')}}/"+id+"/edit";
			}
			function del(id) {
				$("#del").attr("action", "{{url('pdt')}}/"+id);
				$("#del").submit();
			}

			function up() {
				window.location.href = "{{url('pdt')}}/manageProduct";
			}
		</script>
	

		<h1>歡迎光臨 {{ session("member")->name }} 修改商品</h1>
		<table border="1">
			<tr>
				<td>商品編號</td>
				<td>商品名稱</td>
				<td>商品庫存</td>
				<td>商品單價</td>
				<td>商品照片</td>
				<td>建立時間</td>
				<td>修改時間</td>
				<td align="center">功能</td>
			</tr>
			
		@foreach ($products as $product)
			<tr>
				<td>{{$product->id}}</td>
				<td>{{$product->name}}</td>
				<td>{{$product->stock}}</td>
				<td>{{$product->price}}</td>
				<td><img src="{{env('ASSET_PUBLIC_URL') . $product->img_path}}" alt="無圖片" width="100" heigh="100"></td>
				<td>{{$product->created_at}}</td>
				<td>{{$product->updated_at}}</td>
				<td>
					<input type="button" value="編輯" onclick="toEdit({{$product->id}})">
					<input type="button" value="刪除" onclick="del({{$product->id}})">
					
				</td>
			</tr>
		@endforeach	
		
		</table>
		<br>
		<input type="button" value="回上一頁" onclick="up()">
		
	<form action="" method="POST" id="del">
		@csrf
		{{ method_field('DELETE') }}
	</form>
@endsection	

