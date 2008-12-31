<?php

try{
	$dbHandle = new PDO('sqlite:'.$_SERVER['DOCUMENT_ROOT'].'/../db/clip_db.sqlite3');
} catch ( PDOException $exception ) {
	die($exception->getMessage());
}

?>