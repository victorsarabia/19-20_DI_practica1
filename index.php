<?php
require "inc/auth.inc.php";
require "conf.php";

// Recogida de parámetros GET para eliminar
$id = isset($_GET['ID'])? $_GET['ID'] : null;


// Para eliminar
if (!empty($id)) {
	try {
		$con = new PDO('mysql:host=localhost;dbname='.DB_NAME.';charset='.DB_CHARSET, DB_USER, DB_PASS);
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

    // Recogida de parámetros para el paginador
    $pagina = isset($_POST['pagina'])? $_POST['pagina'] : null;
    $num_registros = isset($_POST['num_registros'])? $_POST['num_registros'] : null;
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Listado práctica DI 2.1</title>
	<link rel="stylesheet" type="text/css" href="css/index.css">
	<link rel="stylesheet" type="text/css" href="css/list.css">
    <link rel="stylesheet" type="text/css" href="css/buscador.css">
    <link rel="stylesheet" type="text/css" href="css/paginador.css">
</head>
<body>	
	<h1>Práctica DI 2.1</h1>
	
	<nav>
		<form action="form.php" method="POST">
			<input type="submit" name="Nueva" value="nueva" />
		</form>
        <a href="logout.php">Cerrar sesi&oacute;n</a>
	</nav>

    <!-- Se abre aquí el formulario para que abarque el buscador y el paginador, si no uno no tendría la información de ambos -->
    <form method="post" action="index.php">
    <?php require "buscador.php"?>
	<?php require "list.php"?>
    <?php require "paginador.php"?>
    </form>
</body>
</html>
