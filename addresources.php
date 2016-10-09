<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Untitled Document</title>
</head>

<body>
<?php
$rid = filter_input(INPUT_POST, 'rid', FILTER_VALIDATE_INT) or die('Missing/illegal parameter');
$pid = filter_input(INPUT_POST, 'pid', FILTER_VALIDATE_INT) or die('Missing/illegal parameter');

// echo $fid.' xxxx '.$cid;

require_once 'dbcon.php';
$sql = 'INSERT INTO project_has_resources (resources_id, project_id) VALUES (?, ?)';
$stmt = $link->prepare($sql);
$stmt->bind_param('ii', $pid, $rid);
$stmt->execute();

if($stmt->affected_rows > 0) {
	echo 'Resources added to project :-)';
}
else {
	echo 'Resources already in Project';
}
?>

<a href="projectdetails.php?pid=<?=$pid?>">Se Project</a><br>
<a href="projectlist.php?fid=<?=$fid?>">Se prjocet med samme resourcer</a><br>



</body>
</html>