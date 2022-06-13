<?php
require './connection.php';

$res = $db->literature->distinct('publisher');
$outpub[] = array();
unset($outpub[0]);

foreach ($res as $value) {
    $outpub[] .= $value;
}

?>