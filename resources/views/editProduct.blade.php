@extends('layouts.main')

@section('title', '商品修改頁面')
	

@section('content')
<script type="text/javascript">
		$(function() {
			$("#editPdt").click(function(){
				if(!$("#name").val() {
					alert("請輸入商品名稱");
					$("#productName").focus();
					return false;
				}
				if(!$("#stock").val() {
					alert("請輸入商品庫存");
					$("#stock").focus();
					return false;
				}
				if(!$("price").val() {
					alert("請輸入商品單價");
					$("price").focus();
					return false;

				}
	
			});
		});

	</script>

		<script type="text/javascript">
			$(function () {
				$('#img').change(function() {
			    	var file = $('#img')[0].files[0];
			    	var reader = new FileReader;
			    	reader.onload = function(e) {
			    		$('#newImg').attr('src', e.target.result);
					};
			  		reader.readAsDataURL(file);
				});

				$("#reset").click(function() {
					$('#newImg').attr('src', "");
				});
			});
		</script>

		<form action="{{url('/pdt')}}/{{$product->id}} " method="POST" name="editPdtForm" id="editPdtForm" enctype="multipart/form-data">
		@csrf
		<input type="hidden" name = "_method" value="PUT">
		<h1>歡迎光臨進入修改商品畫面</h1>
		商品編號<input type="text" name="id" id="id" disabled="true" value="{{ $product->id}}"><br><br>
		商品名稱<input type="text" name="name" id="name" value="{{ $product->name }}"><br><br>
		商品庫存<input type="text" name="stock" id="stock" value="{{ $product->stock }}"><br><br>
		商品單價<input type="text" name="price" id="price" value="{{ $product->price }}"><br><br>
		更換商品照片<input type="file" name="img" id="img"><br><br>
		目前照片<br><br><img src="{{ env('ASSET_PUBLIC_URL') . $product->img_path}}" alt="無照片"  width="100" id="img" name="img"><br><br>
		要更換照片<br><img id="newImg" name="newImg" width="100" alt="無照片"><br><br>
		<input type="submit" name="editPdt" id="editPdt" value="修改完成">&nbsp&nbsp
		<input type="reset" id="reset" name="reset" value="還原"> 			
		</form>
@endsection



