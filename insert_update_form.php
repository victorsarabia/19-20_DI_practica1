<?php 
require_once "conf.php";

// echo "<pre>";
// print_r($_POST);
// echo "</pre>";
// exit();

$id = isset($_POST['ID'])? $_POST['ID'] : null;
$name = isset($_POST['Name'])? $_POST['Name'] : null;
$countryCode = isset($_POST['CountryCode'])? $_POST['CountryCode'] : null;
$district = isset($_POST['District'])? $_POST['District'] : null;
$population = isset($_POST['Population'])? $_POST['Population'] : null;


try {
	$con = new PDO('mysql:host=localhost;dbname='.DB_NAME, DB_USER, DB_PASS);
	$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	if (!empty($id)) {
		// Update
		$stmt = $con->prepare('UPDATE city set name=:name, countryCode=:countryCode, district=:district, population=:population WHERE id=:id');
		$rows = $stmt->execute(array(
				':id' => $_POST['ID'],
				':name' => $_POST['Name'],
				':countryCode' => $_POST['CountryCode'],
				':district' => $_POST['District'],
				':population' => $_POST['Population'],
				));
		
		if( $rows == 1 )
			echo "<h3>Modificado correctamente.</h3>";
		else
			echo "<h3>Error al modificar.</h3>";

	} else {
		// Insert
		$stmt = $con->prepare('INSERT INTO city VALUES (:id, :name, :countryCode, :district, :population)');
		$rows = $stmt->execute(array(
				':id' => $_POST['ID'],
				':name' => $_POST['Name'],
				':countryCode' => $_POST['CountryCode'],
				':district' => $_POST['District'],
				':population' => $_POST['Population'],
				));

		if( $rows == 1 )
			echo "<h3>Insertado correctamente.</h3>";
		else
			echo "<h3>Error al insertar.</h3>";		
	}

	echo "<a href='index.php'> Volver </a>";

} catch(PDOException $e) {
	echo 'Error: ' . $e->getMessage();
}