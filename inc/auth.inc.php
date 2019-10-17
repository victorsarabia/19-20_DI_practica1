<?php

session_start();
if (!isset($_SESSION['id_usuario'])) {
	echo "No estás logueado";
	exit();
}