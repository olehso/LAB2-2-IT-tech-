<?php

require './connection.php';

$res = $db->literature->distinct('author');
$outauth[] = array();
unset($outauth[0]);

foreach ($res as $value) {
	if(is_object($value)){
		foreach ($value as $author)
			$outauth[] .= $author;
	}
	else $outauth[] .= $value;
}