<?php
    header("content-type: text/html; charset=utf-8");
    require_once ("config.php");
    // 1. 初始設定
    $ch = curl_init();

    // 從檔案中讀取資料到PHP變數 
    curl_setopt($ch, CURLOPT_URL, "https://opendata.cwb.gov.tw/api/v1/rest/datastore/F-D0047-091?Authorization=CWB-1B423024-C23F-44A7-9E83-AB17227AC4A3&elementName=,MinT,MaxT,Wx");//一週天氣


    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0); 
    
    $pageContent = curl_exec($ch);

    // 4. 關閉與釋放資源
    curl_close($ch);
    

    // 用引數true把JSON字串強制轉成PHP陣列  
    $data = json_decode($pageContent, true);  
    $delete = <<<sqlcommand
        TRUNCATE table oneweekweather;   
    sqlcommand;
    $resultweek = mysqli_query ( $link, $delete );
    $deletecity = <<<sqlcommand
        TRUNCATE table city;   
    sqlcommand;
    $resultcity = mysqli_query ( $link, $deletecity );
    foreach($data["records"]["locations"][0]["location"] as $i){//一週天氣
        $city=$i["locationName"];
        
        $getdate = <<<sqlcommand
            INSERT INTO `city`(`city`, `cityImg`) VALUES ("$city","1");
            
        sqlcommand;
        $result = mysqli_query ( $link, $getdate );
    
    for($k=0;$k<14;$k++){
        $description = $i["weatherElement"][0]["time"][$k]["elementValue"][0]["value"];
        $minT = $i["weatherElement"][1]["time"][$k]["elementValue"][0]["value"];
        $maxT = $i["weatherElement"][2]["time"][$k]["elementValue"][0]["value"];
        $starttime = $i["weatherElement"][0]["time"][$k]["startTime"];
        $endtime = $i["weatherElement"][0]["time"][$k]["endTime"];
   
        $getweather = <<<sqlcommand
            INSERT INTO `oneweekweather`(`cityid`, `description`, `MinT`, `MaxT`, `startTime`, `endTime`) 
            VALUES ((select cityid from city where city="$city"),"$description",$minT,$maxT,"$starttime","$endtime")
        sqlcommand;
        $result = mysqli_query ( $link, $getweather );
    }
}
    if(isset($_GET["id"])){
        $id = $_GET["id"];
        $showtempNow = <<<sqlcommand
            select Description,MinT,MaxT,startTime,WEEKDAY(startTime) as week from oneweekweather where cityid= $id
        sqlcommand;
        $result = mysqli_query ( $link, $showtempNow );
            // echo "預測：".$show["Description"]." 最高溫：".$show["MaxT"]."最低溫:".$show["MinT"]."日期:".$show["startTime"];
            // echo "  星期";
            // echo week($show["week"])."<br>";
?>
            <div class="container"> 
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>預測：</th>
                    <th>最低溫：</th>
                    <th>最高溫：</th>
                    <th>日期</th>
                    <th>星期</th>
                </tr>
                </thead>
                <tbody>
                <?php while($show=mysqli_fetch_assoc($result)){?>
                    <tr>
                        <td><?php echo $show["Description"]?></td>
                        <td><?php echo $show["MinT"] ?></td>
                        <td><?php echo $show["MaxT"] ?></td>
                        <td><?php echo $show["startTime"] ?></td>
                        <td><?php echo week($show["week"]) ?></td>
                </tr>
            <?php }?>   
                </tbody>
            </table>
            </div>
    <?php }
?> 