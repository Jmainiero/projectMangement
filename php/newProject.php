<?php
require 'dbconnection.php';

$date = date('Y-m-d H:i:s');
$projectName = $_POST['projectName'];
$projectPriority = $_POST['project_priorityList'];
$projectStatus = $_POST['project_statusList'];
$priorityId = ["low" => 1, "medium" => "2", "high" => 3, "urgent" => 4];
$statusId = ["pending" => 1, "working-on" => "2", "initial-research" => 3, "closed" => 4, "cancelled" => 5];

if (isset($_POST['submit']) && $projectName != "") {
    echo ("Project Name: " . $projectName . "<br />\n");
    echo 'The project id is : ' . $priorityId[$projectPriority];
    echo 'The status id is : ' . $statusId[$projectStatus];
//  echo("Last name: " . $_POST['lastname'] . "<br />\n");
    $projectQuery = "INSERT INTO project(project_priority,project_status,created_by, createdDate, project_name) VALUES($priorityId[$projectPriority],$statusId[$projectStatus] ,1, '$date','$projectName')";

    if ($db->query($projectQuery)) {
        echo "Inserted Successfully" . "<br><br>";
    }
} else {
    echo "This form was empty";
}
