<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Client detaljer</title>
</head>
<body>
<?php

$cid = filter_input(INPUT_GET, 'cid', FILTER_VALIDATE_INT) or die('Missing/illegal parameter');

require_once 'dbcon.php';
$sql = 'SELECT	c.client_id, c.client_name, c.client_adress, c.client_contact_person, c.client_contact_phone
FROM	client c
WHERE	c.client_id=?';
$stmt = $link->prepare($sql);
$stmt->bind_param('i', $cid);
$stmt->execute();
$stmt->bind_result($cid, $cname, $cadr, $ccp, $cphn);
while($stmt->fetch()) { }
?>
<h1><?=$cname?> (<?=$cid?>)</h1>
<p>
Contact person: <?=$ccp?><br>
Phone: <?=$cphn?><br>
</p> <br><br>
<h2>Projects</h2>
<?php
        require_once 'dbcon.php';
        $sql = 'SELECT	p.project_id, p.project_name
FROM	project p, client c
WHERE	c.client_id=?
AND		p.project_id=c.client_id
';
        $stmt = $link->prepare($sql);
        $stmt->bind_param('i', $cid);
        $stmt->execute();
        $stmt->bind_result($pid, $pnam);

        while($stmt->fetch()) {
         echo '<li><a href="projectdetails.php?pid='.$pid.'">'.$pnam.'</a></li>';
        }
    ?>


</body>
</html>