<?php
require 'dbconnection.php';
$date = date('Y-m-d H:i:s');
$priorityId = ['Low' => 1, 'Medium' => '2', 'High' => 3, 'Urgent' => 4];
$statusId = ['Pending' => 1, 'Working On' => '2', 'Initial Research' => 3, 'Closed' => 4, 'Cancelled' => 5];
if (isset($_POST['submit'])) {
    $projectName = $_POST['projectName'];
    $projectPriority = $_POST['project_priorityList'];
    $projectStatus = $_POST['project_statusList'];
    $projectDetails = $_POST['projectDetails'];
    if ($projectName != '') {
        echo ('Project Name: ' . $projectName . "<br />\n");
        echo 'The project id is : ' . $priorityId[$projectPriority];
        echo 'The status id is : ' . $statusId[$projectStatus];
        echo "<br>{$projectDetails}<br>";
//  echo("Last name: " . $_POST['lastname'] . "<br />\n");
        $projectQuery = "INSERT INTO project(project_priority,project_status,created_by, createdDate,project_name)
        VALUES($priorityId[$projectPriority],$statusId[$projectStatus] ,1, '$date','$projectName')";
        $pdQuery = "INSERT INTO projectComments(createdBy,commentDetails,commentDate, initialDesc)
            VALUES(1, '$projectDetails','$date', 1)";

        if ($db->query($projectQuery) && $db->query($pdQuery)) {
            echo 'Inserted Successfully' . '<br><br>';
            // echo "<meta http-equiv='refresh' content='0'>";
            header('Location:../main.php');
        } else {
            echo 'This was not inserted';
        }
    }
} else {
    echo 'This form was empty';
}
