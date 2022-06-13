<?php
header('Content-Type: application/json');

require 'connection.php';

$test = $_GET['author'];

$cond=array("author"=> array('$eq' => $test));
$cursor = $db->literature->find($cond);
$result = iterator_to_array($cursor);


$cursor = $db->literature->find(array('$or' => array(
array('author' => array('$eq' => $test)),
array('array' => array('$in' =>	array($test)))
)));

$out = "";

$i = 1;

foreach ($result as $key => $value) {
	$out .= "Книга № ".$i." Автора ".$test.'</br>'."Название: ".$value['name'].'</br>';
	if (is_object($value['author'])) {
		$a = 1;
		$out .= "Другие авторы:".'</br>';
		foreach ($value['author'] as $key => $author) {
			if ($author != $test) {
				$out .= '&nbsp;&nbsp;&nbsp;&nbsp;'."\tАвтор ".$a.": ".$author.'</br>';
				$a++;
			}
		}
	}
	if (isset($value['year'])) $out .= "Год издания: ".$value['year'].'</br>';
	if (isset($value['publisher'])) $out .= "Издательство ".$value['publisher'].'</br>';
	if (isset($value['date'])) $out .= "Дата: ".$value['date']->toDateTime()->format('Y-m-d').'</br>';	
	if (isset($value['quantity'])) $out .= "Количество страниц: ".$value['quantity'].'</br>';
	if (isset($value['number'])) $out .= "Номер: ".$value['number'].'</br>';
	if (isset($value['ISBN'])) $out .= "Код ISBN: ".$value['ISBN'].'</br>';
	$out .= "Тип : ".$value['literate'].'</br>';
	if (isset($value['Resourse'])) {
		if (is_object($value['Resourse'])) {
		$r=1;
		$out .= "Доп. ресурсы: ".'</br>';
		foreach ($value['Resourse'] as $Res) {
				$out .= '&nbsp;&nbsp;&nbsp;&nbsp;'."\tРесурс ".$r.": ".$Res.'</br>';
				$r++;
			}
		}
		else $out .= "Дополнительный ресурс: ".$value['Resourse'].'</br>';
	}
	$out .= '</br>';
	$i++;
}
echo json_encode($out);
?>