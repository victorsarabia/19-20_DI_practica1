<?php
require_once "conf.php";

/*
// Para crear usuarios de BD
try {
    // Conexión a BD
    $con = new PDO('mysql:host=localhost;dbname='.DB_NAME.';charset='.DB_CHARSET, DB_USER, DB_PASS);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql_insert = "insert into user values ('victor', '". password_hash("1234", PASSWORD_BCRYPT) ."', 'Víctor Sarabia')";
    $stmt = $con->prepare($sql_insert);
    $stmt->execute();
} catch(PDOException $e) {

    echo 'Error: ' . $e->getMessage();
}
exit();
*/

$user = isset($_POST['user'])? $_POST['user'] : null;
$password = isset($_POST['password'])? $_POST['password'] : null;
$msg = "";

// Si se hace el submit
if (isset($_POST["enviar"])) {

    if ((empty($user) || empty($password))) {
        $msg = "El usuario y contraseña es obligatorio.";
    } else {
        try {
            // Conexión a BD
            $con = new PDO('mysql:host=localhost;dbname=' . DB_NAME . ';charset=' . DB_CHARSET, DB_USER, DB_PASS);
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = 'SELECT * FROM user where user = :user';

            $stmt = $con->prepare($sql);
            $stmt->execute(array(":user" => $user));
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            // Si devuelve resultados verifica el password. No se puede comparar directamente en la query porque cada vez genera uno
            if (isset($result["nombre"]) && !empty($result["nombre"]) && isset($result['pass'])) {

                if (password_verify($password, $result['pass'])) {
                    if (isset($_SESSION))
                        session_destroy();
                    session_start();
                    $_SESSION["user"] = $result["user"];
                    $_SESSION["user_name"] = $result["nombre"];

                    header("Location: index.php");
                    exit();
                } else {
                    $msg = "Usuario o contraseña erróneo.";
                }

            } else {
                $msg = "Usuario o contraseña erróneo.";
            }

        } catch (PDOException $e) {

            echo 'Error: ' . $e->getMessage();
        }
    }
}

?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Práctica 2.1</title>
    <link rel="stylesheet" type="text/css" href="css/login.css">
</head>
<body>

    <h1>Práctica 2.1</h1>
    <h2>Login</h2>
    <form method="post" action="login.php">
        <input type="text" name="user" placeholder="Usuario" />
        <input type="password" name="password" placeholder="Contraseña" />

        <input type="submit" value="Enviar" name="enviar" />
    </form>

    <div id="msg">
        <?php echo $msg ?>
    </div>
</body>
</html>
