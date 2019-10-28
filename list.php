<?php
require_once "inc/auth.inc.php";
require_once "conf.php";

// Definición de variables por si no lo hace el archivo padre donde se incluya
$id = isset($id)? $id : null;
$name = isset($name)? $name : null;
$countryCode = isset($countryCode)? $countryCode : null;
$district = isset($district)? $district : null;
$population = isset($population)? $population : null;
$population_sign = isset($population_sign)? $population_sign : null;

// Recogida de acciones
$pagina = (isset($_POST['pagina'])? $_POST['pagina'] : 1);
$num_registros = (isset($_POST['num_registros'])? $_POST['num_registros'] : 10);
$primero = (isset($_POST['primero'])? true : false);
$ultimo = (isset($_POST['ultimo'])? true : false);
$siguiente = (isset($_POST['siguiente'])? true : false);
$anterior = (isset($_POST['anterior'])? true : false);
$mostrar = (isset($_POST['mostrar'])? true : false);


try {
    // Conexión a BD
    $con = new PDO('mysql:host=localhost;dbname='.DB_NAME.';charset='.DB_CHARSET, DB_USER, DB_PASS);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consulta para obtener el total de registros
    $sql = 'SELECT count(*) FROM city where true';

    $arr_params = array();
    $sql_filters = "";

    // Restricciones para la consulta
    if (!empty($id)) {
        $sql_filters .= " and id=:id";
        $arr_params[":id"] = $id;
    }

    if (!empty($name)) {
        $sql_filters .= " and name like :name";
        $arr_params[":name"] = "%".$name."%";
    }

    if (!empty($countryCode)) {
        $sql_filters .= " and countryCode like :countryCode";
        $arr_params[":countryCode"] = "%".$countryCode."%";
    }

    if (!empty($district)) {
        $sql_filters .= " and district like :district";
        $arr_params[":district"] = "%".$district."%";
    }

    if (!empty($population)) {
        $sql_filters .= " and population".$population_sign.":population";
        $arr_params[":population"] = $population;
    }


    $sql .= $sql_filters;
    //echo $sql;exit();

    $stmt = $con->prepare($sql);
    $stmt->execute($arr_params);
    $result = $stmt->fetch();
    $total_registros = $result[0];


    // Cálculo de Acciones
    $paginas = ceil($total_registros/$num_registros);
    if ($primero) $pagina = 1;
    if ($ultimo) $pagina = $paginas;
    if ($siguiente && $pagina<$paginas) $pagina++;
    if ($anterior && $pagina>1) $pagina--;
    if ($mostrar) $pagina = 1;


    // Consulta para mostrar los datos
    $sql = 'SELECT * FROM city where true';
    $sql .= $sql_filters;

    if ($num_registros != "todos")
        $sql .= " limit ".($num_registros*($pagina-1)) .",". $num_registros;
    //echo $sql;exit();

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

