<?php
header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: *");

// 🔹 Configuração do banco (mesma conexão)
$host = "ep-rapid-dawn-adacfum3-pooler.c-2.us-east-1.aws.neon.tech"; 
$dbname = "neondb";
$user = "neondb_owner";
$password = "npg_ILpkD1QYf3AU"; 

try {
    $pdo = new PDO(
        "pgsql:host=$host;dbname=$dbname;sslmode=require",
        $user,
        $password,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    echo json_encode(["erro" => "Erro de conexão: " . $e->getMessage()]);
    exit;
}

$numero = $_GET['numero'];
try {
    $stmt = $pdo->prepare("SELECT * FROM infos WHERE numero = :numero");
    $stmt->bindParam(':numero', $numero);
    $stmt->execute();

    $dado = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($dado) {
        echo json_encode($dado, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    } else {
        echo json_encode(["erro" => "Elemento não encontrado"]);
    }
} catch (PDOException $e) {
    echo json_encode(["erro" => "Erro na consulta: " . $e->getMessage()]);
}
