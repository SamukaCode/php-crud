<?php

function conectarBD()
{
    $pdo = new PDO("mysql:host=143.106.241.3;dbname=cl201275;charset=utf8", "cl201275", "cl*28092005");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
}

function cadastrar($placa, $marca, $modelo, $quilometragem, $imagem)
{
    try {
        $pdo = conectarBD();
        $rows = verificarCadastro($placa, $pdo);

        if ($rows <= 0) {
            $extensao = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
            $imagemNome = "archives/" . $placa . "." . $extensao;

            move_uploaded_file($_FILES['imagem']['tmp_name'], $imagemNome);

            $stmt = $pdo->prepare("INSERT INTO carros (placa, marca, modelo, quilometragem, imagem) VALUES (:placa, :marca, :modelo, :quilometragem, :imagem)");
            $stmt->bindParam(':placa', $placa);
            $stmt->bindParam(':marca', $marca);
            $stmt->bindParam(':modelo', $modelo);
            $stmt->bindParam(':quilometragem', $quilometragem);
            $stmt->bindParam(':imagem', $imagemNome);
            $stmt->execute();
            echo "<span id='success'>Carro Cadastrado!</span>";
        } else {
            echo "<span id='error'>Placa já existente!</span><br>";
        }
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}


function verificarCadastro($placa, $pdo)
{
    $stmt = $pdo->prepare("select * from carros where placa = :placa");
    $stmt->bindParam(':placa', $placa);
    $stmt->execute();

    $rows = $stmt->rowCount();
    return $rows;
}

function consultar()
{
    $pdo = conectarBD();
    if (isset($_POST["placa"]) && ($_POST["placa"] != "")) {
        $placa = $_POST["placa"];
        $stmt = $pdo->prepare("select * from carros where placa= :placa");
        $stmt->bindParam(':placa', $placa);
    } else {
        $stmt = $pdo->prepare("select * from carros");
    }

    $stmt->execute();

    return $stmt;
}

function consultarPorPlaca($placa)
{
    try {
        $pdo = conectarBD();
        $stmt = $pdo->prepare("SELECT * FROM carros WHERE placa = :placa");
        $stmt->bindParam(':placa', $placa);
        $stmt->execute();
        return $stmt;
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
        return null;
    }
}

function alterar($placa, $novoMarca, $novoModelo, $novoKilometragem, $novoImagem)
{
    try {
        $pdo = conectarBD();
        $stmt = $pdo->prepare('UPDATE carros SET marca = :novoMarca, modelo = :novoModelo, quilometragem = :novoKilometragem, imagem = :novoImagem WHERE placa = :placa');
        $stmt->bindParam(':novoMarca', $novoMarca);
        $stmt->bindParam(':novoModelo', $novoModelo);
        $stmt->bindParam(':novoKilometragem', $novoKilometragem);
        $stmt->bindParam(':novoImagem', $novoImagem);
        $stmt->bindParam(':placa', $placa);
        $stmt->execute();

        echo "Os dados do carro $novoModelo da placa $placa foram alterados!";

    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}

function excluir($placa)
{
    try {
        $pdo = conectarBD();
        $stmt = $pdo->prepare('DELETE FROM carros WHERE placa = :placa');
        $stmt->bindParam(':placa', $placa);
        $stmt->execute();

        echo "<br>O carro de placa $placa foi removido!";

    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}

function contarCarrosPorMarca($marca)
{
    $conexao = conectarBD(); // Suponhamos que conectarBD() retorna uma conexão PDO válida
    $sql = "SELECT COUNT(*) as total FROM carros WHERE marca = :marca";
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':marca', $marca, PDO::PARAM_STR);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row['total'];
}

function contarCarros()
{
    $conexao = conectarBD(); // Suponhamos que conectarBD() retorna uma conexão PDO válida
    $sql = "SELECT COUNT(*) as total FROM carros";
    $stmt = $conexao->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row['total'];
}


?>