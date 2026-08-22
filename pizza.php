<?php

session_start();

include_once("conn.php");

$method = $_SERVER["REQUEST_METHOD"];

if ($method === "GET") {

    $bordas = $conn
        ->query("SELECT * FROM bordas")
        ->fetchAll();

    $massas = $conn
        ->query("SELECT * FROM massas")
        ->fetchAll();

    $sabores = $conn
        ->query("SELECT * FROM sabores")
        ->fetchAll();

} elseif ($method === "POST") {

    $borda = filter_input(INPUT_POST, "borda", FILTER_VALIDATE_INT);
    $massa = filter_input(INPUT_POST, "massa", FILTER_VALIDATE_INT);

    $sabores = $_POST["sabores"] ?? [];

    if (!$borda || !$massa) {

        $_SESSION["msg"] = "Selecione a borda e a massa da pizza.";
        $_SESSION["status"] = "warning";

        header("Location: index.php");
        exit;
    }

    if (!is_array($sabores) || empty($sabores)) {

        $_SESSION["msg"] = "Selecione pelo menos um sabor.";
        $_SESSION["status"] = "warning";

        header("Location: index.php");
        exit;
    }

    if (count($sabores) > 3) {

        $_SESSION["msg"] = "Selecione no máximo 3 sabores.";
        $_SESSION["status"] = "warning";

        header("Location: index.php");
        exit;
    }

    $sabores = array_map("intval", $sabores);

    try {

        $conn->beginTransaction();

        // Criação da pizza
        $stmt = $conn->prepare("
            INSERT INTO pizzas (borda_id, massa_id)
            VALUES (:borda, :massa)
        ");

        $stmt->execute([
            ":borda" => $borda,
            ":massa" => $massa
        ]);

        $pizzaId = (int) $conn->lastInsertId();

        // Associação dos sabores
        $stmtSabor = $conn->prepare("
            INSERT INTO pizza_sabor (pizza_id, sabor_id)
            VALUES (:pizza, :sabor)
        ");

        foreach ($sabores as $sabor) {

            $stmtSabor->execute([
                ":pizza" => $pizzaId,
                ":sabor" => $sabor
            ]);
        }

        // Status inicial do pedido
        $statusId = 1;

        $stmtPedido = $conn->prepare("
            INSERT INTO pedidos (pizza_id, status_id)
            VALUES (:pizza, :status)
        ");

        $stmtPedido->execute([
            ":pizza" => $pizzaId,
            ":status" => $statusId
        ]);

        $conn->commit();

        $_SESSION["msg"] = "Pedido realizado com sucesso!";
        $_SESSION["status"] = "success";

    } catch (PDOException $e) {

        if ($conn->inTransaction()) {
            $conn->rollBack();
        }

        error_log("Erro ao realizar pedido: " . $e->getMessage());

        $_SESSION["msg"] = "Não foi possível realizar o pedido.";
        $_SESSION["status"] = "danger";
    }

    header("Location: index.php");
    exit;
}
