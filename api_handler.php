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
    if(curl_error($ch)){
        echo 'cURL request error:' . curl_error($ch);
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
            echo "<a href=\"show-detail.php?record_id="; echo $result_item["id"]."&name=".$result_item["name"]; echo "\" >"; echo $result_item["name"]; "</a>"; 
            echo "<a title=\"Odkaz na: "; echo $result_item["name"]; echo "\" target=\"_blank\" href=\""; echo $result_item["url"]; echo"\"><span class=\"material-icons restaurant-link\">link</span></a>"; 
        echo"</div>";    
    }
    echo "</div>";
}

// Return list of attributes of concrete record
function performSingleRecordQuery($url, $recid, $restaurant_name){
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
    }
    else{
        
        if($response){
            $result = json_decode($response, true);
        }else{
            echo "Neexistující záznam";
        }
    }
    curl_close($ch);

    

    // Write out all records - overview
    echo "<div id=\"main-detail-records-container\">";

        echo"  <h2 class=\"main-header\">Přehled meny pro restauraci "; echo $restaurant_name; echo"</h2>";  

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

                echo "<div class=\"food-detail-elem food-date\">".$result_item['date']."</div>\r\n";
                echo "<div class=\"food-detail-elem food-note\">".$result_item['note']."</div>\r\n";
                echo "<div class=\"food-detail-elem food-courses\">";
                foreach($result_item['courses'] as $courses){
                echo "<div class=\"food-detail-elem food-course\">".$courses["course"]."</div>\r\n";
                    foreach($courses as $courses_elms){
                        if(gettype($courses_elms) == "array"){
                            foreach($courses_elms as $courses_elms_elm){
                                // Write out name of food and price
                                echo "<div class=\"food-detail-elem food-row\">".$courses_elms_elm["name"]." ".$courses_elms_elm["price"]."</div>\r\n";
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