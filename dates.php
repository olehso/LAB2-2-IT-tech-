<?php
function console_log( $data ){
  echo '<script>';
  echo 'console.log('. json_encode( $data ) .')';
  echo '</script>';
}
require 'connection.php';

$time1 = explode("-",$_GET['date_start']);
$time2 = explode("-",$_GET['date_end']);
$year1 = (int)$time1[0];
$year2 = (int)$time2[0];

$tempTime1 = strtotime($_GET['date_start']);
$tempTime2 = strtotime($_GET['date_end']);

$utcDate1 = new MongoDB\BSON\UTCDateTime(($tempTime1+7200) * 1000);
$utcDate2 = new MongoDB\BSON\UTCDateTime(($tempTime2+7200) * 1000);

$cursor = $db->literature->find(array('$or' => array(
array('year' => array('$gte' => $year1, '$lte' => $year2)),
array('date' =>	array('$gte'	=>	$utcDate1, '$lte' => $utcDate2))
)));

$result = iterator_to_array($cursor);

$i=1;

foreach ($result as $key => $value) {
	echo "Литературный ресурс №: ".$i.":".'</br>';
	echo "Тип : ".$value['literate'].'</br>';
	echo "Название: ".$value['name'].'</br>';
	if (isset($value['author'])) {
		if (is_object($value['author'])) {
		$a=1;
		echo "Авторы: ".'</br>';
		foreach ($value['author'] as $author) {
				echo '&nbsp;&nbsp;&nbsp;&nbsp;'."\tАвтор ".$a.": ".$author.'</br>';
				$a++;
			}
		}
		else echo "Автор: ".$value['author'].'</br>';
	}
	if (isset($value['year'])) echo "Год издания: ".$value['year'].'</br>';
	if (isset($value['publisher'])) echo "Издательство: ".$value['publisher'].'</br>';
	if (isset($value['date'])) echo "Дата: ".$value['date']->toDateTime()->format('Y-m-d').'</br>';	
	if (isset($value['quantity'])) echo "Количество страниц: ".$value['quantity'].'</br>';
	if (isset($value['number'])) echo "Номер: ".$value['number'].'</br>';
	if (isset($value['ISBN'])) echo "Код ISBN: ".$value['ISBN'].'</br>';

	if (isset($value['Resourse'])) {
		if (is_object($value['Resourse'])) {
		$r=1;
		echo "Доп. ресурсы: ".'</br>';
		foreach ($value['Resourse'] as $Res) {
				echo '&nbsp;&nbsp;&nbsp;&nbsp;'."\tРесурс ".$r.": ".$Res.'</br>';
				$r++;
			}
		}
		else echo "Доп. ресурс: ".$value['Resourse'].'</br>';
	}
	echo '</br>';
	$i++;
}

?>