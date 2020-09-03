<?php
    header("content-type: text/html; charset=utf-8");
    require_once ("config.php");
    // 1. 初始設定
    $ch = curl_init();

    // 從檔案中讀取資料到PHP變數 
    curl_setopt($ch, CURLOPT_URL, "https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-D0047-089?Authorization=CWB-1B423024-C23F-44A7-9E83-AB17227AC4A3&elementName=PoP12h,T,WeatherDescription");
    
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0); 
    
    $pageContent = curl_exec($ch);

    // 4. 關閉與釋放資源
    curl_close($ch);
    $delete = <<<sqlcommand
        TRUNCATE table twodayweather;   
    sqlcommand;
    $result = mysqli_query ( $link, $delete );

    // 用引數true把JSON字串強制轉成PHP陣列  
    $data = json_decode($pageContent, true); 
    foreach($data["records"]["locations"][0]["location"] as $i){//兩天天氣
        $city = $i["locationName"];
        $cityname = <<<sqlcommand
            select cityid from city where city="$city"
        sqlcommand;
        $cityresult = mysqli_fetch_assoc(mysqli_query($link,$cityname));
        $cityid=$cityresult["cityid"];
        for($k=0;$k<24;$k++){
            $descriptionT = $i["weatherElement"][1]["time"][$k]["elementValue"][0]["value"];
            $Description = $i["weatherElement"][2]["time"][$k]["elementValue"][0]["value"];
            $startTime = $i["weatherElement"][2]["time"][$k]["startTime"];
            $endTime = $i["weatherElement"][2]["time"][$k]["endTime"];


            $twodayweather = <<<sqlcommand
                INSERT INTO `twodayweather`(`cityid`, `descriptionT`, `Description`, `startTime`, `endTime`) 
                VALUE ($cityid,$descriptionT,"$Description","$startTime","$endTime") ;
            sqlcommand;
            $result = mysqli_query($link, $twodayweather );
        } 
    }
    
    if(isset($_GET["id"])){
        $id = $_GET["id"];
        $showtempNow = <<<sqlcommand
            select descriptionT,Description,startTime,endTime from twodayweather where cityid= $id
        sqlcommand;
        $result = mysqli_query ( $link, $showtempNow );
        while($show=mysqli_fetch_assoc($result)){
            echo "溫度：".$show["descriptionT"]." 預測：".$show["Description"]."日期:".$show["startTime"]."<br>";
        }
    }
?>