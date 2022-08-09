<style>
    img{
        width:200px;
        height:120px;
    }
</style>

<?php
    function showdata($id,$link){
        $Img = <<<sqlcommand
                select cityImg from city where cityid=$id;
            sqlcommand;
            $showImg = mysqli_fetch_assoc(mysqli_query ( $link, $Img ));
        if($id!=15){
            $showtempNow = <<<sqlcommand
                select date_format(now(),"%m-%d %h:%i") as timeNow,round(avg(temp)) as temp,WEEKDAY(timeNow) as week from tempNow where cityid= $id and temp!=-99 group by timeNow
            sqlcommand; 
            
            $show = mysqli_fetch_assoc(mysqli_query ( $link, $showtempNow ));?>
                <div class="container"> 
                <table class="table table-hover">
                <div >
                    <img src="./image/<?php echo $showImg["cityImg"]?>"> 
                    </div>
                    <thead>
                    <tr>
                        <th>日期</th>
                        <th>星期</th>
                        <th>溫度</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo $show["timeNow"] ?></td>
                            <td><?php echo week($show["week"]) ?></td>
                            <td><?php echo $show["temp"]?></td>
                    </tr>
                    
                    </tbody>
                         
                         
                </table>
                
                </div>
    <?php }else{?>
                 <?php echo("親 這裡沒有觀測站喔");
        }
        
 }
 
    
    require_once ("config.php");
    if(isset($_GET["id"]))
        $id = $_GET["id"];
    // 1. 初始設定
    $showtempNow = <<<sqlcommand
        select timeNow from tempNow where id=1;
    sqlcommand;
    $show = mysqli_fetch_assoc(mysqli_query ( $link, $showtempNow ));
    $splitone=explode(" ",$show["timeNow"]);
    $splittwo=explode(":",$splitone[1]);
    $minute=date("i");
    $hour=date("H");
    if($hour>$splittwo[0] || $minute>$splittwo[1]+10 || $minute==0){
        $ch = curl_init();
    
        // 從檔案中讀取資料到PHP變數 
        curl_setopt($ch, CURLOPT_URL, "https://opendata.cwb.gov.tw/api/v1/rest/datastore/O-A0003-001?Authorization=CWB-1B423024-C23F-44A7-9E83-AB17227AC4A3&format=JSON&elementName=TIME,TEMP&parameterName=CITY");//當前天氣
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0); 
            
        $pageContent = curl_exec($ch);        
        // 4. 關閉與釋放資源
        curl_close($ch);   
        
        // 用引數true把JSON字串強制轉成PHP陣列  
        $data = json_decode($pageContent, true);

        $delete = <<<sqlcommand
           TRUNCATE table tempNow;   
        sqlcommand;
        $result = mysqli_query ( $link, $delete );

        foreach($data["records"]["location"] as $i){//當前天氣
            $time = $i["time"]["obsTime"];
            $city = $i["parameter"][0]["parameterValue"];
            $temp = $i["weatherElement"][0]["elementValue"];

            $tempNow = <<<sqlcommand
                INSERT INTO `tempNow`(`cityid`, `temp`, `timeNow`) VALUES ((select cityid from city where city="$city"),$temp,"$time")
            sqlcommand;
                $result = mysqli_query ( $link, $tempNow );

            }
            
            showdata($id,$link,$result);         
    }else{
           showdata($id,$link,$result);     
        }?>  

        
    
    <!-- // $count=1;
    // $DBdata = <<<sqlcommand
    //         select timeNow from tempNow where id=1;
    //     sqlcommand;
    // $dbdata = mysqli_query ( $link, $DBdata );        
    // $dbresult= mysqli_fetch_assoc($dbdata);

    // if($data["records"]["location"][0]["time"]["obsTime"]>$dbresult["timeNow"]){
    //     echo "ok";
    //     foreach ($data['records']['location']as $i) {
    //         $city = $i['parameter'][0]['parameterValue'];
    //         $cityname="select cityid from city where city='$city'";
    //         $cityresult = mysqli_fetch_assoc(mysqli_query($link,$cityname));
    //         $cityId = $cityresult['cityId'];
    //         $time = $i['time']['obsTime'];
    //             $temp = $i['weatherElement'][0]['elementValue'];
    //             $currentSql = "update tempNow set `timeNow` = '$time',temp = '$temp' where id = $count ";
    //             mysqli_query($link,$currentSql);
    //             $count++;
    //         } 
    // } -->

    
        

