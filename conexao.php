<?php 

$host = 'localhost';
$dbname = 'hemocenter_db';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    // Configurações adicionais
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec("SET NAMES utf8");
    
} catch(PDOException $e) {
    die("Erro ao conectar: " . $e->getMessage());
}

?>