<!DOCTYPE html>
<html>
<head>
<title>Menu vybraných restaurací</title>
</head>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="styles/styles.css">
<link rel="stylesheet" type="text/css" href="styles/mq-main.css">
<body>

<div id="header">
  <h1 class="main-header">Menu vybraných restaurací</h1>
</div>


<?php
error_reporting(E_ALL);
// Call all records to write out
include("api_handler.php");
performAllRecordQuery("https://private-anon-81fcb7ce9d-idcrestaurant.apiary-mock.com/restaurant");
?>

<!-- Cal Javascript scripts after the page loads -->
<script src="scripts/main.js"></script>

</body>
</html>