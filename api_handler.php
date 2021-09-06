<?php
/************************/
/*API Handling functions*/
/************************/

// Return list of restaurants using cURL
function performAllRecordQuery($url){
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $resp = curl_exec($curl);
    if(curl_error($curl)){
        echo 'cURL request error:' . curl_error($curl);
    }else{
        $result = json_decode($resp, true);
    }
    curl_close($curl);
    
    // Write out all records - overview
    echo "<div id=\"main-all-records-container\">";
    echo"  <h2 class=\"main-header\">Přehled restaurací</h2>";

    // Prepare toggle for view of whole API response
    echo "<div id=\"api-rec-all-toggle\">
        <span>Zobrazit celou odpověď z API</span>
        <span id=\"visibility-on-maticon\" class=\"material-icons\">visibility</span>
        <span id=\"visibility-off-maticon\" class=\"material-icons display-none\">visibility_off</span>
    </div>";
    echo"<pre id=\"api-return-data-raw\" class=\"display-none\">";
        print_r($result);
    echo"</pre>";  
    
    // Overall data write out - restaurants
    foreach($result as $result_item){
        echo"<div class=\"restaurant-rec\">";  
            echo "<a href=\"show-detail.php?record_id="; echo $result_item["id"]."&name=".$result_item["name"]."&lat=".$result_item["gps"]["lat"]."&lng=".$result_item["gps"]["lng"]; echo "\" >"; echo $result_item["name"]; "</a>"; 
            echo "<a title=\"Odkaz na: "; echo $result_item["name"]; echo "\" target=\"_blank\" href=\""; echo $result_item["url"]; echo"\"><span class=\"material-icons restaurant-link\">link</span></a>"; 
        echo"</div>";    
    }
    echo "</div>";
}

// Return list of attributes of concrete record
function performSingleRecordQuery($url, $recid, $restaurant_name, $lng, $lat){
    $dataArray = array("restaurant_id"=>$recid);
    $ch = curl_init();
    $data = http_build_query($dataArray);
    $getUrl = $url."?".$data;
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_URL, $getUrl);
    curl_setopt($ch, CURLOPT_TIMEOUT, 80);
    $response = curl_exec($ch);
 
    if(curl_error($ch)){
        echo 'cURL request error:' . curl_error($ch);
    }else{
        
        if($response){
            $result = json_decode($response, true);
        }else{
            echo "<h5 class=\"err-mess\">Neexistující záznam</h5>";
        }
    }
    
    curl_close($ch);

    $url = "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5118.19161723395!2d".$lng."!3d".$lat."!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNTDCsDA2JzEwLjYiTiAxNMKwMjYnNTQuOSJF!5e0!3m2!1scs!2scz!4v1630958658959!5m2!1scs!2scz";

    // Write out all records - overview
    echo "<div id=\"main-detail-records-container\">";

        echo"  <h2 class=\"main-header\">Přehled meny pro restauraci "; echo $restaurant_name; echo"</h2>";  

        echo "<iframe src=".$url." width=\"100%\" height=\"500\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\"></iframe>";

        echo "<div id=\"api-rec-all-toggle\">
        <span>Zobrazit celou odpověď z API</span>
        <span id=\"visibility-on-maticon\" class=\"material-icons\">visibility</span>
        <span id=\"visibility-off-maticon\" class=\"material-icons display-none\">visibility_off</span>
        </div>";
        echo"<pre id=\"api-return-data-raw\" class=\"display-none\">";
            print_r($response);
        echo"</pre>";  

        // Overall data write out - menu of restaurant     
        foreach($result as $result_item){

            echo"<div class=\"restaurant-detail-rec\">";  

                echo "<div class=\"food-detail-elem food-date\">
                <span class=\"material-icons\">event</span>"
                .$result_item['date'].
                "</div>\r\n";
                echo "<div class=\"food-detail-elem food-note\">
                <span class=\"material-icons\">info</span>"
                .$result_item['note'].
                "</div>\r\n";
                echo "<div class=\"food-detail-elem food-courses\">";
                foreach($result_item['courses'] as $courses){
                echo "<div class=\"food-detail-elem food-course\">".$courses["course"]."</div>\r\n";
                    foreach($courses as $courses_elms){
                        if(gettype($courses_elms) == "array"){
                            foreach($courses_elms as $courses_elms_elm){
                                // Write out name of food and price
                                echo "<div class=\"food-detail-elem food-row\">".$courses_elms_elm["name"]." ".$courses_elms_elm["price"]."<p class=\"price-type\"> Kč</p>"."</div>\r\n";
                            }
                        }
                    }
                }

                echo "</div>\r\n";

            echo"</div>";   

        }

    echo "</div>";
}



?>