<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$msg = $_SESSION["msg"] ?? "";
$status = $_SESSION["status"] ?? "";

unset(
    $_SESSION["msg"],
    $_SESSION["status"]
);

$currentPage = basename($_SERVER["PHP_SELF"]);

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="description"
        content="Sistema de pedidos e gerenciamento de pizzas."
    >

    <title>Pizzaria do João 🍕</title>

    <!-- Bootstrap -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
    >

    <!-- Font Awesome -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
    >

    <!-- CSS da aplicação -->
    <link
        rel="stylesheet"
        href="styles.css"
    >

</head>

<body>

<header>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">

        <div class="container">

            <a
                class="navbar-brand"
                href="index.php"
            >
                🍕 Pizzaria do João
            </a>

            <button
                class="navbar-toggler"
                type="button"
                data-toggle="collapse"
                data-target="#navbarMenu"
                aria-controls="navbarMenu"
                aria-expanded="false"
                aria-label="Abrir menu"
            >
                <span class="navbar-toggler-icon"></span>
            </button>

            <div
                class="collapse navbar-collapse"
                id="navbarMenu"
            >

                <ul class="navbar-nav ml-auto">

                    <li class="nav-item <?= $currentPage === "index.php" ? "active" : "" ?>">

                        <a
                            class="nav-link"
                            href="index.php"
                        >
                            <i class="fas fa-pizza-slice"></i>
                            Fazer pedido
                        </a>

                    </li>

                    <li class="nav-item <?= $currentPage === "dashboard.php" ? "active" : "" ?>">

                        <a
                            class="nav-link"
                            href="dashboard.php"
                        >
                            <i class="fas fa-clipboard-list"></i>
                            Gerenciar pedidos
                        </a>

                    </li>

                </ul>

            </div>

        </div>

    </nav>

</header>

<?php if (!empty($msg)): ?>

    <div class="container mt-3">

        <div
            class="alert alert-<?= htmlspecialchars($status) ?> alert-dismissible fade show"
            role="alert"
        >

            <?= htmlspecialchars($msg) ?>

            <button
                type="button"
                class="close"
                data-dismiss="alert"
                aria-label="Fechar"
            >
                <span aria-hidden="true">&times;</span>
            </button>

        </div>

    </div>

<?php endif; ?>
