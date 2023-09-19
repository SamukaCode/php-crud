<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CRUD - Controle de Carros</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <i class="fas fa-car icon"></i>
        <h1>Consulta de Carros</h1>
        <form method="post">
            <div class="form-group">
                <label for="placa">Placa:</label><br>
                <input type="text" id="placa" name="placa">
            </div>
            <br>
            <input type="submit" value="Consultar" class="btn-submit">
        </form>
        <?php
        include("bd.php");

        if ($_SERVER["REQUEST_METHOD"] === 'POST') {
            try {
                $stmt = consultar();

                echo "<form method='post'><table border='1px'>";
                echo "<tr><th></th><th>Placa</th><th>Marca</th><th>Modelo</th><th>Quilometragem</th><th>Imagem</th></tr>";

                while ($row = $stmt->fetch()) {
                    echo "<tr>";
                    echo "<td><input type='radio' name='Placa' value='" . $row['placa'] . "'></td>";
                    echo "<td>" . $row['placa'] . "</td>";
                    echo "<td>" . $row['marca'] . "</td>";
                    echo "<td>" . $row['modelo'] . "</td>";
                    echo "<td>" . $row['quilometragem'] . "</td>";
                    echo "<td><img src='" . $row['imagem'] . "' width='100' height='100'></td>";
                    echo "</tr>";
                }

                echo "</table><br>
             
             <button type='submit' formaction='excluir.php'>Excluir Carro</button>
             <button type='submit' formaction='editar.php'>Editar Carro</button>
             
             </form>";

            } catch (PDOException $e) {
                echo 'Error: ' . $e->getMessage();
            }
        }
        ?>
    </div>
</body>
</html>
