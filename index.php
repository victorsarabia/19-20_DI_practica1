<?php
require_once "conf.php";

// Recogida de parámetros GET para eliminar
$id = isset($_GET['ID'])? $_GET['ID'] : null;


// Para eliminar
if (!empty($id)) {
	try {
		$con = new PDO('mysql:host=localhost;dbname='.DB_NAME, DB_USER, DB_PASS);
		$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		// Delete
		$stmt = $con->prepare('DELETE from city WHERE id=:id');
		$rows = $stmt->execute(array(
				':id' => $_GET['ID']
			));
		
		if( $rows == 1 )
			echo "<h3>Eliminado correctamente.</h3>";
		else
			echo "<h3>Error al eliminar.</h3>";

		
	} catch(PDOException $e) {
		echo 'Error: ' . $e->getMessage();
	}
} else {

    // Recogida de parámetros POST para buscador
    $id = isset($_POST['ID'])? $_POST['ID'] : null;
    $name = isset($_POST['Name'])? $_POST['Name'] : null;
    $countryCode = isset($_POST['CountryCode'])? $_POST['CountryCode'] : null;
    $district = isset($_POST['District'])? $_POST['District'] : null;
    $population = isset($_POST['Population'])? $_POST['Population'] : null;
    $population_sign = isset($_POST['population_sign'])? $_POST['population_sign'] : null;
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Listado práctica DI 1.2</title>
	<link rel="stylesheet" type="text/css" href="css/index.css">
	<link rel="stylesheet" type="text/css" href="css/list.css">
    <link rel="stylesheet" type="text/css" href="css/buscador.css">
</head>
<body>	
	<h1>Práctica DI 1.2</h1>
	
	<nav>
		<form action="form.php" method="POST">
			<input type="submit" name="Nueva" value="nueva" />
		</form>
	</nav>

    <?php require "buscador.php";?>
	<?php require "list.php";?>
</body>
</html>
