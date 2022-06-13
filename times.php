<?php
header('Content-Type: text/html; charset=utf-8');
$dsn = "mysql:host=localhost; dbname=librarydb";
$user = 'root';
$pass = '';
try {
    $dbh = new PDO($dsn,$user,$pass);

    $time1 = $_GET["date_start"];
	$time2 = $_GET["date_end"];

    $timestart = "SELECT DISTINCT * FROM literature	LEFT JOIN resourse ON literature.FID_Resourse = resourse.ID_Resourse 
	WHERE (date BETWEEN '". $time1 ."' AND '". $time2 ."') OR (year BETWEEN EXTRACT(YEAR FROM '". $time1 ."') and EXTRACT(YEAR FROM '". $time2 ."'))";
	
	$b=1;
	$j=1;
	$n=1;
   if (!empty($timestart)){
        foreach ($dbh->query($timestart) as $raw) {
			if ($raw['literate'] == "Book") {
				echo "Книга ". $b .":".'</br>';
				echo "Название: ".$raw['name'] . '</br>'."Издательство: ".$raw['publisher'].'</br>'.
				"Год издания: ".$raw['year'] . '</br>'. "Количество Страниц: ".$raw['quantity'] . '</br>' ."Код ISBN: ".$raw['ISBN'] .'</br>';
				if (isset($raw['title'])) echo "Доп. Ресурс: ".$raw['title'].'</br>'.'</br>';
				else echo '</br>';
				$b++;
			}
			else if ($raw['literate'] == "Journal") {
				echo "Журнал ". $j .":".'</br>';
				echo "Название: ".$raw['name'] . '</br>'. "Год выпуска: ".$raw['year'] . '</br>'. "Номер : ".$raw['number'] .'</br>';
				if (isset($raw['title'])) echo "Доп. Ресурс: ".$raw['title'].'</br>'.'</br>';
				$j++;
			}
			else if ($raw['literate'] == "Newspaper"){
				echo "Газета ". $j .":".'</br>';
				echo "Название: ".$raw['name'] . '</br>'. "Дата выпуска: ".$raw['date'] .'</br>'.'</br>';
				echo '</br>';			
				$b++;
			}
			else{
				echo "ошибка";
			}		
        }
    }
    else{
        echo "Ошибка!";
    }
} catch (PDOException $e) {
    echo $ex->GetMessage();
}
?>