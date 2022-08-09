<style>
    img{
        width:200px;
        height:120px;
    }
</style>
<?php
    function showdata($id,$link,$result){
        $Img = <<<sqlcommand
                select cityImg from city where cityid=$id;
        sqlcommand;
        $showImg = mysqli_fetch_assoc(mysqli_query ( $link, $Img ));

        $showtempNow = <<<sqlcommand
            select descriptionT,Description,startTime,endTime,WEEKDAY(startTime) as week from twodayweather where cityid= $id
        sqlcommand;
        $result = mysqli_query ( $link, $showtempNow );?>
        <div class="container"> 
            <table class="table table-hover">
                <thead>
                <tr>
                <img src="./image/<?php echo $showImg["cityImg"]?>"> 
                    <th>溫度</th>
                    <th>預測</th>
                    <th>日期(每三小時)</th>
                    <th>星期</th>
                </tr>
                </thead>
                <tbody>
                <?php while($show=mysqli_fetch_assoc($result)){
                    $des=explode("。",$show["Description"]);
                        
                ?>
                <tr>
                    <td><?php echo $show["descriptionT"]."  度" ?></td>
                    <td><?php  for($i=0;$i<3;$i++) 
                            echo $des[$i]."  ";
                            echo $des[3];
                    ?></td>
                    <td><?php echo $show["startTime"] ?></td>
                    <td><?php echo week($show["week"]) ?></td>
                </tr>
            <?php }?>   
            </tbody>
            </table>
        </div>
<?php }




    
    require_once ("config.php");
    $showtempNow = <<<sqlcommand
        select startTime from oneweekweather where id=1;
    sqlcommand;
    $show = mysqli_fetch_assoc(mysqli_query ( $link, $showtempNow ));
    $splitone=explode(" ",$show["startTime"]);
    $splittwo=explode(":",$splitone[1]);
    $splitthree=explode("-",$splitone[0]);
    $sum=date("Ｈ");
    $day=date("d");
    if(isset($_GET["id"]))
        $id = $_GET["id"];

    if($sum>$splittwo[0]+3  || $day>$splitthree[2]){
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
        showdata($id,$link,$result);
    }else{
        showdata($id,$link,$result);
}?>