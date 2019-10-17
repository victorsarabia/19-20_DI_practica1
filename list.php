<?php
require_once "conf.php";

// Definición de variables por si no lo hace el archivo padre donde se incluya
$id = isset($id)? $id : null;
$name = isset($name)? $name : null;
$countryCode = isset($countryCode)? $countryCode : null;
$district = isset($district)? $district : null;
$population = isset($population)? $population : null;
$population_sign = isset($population_sign)? $population_sign : null;


try {
    // Conexión a BD
    $con = new PDO('mysql:host=localhost;dbname='.DB_NAME, DB_USER, DB_PASS);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = 'SELECT * FROM city where true';
    $arr_params = array();

    // Restricciones para la consulta
    if (!empty($id)) {
        $sql .= " and id=:id";
        $arr_params[":id"] = $id;
    }

    if (!empty($name)) {
        $sql .= " and name like :name";
        $arr_params[":name"] = "%".$name."%";
    }

    if (!empty($countryCode)) {
        $sql .= " and countryCode like :countryCode";
        $arr_params[":countryCode"] = "%".$countryCode."%";
    }

    if (!empty($district)) {
        $sql .= " and district like :district";
        $arr_params[":district"] = "%".$district."%";
    }

    if (!empty($population)) {
        $sql .= " and population".$population_sign.":population";
        $arr_params[":population"] = $population;
    }

    // echo "<pre>";
    // print_r($arr_params);
    // echo "</pre>";
    // exit();

    $stmt = $con->prepare($sql);
    $stmt->execute($arr_params);
?>

<script type="text/javascript">
    /**
     * Carga el recurso por GET donde se produce la eliminación
     *
     * @param id PK de la ciudad a eliminar
     */
	function eliminar(id) {
		var respuesta = confirm("Estás seguro de eliminar la ciudad " + id);

		if (respuesta == true) {
		  console.log("Eliminar: " +id);
		  window.location="index.php?ID="+id;
		}
	}	
</script>

<table>
	<thead>
	<tr>
		<th>ID</th>
		<th>Nombre</th>
		<th>Cód. país</th>
		<th>Distrito</th>
		<th>Población</th>
		<th>Acciones</th>
	</tr>
	</thead>
	<tbody>		
	<?php
	while( $datos = $stmt->fetch(PDO::FETCH_ASSOC) ) {
    	echo '<tr>';
    	echo '<td>'. $datos['ID'] .'</td>';
    	echo '<td>'. $datos['Name'] .'</td>';
    	echo '<td>'. $datos['CountryCode'] .'</td>';
    	echo '<td>'. $datos['District'] .'</td>';
    	echo '<td>'. $datos['Population'] .'</td>';
    	echo '<td>
    			<a href=\'form.php?ID='. $datos['ID'] . '\'> Modificar </a>
    			<a onclick="eliminar('. $datos['ID'] . ')"> Eliminar </a>
    		</td>';
    	echo '</tr>';
	}
	?>
	</tbody>
</table>

<?php  
} catch(PDOException $e) {

    echo 'Error: ' . $e->getMessage();
}

?>

