<?php
include 'dbconnection.php';
include 'functions.php';
// $sql = 'SELECT project.id, priority_id.priority_definition, project.createdDate, project.project_name, status_id.status_definition FROM project JOIN status_id ON project.project_status = status_id.id JOIN priority_id ON project.project_priority = priority_id.id ORDER BY project.id;';

// $results = $db->query($sql);
// $results = $results->fetchAll();
// $section = null;

if (isset($_GET['id'])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    $project = get_proj_description($id);
}
print_r($projectComments);
// echo 'This slkghdfkghdf';
//NEXT STEPS - Display the information we have. Display Initial Description. Give the ability to add an additional comment.
$projectTitle = $project['project_name'];
$projectDetails = $project['commentDetails'];
$projectStatus = $project['status_definition'];
$projectPriority = $project['priority_definition'];
$projectCreatedBy = $project['created_by'];
echo "The project title is {$projectTitle}, The Project Status is {$projectStatus} and the Project Priority is {$projectPriority} and was created by {$projectCreatedBy}<br>";

//PROJECT DESC BOX
$projectDescBox = "<div class ='proj-descBox' style ='border:1px solid black'>";
$projectDescBox .= "<p id='origComment'>{$projectDetails}</p>";
$projectDescBox .= "<p id='createdBy'>{$projectCreatedBy}</p>" . "<p id='status'>{$projectStatus}</p>" . "<p id='priority'>{$projectPriority}</p></div>";

echo $projectHeaderDiv;
echo "<h1>{$projectTitle}</h1>";
echo $projectDescBox;

//ADD COMMENT BOX
$postComment = "<div id='commentOuter'>";
echo $postComment;
echo "<form action='' method='POST'><textarea class='tag-user-input comment-textarea-tag' id='comment_txt_field' name='pcomment_text' placeholder='Write a comment...'></textarea><br>";
echo "<button type='submit' name='postComments'>POST</button></form></div>";

//Call Function to Post
if (isset($_POST['postComments'])) {
    echo 'THE BUTTON WAS CLICKED<br>';
    postComments($_POST['pcomment_text'], $id);
} else {
    echo 'This loaded';
}

//All Comments
$commentSection = "<div id='commentsContainer'>";
echo $commentSection;
