
<?php
    header("content-type: text/html; charset=utf-8");

    // 1. 初始設定
    $ch = curl_init();

    // 從檔案中讀取資料到PHP變數 
    // curl_setopt($ch, CURLOPT_URL, "https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-D0047-091?Authorization=CWB-1B423024-C23F-44A7-9E83-AB17227AC4A3&elementName=,MinT,MaxT,Wx");//一週天氣
    curl_setopt($ch, CURLOPT_URL, "https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-D0047-089?Authorization=CWB-1B423024-C23F-44A7-9E83-AB17227AC4A3&format=JSON&elementName=PoP12h,T,WeatherDescription");//兩天天氣
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
 
    // foreach($data["records"]["locations"][0]["location"] as $i){
    //         echo $i["locationName"]."<br>";
    //         for($k=0;$k<14;$k++){
    //                 echo $i["weatherElement"][0]["time"][$k]["elementValue"][0]["value"]."   ,";
    //                 echo $i["weatherElement"][1]["time"][$k]["elementValue"][0]["value"]."   ,";
    //                 echo $i["weatherElement"][2]["time"][$k]["elementValue"][0]["value"]."   ,".$i["weatherElement"][0]["time"][$k]["startTime"]."<br>";
    //         }
    //         echo "<br>";
    // } 
    

   
    
      
      
    
 
 
    

?>