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
  <h1 class="main-header">Menu vybraných restaurací</h1>
</div>


<?php
error_reporting(0);
// Call all records to write out
include("api_handler.php");
performAllRecordQuery("https://private-anon-81fcb7ce9d-idcrestaurant.apiary-mock.com/restaurant");
?>

<!-- Cal Javascript scripts after the page loads -->
<script src="scripts/main.js"></script>

</body>
</html>
