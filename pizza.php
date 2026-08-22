<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once("conn.php");

$method = $_SERVER["REQUEST_METHOD"];

if ($method === "GET") {

    // Carrega as opções disponíveis para montagem da pizza
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

    // Validação dos dados recebidos
    $borda = filter_input(
        INPUT_POST,
        "borda",
        FILTER_VALIDATE_INT
    );

    $massa = filter_input(
        INPUT_POST,
        "massa",
        FILTER_VALIDATE_INT
    );

    $sabores = $_POST["sabores"] ?? [];

    // Valida borda e massa
    if (!$borda || !$massa) {

        $_SESSION["msg"] =
            "Selecione a borda e a massa da pizza.";

        $_SESSION["status"] = "warning";

        header("Location: index.php");
        exit;
    }

    // Valida se pelo menos um sabor foi selecionado
    if (!is_array($sabores) || empty($sabores)) {

        $_SESSION["msg"] =
            "Selecione pelo menos um sabor.";

        $_SESSION["status"] = "warning";

        header("Location: index.php");
        exit;
    }

    // Limita a quantidade de sabores
    if (count($sabores) > 3) {

        $_SESSION["msg"] =
            "Selecione no máximo 3 sabores.";

        $_SESSION["status"] = "warning";

        header("Location: index.php");
        exit;
    }

    // Converte os sabores para inteiros válidos
    $sabores = array_filter(
        array_map("intval", $sabores),
        fn($sabor) => $sabor > 0
    );

    // Garante que existam sabores válidos
    if (empty($sabores)) {

        $_SESSION["msg"] =
            "Selecione sabores válidos.";

        $_SESSION["status"] = "warning";

        header("Location: index.php");
        exit;
    }

    try {

        // Inicia a transação
        $conn->beginTransaction();

        /*
         * Criação da pizza
         */
        $stmtPizza = $conn->prepare("
            INSERT INTO pizzas (
                borda_id,
                massa_id
            )
            VALUES (
                :borda,
                :massa
            )
        ");

        $stmtPizza->execute([
            ":borda" => $borda,
            ":massa" => $massa
        ]);

        $pizzaId = (int) $conn->lastInsertId();

        /*
         * Associação dos sabores à pizza
         */
        $stmtSabor = $conn->prepare("
            INSERT INTO pizza_sabor (
                pizza_id,
                sabor_id
            )
            VALUES (
                :pizza,
                :sabor
            )
        ");

        foreach ($sabores as $sabor) {

            $stmtSabor->execute([
                ":pizza" => $pizzaId,
                ":sabor" => $sabor
            ]);
        }

        /*
         * Criação do pedido
         *
         * Status 1 representa o status inicial
         * configurado no banco de dados.
         */
        $statusId = 1;

        $stmtPedido = $conn->prepare("
            INSERT INTO pedidos (
                pizza_id,
                status_id
            )
            VALUES (
                :pizza,
                :status
            )
        ");

        $stmtPedido->execute([
            ":pizza" => $pizzaId,
            ":status" => $statusId
        ]);

        // Confirma todas as operações
        $conn->commit();

        $_SESSION["msg"] =
            "Pedido realizado com sucesso!";

        $_SESSION["status"] = "success";

    } catch (PDOException $e) {

        // Desfaz as operações caso alguma etapa falhe
        if ($conn->inTransaction()) {
            $conn->rollBack();
        }

        error_log(
            "Erro ao realizar pedido: "
            . $e->getMessage()
        );

        $_SESSION["msg"] =
            "Não foi possível realizar o pedido.";

        $_SESSION["status"] = "danger";
    }

    header("Location: index.php");
    exit;
}
