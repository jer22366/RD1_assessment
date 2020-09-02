<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"> 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Document</title>
</head>
<body>
<form>
  <div class="form-group row">
    <label for="cityName" class="col-4 col-form-label">Select</label> 
    <div class="col-8">
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

      <select id="menu" name="menu" class="custom-select">
        <option value="30">當前天氣</option>
        <option value="31">一週天氣預報</option>
        <option value="32">明後兩天預報</option>
        <option value="33">雨量查詢</option>
        
      </select>
    </div>
  </div> 
</form>
        <div id='alarm'></div>
        <div id='test'></div>
        <!-- <div id='test1'></div>
        <div id='test2'></div>  -->
</body>
<script>
  $(function(){
 setInterval(getTempNow,1000);
 setInterval(getrain,10000);
//  setInterval(getoneweek,10000);
//  setInterval(gettwoday,10000);
 
})
function getTempNow (){
 let getcityId=$("#cityName option:selected").val();
 let getmenu=$("#menu option:selected").val();
 $.ajax({
   type: 'GET',                     //GET or POST
   url: `tempNow.php?id=${getcityId}&menu=${getmenu}`,  //請求的頁面
   cache: false,   //是否使用快取
   dataType : 'text',
   success: function(result){   //處理回傳成功事件，當請求成功後此事件會被呼叫
  //alert(result);
  //$('#title').text(result);
  $('#alarm').text(result);
   },
   error: function(result){   //處理回傳錯誤事件，當請求失敗後此事件會被呼叫
  //your code here
  alert("getTempNow發生錯誤");
  console.log(result);
   },
       });
}

function getrain (){
  let getcityId=$("#cityName option:selected").val();
  let getmenu=$("#menu option:selected").val();
 $.ajax({
   type: 'GET',                     //GET or POST
   url: `tempNow.php?id=${getcityId}&menu=${getmenu}`,  //請求的頁面
   cache: false,   //是否使用快取
   dataType : 'text',
   success: function(result){   //處理回傳成功事件，當請求成功後此事件會被呼叫
  //alert(result);
  //$('#title').text(result);
  $('#test').text(result);
   },
   error: function(result){   //處理回傳錯誤事件，當請求失敗後此事件會被呼叫
  //your code here
  alert("getrain發生錯誤");
  console.log(result);
   },
       });
}

function getoneweek (){
 $.ajax({
   type: 'GET',                     //GET or POST
   url: "oneweekweather.php",  //請求的頁面
   cache: false,   //是否使用快取
   dataType : 'text',
   success: function(result){   //處理回傳成功事件，當請求成功後此事件會被呼叫
  //alert(result);
  //$('#title').text(result);
  $('#test1').text(result);
   },
   error: function(result){   //處理回傳錯誤事件，當請求失敗後此事件會被呼叫
  //your code here
  alert("getoneweek發生錯誤");
  console.log(result);
   },
       });
}

function gettwoday (){
 $.ajax({
   type: 'GET',                     //GET or POST
   url: "twodayweather.php",  //請求的頁面
   cache: false,   //是否使用快取
   dataType : 'text',
   success: function(result){   //處理回傳成功事件，當請求成功後此事件會被呼叫
  //alert(result);
  //$('#title').text(result);
  $('#test2').text(result);
   },
   error: function(result){   //處理回傳錯誤事件，當請求失敗後此事件會被呼叫
  //your code here
  alert("gettwoday發生錯誤");
  console.log(result);
   },
       });
}
</script>

</html>