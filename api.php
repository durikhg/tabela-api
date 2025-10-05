<?php
header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: *");

$host = "ep-rapid-dawn-xxxxx.us-east-2.aws.neon.tech"; // coloque o host do Neon
$dbname = "neondb";
$user = "neondb_owner";
$password = "sua_senha_aqui";

try {
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname;sslmode=require", $user, $password);
} catch (PDOException $e) {
    echo json_encode(["erro" => $e->getMessage()]);
    exit;
}

$simbolo = $_GET['simbolo'] ?? '';
if (!$simbolo) {
    echo json_encode(["erro" => "Símbolo não informado"]);
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM elementos WHERE simbolo = :simbolo");
$stmt->bindParam(':simbolo', $simbolo);
$stmt->execute();

$elemento = $stmt->fetch(PDO::FETCH_ASSOC);

if ($elemento) {
    echo json_encode($elemento, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
} else {
    echo json_encode(["erro" => "Elemento não encontrado"]);
}
