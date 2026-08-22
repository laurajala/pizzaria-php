<?php

include_once("Header.php");
include_once("pizza.php");

?>

<div id="main-banner">
  <h1>Faça seu Pedido</h1>
</div>

<main id="main-container">
  <div class="container">
    <div class="row">

      <div class="col-md-12">

        <h2>Monte sua pizza</h2>

        <form
          action="pizza.php"
          method="POST"
          id="pizza-form"
        >

          <div class="form-group">

            <label for="borda">
              Borda
            </label>

            <select
              name="borda"
              id="borda"
              class="form-control"
              required
            >

              <option value="">
                Selecione a borda
              </option>

              <?php foreach ($bordas as $borda): ?>

                <option value="<?= (int) $borda["id"] ?>">
                  <?= htmlspecialchars($borda["tipo"]) ?>
                </option>

              <?php endforeach; ?>

            </select>

          </div>

          <div class="form-group">

            <label for="massa">
              Massa
            </label>

            <select
              name="massa"
              id="massa"
              class="form-control"
              required
            >

              <option value="">
                Selecione a massa
              </option>

              <?php foreach ($massas as $massa): ?>

                <option value="<?= (int) $massa["id"] ?>">
                  <?= htmlspecialchars($massa["tipo"]) ?>
                </option>

              <?php endforeach; ?>

            </select>

          </div>

          <div class="form-group">

            <label for="sabores">
              Sabores
              <small>(máximo 3)</small>
            </label>

            <select
              multiple
              name="sabores[]"
              id="sabores"
              class="form-control"
              required
            >

              <?php foreach ($sabores as $sabor): ?>

                <option value="<?= (int) $sabor["id"] ?>">
                  <?= htmlspecialchars($sabor["nome"]) ?>
                </option>

              <?php endforeach; ?>

            </select>

            <small class="form-text text-muted">
              Selecione até 3 sabores.
            </small>

          </div>

          <div class="form-group">

            <button
              type="submit"
              class="btn btn-primary"
            >
              <i class="fas fa-shopping-cart"></i>
              Fazer Pedido
            </button>

          </div>

        </form>

      </div>

    </div>
  </div>
</main>

<?php include_once("footer.php"); ?>
