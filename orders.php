<?php

session_start();

include_once("conn.php");

$method = $_SERVER["REQUEST_METHOD"];

if ($method === "GET") {

    $stmt = $conn->query("
        SELECT
            p.id AS pedido_id,
            p.pizza_id,
            p.status_id,
            b.tipo AS borda,
            m.tipo AS massa,
            s.nome AS sabor
        FROM pedidos p
        INNER JOIN pizzas pi
            ON pi.id = p.pizza_id
        INNER JOIN bordas b
            ON b.id = pi.borda_id
        INNER JOIN massas m
            ON m.id = pi.massa_id
        LEFT JOIN pizza_sabor ps
            ON ps.pizza_id = pi.id
        LEFT JOIN sabores s
            ON s.id = ps.sabor_id
        ORDER BY p.id DESC
    ");

    $resultados = $stmt->fetchAll();

    $pizzas = [];

    foreach ($resultados as $linha) {

        $pizzaId = (int) $linha["pizza_id"];

        if (!isset($pizzas[$pizzaId])) {

            $pizzas[$pizzaId] = [
                "id" => $pizzaId,
                "pedido_id" => (int) $linha["pedido_id"],
                "borda" => $linha["borda"],
                "massa" => $linha["massa"],
                "sabores" => [],
                "status" => (int) $linha["status_id"]
            ];
        }

        if (!empty($linha["sabor"])) {
            $pizzas[$pizzaId]["sabores"][] = $linha["sabor"];
        }
    }

    $pizzas = array_values($pizzas);

    $status = $conn
        ->query("SELECT * FROM status")
        ->fetchAll();
}

if ($method === "POST") {

    $type = $_POST["type"] ?? null;

    $id = filter_input(
        INPUT_POST,
        "id",
        FILTER_VALIDATE_INT
    );

    if (!$id) {

        $_SESSION["msg"] = "Pedido inválido.";
        $_SESSION["status"] = "danger";

        header("Location: dashboard.php");
        exit;
    }

    if ($type === "delete") {

        try {

            $conn->beginTransaction();

            $stmt = $conn->prepare("
                DELETE FROM pedidos
                WHERE pizza_id = :id
            ");

            $stmt->execute([
                ":id" => $id
            ]);

            $stmt = $conn->prepare("
                DELETE FROM pizza_sabor
                WHERE pizza_id = :id
            ");

            $stmt->execute([
                ":id" => $id
            ]);

            $stmt = $conn->prepare("
                DELETE FROM pizzas
                WHERE id = :id
            ");

            $stmt->execute([
                ":id" => $id
            ]);

            $conn->commit();

            $_SESSION["msg"] = "Pedido removido com sucesso!";
            $_SESSION["status"] = "success";

        } catch (PDOException $e) {

            if ($conn->inTransaction()) {
                $conn->rollBack();
            }

            error_log(
                "Erro ao remover pedido: "
                . $e->getMessage()
            );

            $_SESSION["msg"] =
                "Não foi possível remover o pedido.";

            $_SESSION["status"] = "danger";
        }
    }

    if ($type === "update") {

        $statusId = filter_input(
            INPUT_POST,
            "status",
            FILTER_VALIDATE_INT
        );

        if (!$statusId) {

            $_SESSION["msg"] = "Status inválido.";
            $_SESSION["status"] = "warning";

            header("Location: dashboard.php");
            exit;
        }

        $stmt = $conn->prepare("
            UPDATE pedidos
            SET status_id = :status
            WHERE pizza_id = :id
        ");

        $stmt->execute([
            ":status" => $statusId,
            ":id" => $id
        ]);

        $_SESSION["msg"] =
            "Pedido atualizado com sucesso!";

        $_SESSION["status"] = "success";
    }

    header("Location: dashboard.php");
    exit;
}
