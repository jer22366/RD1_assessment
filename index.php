
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"> 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>氣象資訊</title>

 
</head>
<body>
<form>
  <div class="form-group row">
    <div class="col-6">
      <select id="cityName" name="cityName" class="custom-select">
        <option value="1">雲林縣</option>
        <option value="2">南投縣</option>
        <option value="3">連江縣</option>
        <option value="4">臺東縣</option>
        <option value="5">金門縣</option>
        <option value="6">宜蘭縣</option>
        <option value="7">屏東縣</option>
        <option value="8">苗栗縣</option>
        <option value="9">澎湖縣</option>
        <option value="10">台北市</option>
        <option value="11">新竹縣</option>
        <option value="12">花蓮縣</option>
        <option value="13">高雄市</option>
        <option value="14">彰化縣</option>
        <option value="15">新竹市</option>
        <option value="16">新北市</option>
        <option value="17">基隆市</option>
        <option value="18">台中市</option>
        <option value="19">台南市</option>
        <option value="20">桃園市</option>
        <option value="21">嘉義縣</option>
        <option value="22">嘉義市</option>
      </select>
    </div>
    <div class="col-6">
      <select id="menu" name="menu" class="custom-select">
        <option value="tempNow">當前天氣</option>
        <option value="oneweekweather">一週天氣預報</option>
        <option value="twodayweather">明後兩天預報</option>
        <option value="rain">雨量查詢</option>
      </select>
  </div>
</div> 
</form>
        <div id='debug'></div>
</body>
<script>
    $(document).ready(function(){
		function setting(){	
      let selecterletter = $("#cityName option:selected").val();
      let filename = $("#menu option:selected").val();
			let serverurl = `${filename}.php?id=${selecterletter}`;
			$.ajax({
				type: "get",
                url: serverurl
                
			}).then(function(e){
            $("#debug").html(e);
                
			})
		}
        $("#cityName").change(setting); //觸發時重複呼叫
        $("#menu").change(setting); 
        setting();
	})
</script>

</html>