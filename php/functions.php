<?php
include 'dbconnection.php';

function printForm()
{
    include 'dbconnection.php';
    $sql = 'SELECT priority_id.priority_definition, status_id.status_definition FROM status_id JOIN priority_id ON priority_id.id = status_id.id';
    $results = $db->query($sql);
    $results = $results->fetchAll();
    $formTag = "<form action='php/form.php' method='post' autocomplete ='off'>";
    $formTag .= "<label>Project Name:</label><Br> <input type='text' name='projectName'>";

    $selectPriority = "<select required name ='project_priorityList'>";
    $selectStatus = "<select required name ='project_statusList'>";

    foreach ($results as $result) {
        $selectPriority .= "<option value = '" . $result['priority_definition'] . "'>" . $result['priority_definition'] . '</option>';
        $selectStatus .= "<option value = '" . $result['status_definition'] . "'>" . $result['status_definition'] . '</option>';
    }
    $selectPriority .= '</select>';
    $selectStatus .= '</select>';
    $formTag .= $selectPriority . $selectStatus . "<br><textarea rows='4' cols='50' name ='projectDetails'></textarea><br><input type='submit' name='submit'></form>";
    echo $formTag;
}

function printTable($db)
{
    // $results = "SELECT * FROM project";

    $sql = 'SELECT project.id, priority_id.priority_definition, project.createdDate, project.project_name, status_id.status_definition FROM project JOIN status_id ON project.project_status = status_id.id JOIN priority_id ON project.project_priority = priority_id.id ORDER BY project.id;';
    $results = $db->query($sql);
    $results = $results->fetchAll();

    foreach ($results as $result => $value) {
        echo '<tr><td>' . $value['id'] . '</td>'
            . '<td>' . $value['priority_definition'] . '</td>'
            . '<td>' . $value['status_definition'] . '</td>'
            . '<td>' . $value['createdDate'] . '</td>'
            . "<td><a target='_BLANK' href='php/projectComments.php?id=" . $value['id'] . "'>" . $value['project_name'] . '</td></tr>';
    }
    echo '</table>';
}

//Project Details Page
function get_proj_description($id) ##Changed function to get_proj_decription 4/22/19

{
    include 'dbconnection.php';
    // echo "Pull Comments was loaded, The current Id we are looking at is {$id}<br>";
    try {
        $results = $db->prepare(
            "SELECT project.id, priority_id.priority_definition,  status_id.status_definition, project.created_by, project.project_name, projectComments.commentDetails, projectComments.commentDate, projectComments.createdBy AS 'comment_created by'
            FROM project RIGHT JOIN projectComments ON project.id=projectComments.id
            JOIN status_id ON project.project_status = status_id.id JOIN priority_id ON project.project_priority = priority_id.id
            WHERE project.id=? AND projectComments.initialDesc=1"
        );
        $results->bindParam(1, $id, PDO::PARAM_INT);
        $results->execute();
    } catch (Exception $e) {
        echo 'bad query';
        echo $e;
    }

    $result = $results->fetch(PDO::FETCH_ASSOC);
    return $result;

}

function get_all_comments($id)
{

    try {
        $results = $db->prepare(
            'SELECT projectComments.commentDetails, projectComments.createdBy, projectComments.initialDesc FROM projectComments WHERE projectId=? AND projectComments.initialDesc=0'
        );
        $results->bindParam(1, $id, PDO::PARAM_INT);
        $results->execute();
    } catch (Exception $e) {
        echo 'bad query';
        echo $e;
    }

    $result = $results->fetch(PDO::FETCH_ASSOC);
    return $result;

}

function postComments($pComment, $projectId)
{
    include 'dbconnection.php';
    $date = date('Y-m-d H:i:s');
    echo 'Function was called<br>';
    echo $pComment . "<Br>{$projectId}<br>";
    $results = "INSERT INTO projectComments(projectId, createdBy,commentDetails,commentDate, initialDesc) VALUES($projectId,1, '$pComment','$date',0)";
    echo $results;
    if ($db->query($results)) {
        echo 'Inserted Successfully' . '<br><br>';
        // echo "<meta http-equiv='refresh' content='0'>";
    } else {
        echo 'This was not inserted';
    }
    echo $pComment . "<Br>{$id}<br>";
    echo 'Posting to database.....<br>';
}

// $projectQuery = "INSERT INTO project(project_priority,project_status,created_by, createdDate,       project_name)
// VALUES($priorityId[$projectPriority],$statusId[$projectStatus] ,1, '$date','$projectName')";
// $pdQuery = "INSERT INTO projectComments(createdBy,commentDetails,commentDate)
//     VALUES(1, '$projectDetails','$date')";
