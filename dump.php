<?php

	require_once 'db.php';
	
	if (($_POST['action'] == 'delete') && isset($_POST['id'])) { # delete a clip

		$sqlDelete = 'DELETE FROM clips WHERE id = :id';
		$stmt = $dbHandle->prepare($sqlDelete);
		$stmt->bindParam(':id', $_POST['id'], PDO::PARAM_INT);
		$stmt->execute();
		
		header('Location: http://banterability.com/clip/dump.php');
	} else {
		
		$sqlGetClips = 'SELECT * FROM clips ORDER BY date DESC;';
		$result = $dbHandle->query($sqlGetClips);
		$clips = $result->fetchAll();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
	
	<title>Clip [alpha]</title>

</head>

<body>

<?php
foreach($clips as $item){
?>
<?=stripslashes($item[clip]) ?> <form style="display:inline" id="delete" method="post" action="http://banterability.com/clip/dump.php">
	<input type="hidden" id="id" name="id" value="<?=$item[id] ?>" />
	<input class="deleteButton" id="action" name="action" type="submit" value="delete" />								
</form>
<hr />

<?php
}
?>

</body>
</html>
<?php

}