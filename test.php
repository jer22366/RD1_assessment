
<?php
    header("content-type: text/html; charset=utf-8");

    // 1. 初始設定
    $ch = curl_init();

    // 從檔案中讀取資料到PHP變數 
    curl_setopt($ch, CURLOPT_URL, "https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-C0032-001?Authorization=CWB-1B423024-C23F-44A7-9E83-AB17227AC4A3&limit=3&format=JSON&locationName=%E6%96%B0%E7%AB%B9%E7%B8%A3,%E6%96%B0%E7%AB%B9%E5%B8%82,%E8%8B%97%E6%A0%97%E7%B8%A3");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0); 
    
    $pageContent = curl_exec($ch);

    // 4. 關閉與釋放資源
    curl_close($ch);
    

    // 用引數true把JSON字串強制轉成PHP陣列  
    $data = json_decode($pageContent, true);  
     
    // 顯示出來看看  
    // var_dump($json_string); 
    // var_dump ($data); 
    //  print_r($data);
    $num=0;
    foreach($data["records"]["location"] as $i){
        echo $i["locationName"]."<br>";
        echo $i["weatherElement"][0]["time"][0]["startTime"]."<br>";
        echo $i["weatherElement"][0]["time"][0]["endTime"]."<br>";
        echo $i["weatherElement"][0]["time"][0]["parameter"]["parameterName"]."<br>";
        for($cnt=0;$cnt<3;$cnt++){
            echo $i["weatherElement"][0]["time"][$cnt]["parameter"]["parameterName"]."<br>";
        }
    } 
    

   
    
      
      
    
 
 
    

?>