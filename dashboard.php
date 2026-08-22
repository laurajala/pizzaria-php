<?php

include_once("Header.php");
include_once("orders.php");

?>

<main id="main-container">
  <div class="container">
    <div class="row">

      <div class="col-md-12">
        <h2>Gerenciar pedidos</h2>
      </div>

      <div class="col-md-12 table-container">

        <?php if (empty($pizzas)): ?>

          <div class="alert alert-info">
            Nenhum pedido encontrado.
          </div>

        <?php else: ?>

          <div class="table-responsive">

            <table class="table">

              <thead>
                <tr>
                  <th>Pedido #</th>
                  <th>Borda</th>
                  <th>Massa</th>
                  <th>Sabores</th>
                  <th>Status</th>
                  <th>Ações</th>
                </tr>
              </thead>

              <tbody>

                <?php foreach ($pizzas as $pizza): ?>

                  <tr>

                    <td>
                      <?= (int) $pizza["pedido_id"] ?>
                    </td>

                    <td>
                      <?= htmlspecialchars($pizza["borda"]) ?>
                    </td>

                    <td>
                      <?= htmlspecialchars($pizza["massa"]) ?>
                    </td>

                    <td>
                      <ul class="mb-0">

                        <?php foreach ($pizza["sabores"] as $sabor): ?>

                          <li>
                            <?= htmlspecialchars($sabor) ?>
                          </li>

                        <?php endforeach; ?>

                      </ul>
                    </td>

                    <td>

                      <form
                        action="orders.php"
                        method="POST"
                        class="form-group update-form"
                      >

                        <input
                          type="hidden"
                          name="type"
                          value="update"
                        >

                        <input
                          type="hidden"
                          name="id"
                          value="<?= (int) $pizza["id"] ?>"
                        >

                        <select
                          name="status"
                          class="form-control status-input"
                        >

                          <?php foreach ($status as $s): ?>

                            <option
                              value="<?= (int) $s["id"] ?>"
                              <?= ((int) $s["id"] === (int) $pizza["status"]) ? "selected" : "" ?>
                            >
                              <?= htmlspecialchars($s["tipo"]) ?>
                            </option>

                          <?php endforeach; ?>

                        </select>

                        <button
                          type="submit"
                          class="update-btn"
                          title="Atualizar status"
                          aria-label="Atualizar status do pedido"
                        >
                          <i class="fas fa-sync-alt"></i>
                        </button>

                      </form>

                    </td>

                    <td>

                      <form
                        action="orders.php"
                        method="POST"
                        onsubmit="return confirm('Deseja realmente remover este pedido?');"
                      >

                        <input
                          type="hidden"
                          name="type"
                          value="delete"
                        >

                        <input
                          type="hidden"
                          name="id"
                          value="<?= (int) $pizza["id"] ?>"
                        >

                        <button
                          type="submit"
                          class="delete-btn"
                          title="Excluir pedido"
                          aria-label="Excluir pedido"
                        >
                          <i class="fas fa-times"></i>
                        </button>

                      </form>

                    </td>

                  </tr>

                <?php endforeach; ?>

              </tbody>

            </table>

          </div>

        <?php endif; ?>

      </div>

    </div>
  </div>
</main>

<?php include_once("footer.php"); ?>
