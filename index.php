<?php

	require_once 'db.php';

	if (isset($_GET['s'])){ # post a clip

		$sqlInsertClip = 'INSERT INTO clips (clip, uri, title, date, userId) VALUES (:clip, :uri, :title, :date, :userId)';
		
		$userId = 1; # until i set up users
		
		$stmt = $dbHandle->prepare($sqlInsertClip);
		$stmt->bindParam(':clip', $_GET['s'], PDO::PARAM_STR);
		$stmt->bindParam(':uri', $_GET['u'], PDO::PARAM_STR);
		$stmt->bindParam(':title', $_GET['t'], PDO::PARAM_STR);
		$stmt->bindParam(':date', time(), PDO::PARAM_INT);
		$stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
		$stmt->execute();
		
		header('Location: http://banterability.com/clip/');

    } elseif (isset($_POST['s'])){ # post a clip

    		$sqlInsertClip = 'INSERT INTO clips (clip, uri, title, date, userId) VALUES (:clip, :uri, :title, :date, :userId)';

    		$userId = 1; # until i set up users

    		$stmt = $dbHandle->prepare($sqlInsertClip);
    		$stmt->bindParam(':clip', $_POST['s'], PDO::PARAM_STR);
    		$stmt->bindParam(':uri', $_POST['u'], PDO::PARAM_STR);
    		$stmt->bindParam(':title', $_POST['t'], PDO::PARAM_STR);
    		$stmt->bindParam(':date', time(), PDO::PARAM_INT);
    		$stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    		$stmt->execute();

    		die();

	} elseif (($_POST['action'] == 'delete') && isset($_POST['id'])) { # delete a clip

		$sqlDelete = 'DELETE FROM clips WHERE id = :id';
		$stmt = $dbHandle->prepare($sqlDelete);
		$stmt->bindParam(':id', $_POST['id'], PDO::PARAM_INT);
		$stmt->execute();
		
		header('Location: http://banterability.com/clip/');

	} else { # load clips
		
		$sqlGetClips = 'SELECT * FROM clips ORDER BY date DESC;';
		$result = $dbHandle->query($sqlGetClips);
		$clips = $result->fetchAll();

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
	
	<h3><em>Can you <a href="javascript:var%20d=document,w=window,e=w.getSelection,k=d.getSelection,x=d.selection,s=(e?e():(k)?k():(x?x.createRange().text:0)),f='http://banterability.com/clip',l=d.location,e=encodeURIComponent,p='?u='+e(l.href)%20+'&t='+e(d.title)%20+'&s='+e(s),u=f+p;try{if(!/^(.*\.)?banterability[^.]*$/.test(l.host))throw(0);tstbklt();}catch(z){a%20=function(){if(!w.open(u))l.href=u;};if(/Firefox/.test(navigator.userAgent))setTimeout(a,0);else%20a();}void(0)">clip it!</a>?</em></h3>

<?php
foreach($clips as $item){
?>
<div class="clipItem" id="clip-<?=$item[id]?>">
<blockquote>
	"<?=stripslashes($item[clip]) ?>"
</blockquote>
From <a href="<?=$item[uri] ?>"><?=$item[title] ?></a> | <em><abbr class="timeago" title="<?=date('c', $item[date])?>"><?=date('M j, Y g:i a', $item[date])?></abbr></em>

<form id="delete" method="post" action="http://banterability.com/clip/">
	<input type="hidden" id="id" name="id" value="<?=$item[id] ?>" />
	<input class="deleteButton" id="action" name="action" type="submit" value="delete" />								
</form>

</div>
<br />

<?php
}
?>

	</div>

</body>
</html>

<?php
 }
 
?>