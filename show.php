<?php

	require_once 'db.php';

	$sqlGetClips = 'SELECT * FROM clips WHERE id = :id;';
	$stmt = $dbHandle->prepare($sqlGetClips);		
	$stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
	$stmt->execute();
	$clips = $stmt->fetchAll();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<!-- metadata to-do
    <meta name="viewport" content="width = ########"/>
   	<link rel="icon" href="#" type="image/gif"/>
   	<link rel="apple-touch-icon" href="#"/>
-->	

	<script src="http://banterability.com/js/jquery-1.2.6.min.js" type="text/javascript"></script>
	<script src="http://banterability.com/js/timeago.js" type="text/javascript"></script>
	<script type="text/javascript">
		jQuery(document).ready(function() {
  			jQuery('abbr[class*=timeago]').timeago();
		});
	</script>
	
	<style type="text/css" media="screen">
		abbr { border-bottom: 1px dotted #333; }
		.clipItem {border:2px solid black;-webkit-border-radius:10px;padding:10px;width:950px;}
		blockquote {font-size:18px;}
		form#delete {display:inline;padding-left:15px;}
	</style>
	
	<title>Clip [alpha]</title>

	<link rel="stylesheet" type="text/css" href="default.css" />

</head>

<body>
	<h1>Clip!</h1>
	
<?php

if (!$clips){ 
	echo '<h2>invalid clip id!</h2>';
} else {

foreach($clips as $item){
?>
<div class="clipItem" id="clip-<?=$item[id]?>">
<blockquote>"<?=stripslashes($item[clip]) ?>"</blockquote>
From <a href="<?=$item[uri] ?>"><?=$item[title] ?></a> | <em><abbr class="timeago" title="<?=date('c', $item[date])?>"><?=date('M j, Y g:i a', $item[date])?></abbr></em>

<form id="delete" method="post" action="http://banterability.com/clip/">
	<input type="hidden" id="id" name="id" value="<?=$item[id] ?>" />
	<input class="deleteButton" id="action" name="action" type="submit" value="delete" />								
</form>

</div>
<?php
}
}
?>

	</div>

</body>
</html>