<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>CRUD - Controle de Carros</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" href="icon.png" type="image/png">
</head>

<body>
    <div class="container">
        <i class="fas fa-car icon"></i>
        <h1>Consulta de Carros</h1>
        <form method="post">
            <div class="form__group field">
                <input type="text" class="form__field" placeholder="Placa" id="placa" name="placa">
                <label for="placa" class="form__label">Placa</label>
            </div>
            <br>
            <input type="submit" name="consultar" value="Consultar" class="btn-submit">
            <input type="submit" name="alterarCarro" value="Alterar Carro" class="btn-submit" hidden>
            <input type="submit" name="excluirCarro" value="Excluir Carro" class="btn-submit" hidden>
            <input type="hidden" id="carroSelecionado" name="carroSelecionado" value="">
        </form>
        <?php
        include("bd.php");

        if ($_SERVER["REQUEST_METHOD"] === 'POST') {
            try {
                if (isset($_POST["consultar"])) {
                    $stmt = consultar();
                    echo "<form method='post'><table border='1px'>";
                    echo "<tr><th></th><th>Placa</th><th>Marca</th><th>Modelo</th><th>Quilometragem</th><th>Imagem</th></tr>";

                    while ($row = $stmt->fetch()) {
                        echo "<tr>";
                        echo "<td><input type='radio' name='Placa' value='" . $row['placa'] . "' onclick=\"document.getElementById('carroSelecionado').value = '" . $row['placa'] . "'; document.querySelector('input[name=alterarCarro]').removeAttribute('hidden');\"></td>";
                        echo "<td>" . $row['placa'] . "</td>";
                        echo "<td>" . $row['marca'] . "</td>";
                        echo "<td>" . $row['modelo'] . "</td>";
                        echo "<td>" . $row['quilometragem'] . "</td>";
                        echo "<td><img src='" . $row['imagem'] . "' height='100'></td>";
                        echo "</tr>";
                    }

                    echo "</table><br>";

                    echo "<script>";
                    echo "document.querySelector('input[name=excluirCarro]').removeAttribute('hidden');";
                    echo "</script>";
                } elseif (isset($_POST["excluirCarro"])) {
                    $placa = $_POST["carroSelecionado"];
                    excluir($placa);
                } elseif (isset($_POST["alterarCarro"])) {
                    $placa = $_POST["carroSelecionado"];
                    header("Location: altera.php?placa=" . urlencode($placa));
                    exit();
                }

            } catch (PDOException $e) {
                echo 'Error: ' . $e->getMessage();
            }
        }
        ?>
    </div>
</body>

</html>