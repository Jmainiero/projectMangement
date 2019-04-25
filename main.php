<?php
include 'php/dbconnection.php';
include "php/functions.php";

$pageTitle = "Personal Media Library";
$section = null;

include "php/header.php";?>

<section id ="projectDashboard">
  <?php
echo "<table id='projectMain'><th>Project Id</th><th>Priority</th><th>Status</th><th>Created Date</th><th>Project Name</th>";
printTable($db);
?>
</section>
