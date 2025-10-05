<?php
header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: *");

// 🔹 Configuração Neon Pooler
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

// 🔹 Recebe símbolo do elemento
$simbolo = $_GET['simbolo'] ?? '';
if (!$simbolo) {
    echo json_encode(["erro" => "Símbolo não informado"]);
    exit;
}

// 🔹 Busca elemento na tabela
try {
    $stmt = $pdo->prepare("SELECT * FROM elementos WHERE simbolo = :simbolo");
    $stmt->bindParam(':simbolo', $simbolo);
    $stmt->execute();

    $elemento = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($elemento) {
        echo json_encode($elemento, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    } else {
        echo json_encode(["erro" => "Elemento não encontrado"]);
    }
} catch (PDOException $e) {
    echo json_encode(["erro" => "Erro na consulta: " . $e->getMessage()]);
}
