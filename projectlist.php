<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Untitled Document</title>
</head>

<body>
    <h1>List of all Projects</h1>
<?php
    require_once 'dbcon.php';

    $sql = 'SELECT p.project_id, p.project_name FROM project p';
    $stmt = $link->prepare($sql);
    $stmt->execute();
    $stmt->bind_result($pid, $pnam);

    while($stmt->fetch()) {
        echo '<li><a href="projectdetails.php?pid='.$pid.'">'.$pnam.'</a></li>'.PHP_EOL;
    }


?>
    
    
</body>
</html>