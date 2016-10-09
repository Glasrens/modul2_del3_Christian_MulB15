<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>tilføj ressource</title>
</head>

<body>
<?php
$rid = filter_input(INPUT_POST, 'rid', FILTER_VALIDATE_INT) or die('Missing/illegal parameter');
$pid = filter_input(INPUT_POST, 'pid', FILTER_VALIDATE_INT) or die('Missing/illegal parameter');

//echo $rid.' xxxx '.$pid;

require_once 'dbcon.php';
$sql = 'INSERT INTO project_has_resources (project_project_id, resources_resources_id) VALUES (?, ?)';
$stmt = $link->prepare($sql);
$stmt->bind_param('ii', $pid, $rid);
$stmt->execute();

if($stmt->affected_rows > 0) {
	echo 'Resource has been added';
}
else {
	echo 'Resource already connected to project';
}

?>

<a href="projectdetails.php?pid=<?=$pid?>">Go back to project</a><br>

</body>
</html>