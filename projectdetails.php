<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Untitled Document</title>
</head>

<body>
<a href="projectlist.php">Home</a><br>
    <?php
        // Henter project detajler fra project-tabel
        $pid = filter_input(INPUT_GET, 'pid', FILTER_VALIDATE_INT) or die('Missing/illegal parameter');

        require_once 'dbcon.php';
        $sql = 'SELECT p.project_name, p.project_startdate, p.project_enddate, p.project_detail, c.client_name AS cname
        FROM project p, client c
        WHERE p.project_id=?
        AND c.client_id=c.client_id';
        $stmt = $link->prepare($sql);
        $stmt->bind_param('i', $pid);
        $stmt->execute();
        $stmt->bind_result($pname, $psdate, $pedate, $pdet, $ccname);

        while($stmt->fetch()) { }
    ?>
    <h1>Project Name: <?=$pname?></h1>
    <p>
        Start: <?=$psdate?><br>
        End:   <?=$pedate?><br>
        Comment: <?=$pdet?><br>
    </p>
    
    <h2>Client</h2>
    <?php
        require_once 'dbcon.php';
        $sql = 'SELECT	c.client_id, c.client_name
        FROM	project p, client c
        WHERE	p.project_id=?
        AND		p.project_id=c.client_id
        ';
        $stmt = $link->prepare($sql);
        $stmt->bind_param('i', $pid);
        $stmt->execute();
        $stmt->bind_result($cid, $cnam);
        while($stmt->fetch()) {
        echo '<li><a href="clientinfo.php?cid='.$cid.'">'.$cnam.'</a></li>';
        }
        ?>
    
   <h2>Resources</h2>
        <?php 
            // henter resource-detajler fra de resourser der er tilknyttet projektet

            require_once 'dbcon.php';

            $sql = 'SELECT r.resources_id, r.resources_name
FROM resources r, project_has_resources phr, project p
WHERE p.project_id = ?
AND phr.resources_resources_id = r.resources_id
AND p.project_id = phr.project_project_id';
            $stmt = $link->prepare($sql);
            $stmt->bind_param('i', $pid);
            $stmt->execute();
            $stmt->bind_result($rid, $rnam);

             while($stmt->fetch()) {
                 echo '<li>'.$rnam.'</li>';
             
        ?>
        
<form action="deleteresource.php" method="post">
<input type="hidden" name="pid" value="<?=$pid?>">
<input type="hidden" name="rid" value="<?=$rid?>">
<input type="submit" value="Delete"> 
</form>	<br>
	<?php
	echo '</li>'; }

?>
    
    
    
    <h2>Tilføj ressourcer til projektet</h2>
<form action="addresource.php" method="post">
<input type="hidden" name="pid" value="<?=$pid?>">
    <select name="rid">
    <?php
        require_once 'dbcon.php';
        $sql = 'SELECT	r.resources_id, r.resources_name
FROM	resources r';
        $stmt = $link->prepare($sql);
        $stmt->execute();
        $stmt->bind_result($rid, $rnam);
        while ($stmt->fetch()) {
        echo '<option value="'.$rid.'">'.$rnam.'</option>'.PHP_EOL;
        }
    ?>
    
    </select>
    <input type=submit value="Add">
</body>
</html>