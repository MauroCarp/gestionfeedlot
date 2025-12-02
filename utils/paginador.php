<?php
include('includes/conexion.php');
include('includes/funciones.php');
// Legacy paginador neutralizado tras migración a DataTables.
http_response_code(204);
exit;
?>