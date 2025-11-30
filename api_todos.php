<?php
header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: *");

// 🔹 Configuração do banco (MESMA que você usa no outro arquivo)
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

try {
    // 🔹 Busca TODOS os elementos da tabela "infos"
    $stmt = $pdo->prepare("SELECT * FROM infos ORDER BY numero ASC");
    $stmt->execute();

    $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($dados, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

} catch (PDOException $e) {
    echo json_encode(["erro" => "Erro na consulta: " . $e->getMessage()]);
}
