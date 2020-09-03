<?php
    header("content-type: text/html; charset=utf-8");
    require_once ("config.php");
    // 1. 初始設定
    $ch = curl_init();

    // 從檔案中讀取資料到PHP變數 
    
    curl_setopt($ch, CURLOPT_URL, "https://opendata.cwb.gov.tw/api/v1/rest/datastore/O-A0002-001?Authorization=CWB-1B423024-C23F-44A7-9E83-AB17227AC4A3&elementName=RAIN,HOUR_24&parameterName=CITY");//雨量
    

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0); 
    
    $pageContent = curl_exec($ch);
    
    // 4. 關閉與釋放資源
    curl_close($ch);
    

    // 用引數true把JSON字串強制轉成PHP陣列  
    $data = json_decode($pageContent, true); 
    $delete = <<<sqlcommand
        TRUNCATE table rain;   
    sqlcommand;
    $result = mysqli_query ( $link, $delete );
    
    foreach($data["records"]["location"] as $i){//雨量
            $time = $i["time"]["obsTime"];
            $city = $i["parameter"][0]["parameterValue"];
            $onehourrain = $i["weatherElement"][0]["elementValue"];
            $onedayrain = $i["weatherElement"][1]["elementValue"];
            
            $getrain = <<<sqlcommand
                INSERT INTO `rain`(`cityId`, `onehourRain`,`onedayRain`, `rainDate`) VALUES ((select cityid from city where city="$city"),$onehourrain,$onedayrain,"$time")
            sqlcommand;
            $result = mysqli_query ( $link, $getrain );
            
        } 
        
        if(isset($_GET["id"])){
            $id = $_GET["id"];
                    $showOneDay = <<<sqlcommand
                        SELECT avg(onedayRain) as DayRain FROM `rain` where cityId=$id and onedayRain>=0
                    sqlcommand;
                    $showD = mysqli_fetch_assoc(mysqli_query ( $link, $showOneDay ));
                    $showOneHour = <<<sqlcommand
                        SELECT avg(onehourRain) as HourRain FROM `rain` where cityId=$id and onehourRain>=0
                    sqlcommand;
                    $showH = mysqli_fetch_assoc(mysqli_query ( $link, $showOneHour ));
                    if($showH["HourRain"]=="")
                        $showH["HourRain"]=0;
                    echo "一天雨量：".$showD["DayRain"]." ,每小時雨量：".$showH["HourRain"];
                }
            
            
 ?>