<!DOCTYPE html>
<html>
<head>
<title>Menu vybraných restaurací</title>
</head>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="styles/styles.css">
<link rel="stylesheet" type="text/css" href="styles/mq-main.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<body>

<div id="header">
  <h2 class="main-header"><a href="index.php"><span class="material-icons">arrow_back</span>Zpět</a></h2>
</div>

<?php
/**********************************/
/*On get input get API record data*/
/**********************************/

error_reporting(0);

if(!empty($_GET)){
    if(isset($_GET["record_id"]) && isset($_GET["name"]) && isset($_GET["lng"]) && isset($_GET["lat"])){
        include("api_handler.php");
        $recid = $_GET["record_id"];
        $recname = $_GET["name"];
        $lng = $_GET["lng"];
        $lat = $_GET["lat"];
        performSingleRecordQuery("https://private-anon-81fcb7ce9d-idcrestaurant.apiary-mock.com/daily-menu", $recid, $recname, $lng, $lat);
    }else{
        echo "<h5 class=\"err-mess\">Důležité parametry nejsou zadány</h5>";
    }
}else{
    echo "<h5 class=\"err-mess\">Špatný formát dotazu</h5>";
}

?>
<!-- Cal Javascript scripts after the page loads -->
<script src="scripts/main.js"></script>

</body>
</html>
