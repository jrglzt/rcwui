<?php   
session_start(); /*Asegurar que esta usando la misma sesión*/
session_destroy(); /*Destruye la sesión*/
session_register_shutdown();
header("location: index3.php"); /*Redirecciona hacia la página index3.php despues de cerrar sesión*/
exit();
?>
