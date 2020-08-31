<?php
// curl -X GET "https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-D0047-005?Authorization=CWB-1B423024-C23F-44A7-9E83-AB17227AC4A3&limit=10&format=JSON&sort=time" -H "accept: application/json"

// https://json2jsonp.com/? https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-D0047-005?Authorization=CWB-1B423024-C23F-44A7-9E83-AB17227AC4A3&limit=10&format=JSON&sort=time

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form>
        <select name="YourLocation">
        　<option value="Taipei">台北</option>
        　<option value="Taoyuan">桃園</option>
        　<option value="Hsinchu">新竹</option>
        　<option value="Miaoli">苗栗</option>
        </select>
        </form>
</body>
<script>
  $(function () {
  $.ajax({
    type: "GET",
    url: "http://opendata.cwb.gov.tw/opendata/DIV2/O-A0001-001.xml",
    dataType: "xml",
    error: function (e) {
      console.log('oh no');
    },
    success: function (e) {
      var xml = e;
      console.log($(xml));
    }
  });
});      
</script>

</html>