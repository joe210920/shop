@extends('layouts.main')

@section('title', '管理商品頁面')
@section('content')
		<script type="text/javascript">
		$(function() {
			 
			 $("#send").click(function() {
				 if(!$("#name").val()) {
						alert("請輸入商品名稱");
						$("#name").focus();
						return false;		
				}

				 if(!$("#stock").val()) {
						alert("請輸入商品庫存");
						$("#ptock").focus();
						return false;
				 }

				 if(!$("#price").val()) {
						alert("請輸入商品單價");
						$("#price").focus();
						return false;
				 }
			});
			 $("#searchPdt").click(function() {
				window.location.href = "{{url('pdt')}}/showProduct";
			});
		});
		</script>


		<script type="text/javascript">
			$(function () {
				$('#img').change(function() {
			    	var file = $('#img')[0].files[0];
			    	var reader = new FileReader;
			    	reader.onload = function(e) {
			    		$('#previewImg').attr('src', e.target.result);
					};
			  		reader.readAsDataURL(file);
				});
			});
		</script>
		<form action="{{ url('pdt') }}" method="post" id="newProductForm" name="newProductFrom" enctype="multipart/form-data">
			@csrf
			<h1>歡迎{{session("member")->name}}商品管理頁面</h1>
			商品名稱: <input type="text" name="name" id="name"><br><br> 
			商品庫存: <input type="text" name="stock" id="stock"><br><br> 
			商品單價: <input type="text" name="price" id="price"><br><br>
			上傳商品照片 <input type="file" name="img" size="50" id="img"><br><br>
			上傳照片預覽<br><img id="previewImg" width="100" alt="無照片"><br><br>
			<input type="submit" name="send" id="send" value="新增增商品">&nbsp&nbsp&nbsp
			<input type="reset" value="清除資料">&nbsp&nbsp&nbsp
			<input type="button" id="searchPdt" name="searchPtd" value="顯示所有商品">			
		</form>  
@endsection