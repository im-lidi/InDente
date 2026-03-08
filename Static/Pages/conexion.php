<?php
$server = "DESKTOP-F28L0TE\MSSQLSERVER01";
$database = "DB";


try {
    $conn = new PDO(
    "odbc:Driver={ODBC Driver 17 for SQL Server};Server=$server;Database=$database;Trusted_Connection=yes;"
);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Conexión establecida; no imprimir mensajes para evitar contaminar respuestas JSON
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

?>
