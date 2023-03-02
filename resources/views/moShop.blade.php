@extends('layouts.main')

@section('title', '歡迎來到mo購物平台')

@section('content')
<div style="font-size=5; display:inline; background:#dcdcdc;">
<a href="login" target="_self"><font size="5">登入</font></a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
<a href="register" target="_blank"><font size="5">註冊</font></a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
<a href="editMember"><font size="5">個人資料管理</font></a>
</div>

<h1>顯示商場商品</h1>
<table border="1">
	<tr>
		<td>商品編號</td>
		<td>商品名稱</td>
		<td>商品庫存</td>
		<td>商品單價</td>
		<td>商品照片</td>				
	</tr>	
@foreach ($products as $product)
		<tr>
			<td>{{ $product->id }}</td>
			<td>{{ $product->name }}</td>
			<td>{{ $product->stock }}</td>
			<td>{{ $product->price }}</td>
			<td><img src="{{ env('ASSET_IMG_URL') . $product->img_path }}" alt="無照片" width="100"></td>
		</tr>
@endforeach	
</table>	

@endsection