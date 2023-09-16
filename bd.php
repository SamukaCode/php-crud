<?php

    function conectarBD() {
        $pdo = new PDO("mysql:host=localhost;dbname=simone;charset=utf8", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }

    function cadastrar($placa, $marca, $modelo, $kilometragem, $imagem) {
        try {
            $pdo = conectarBD();
            $rows = verificarCadastro($placa, $pdo);

            if ($rows <= 0) {
                $stmt = $pdo->prepare("insert into carros (placa, marca, modelo, kilometragem, imagem) values(:placa, :marca, :modelo, :kilometragem, :imagem )");
                $stmt->bindParam(':placa', $placa);
                $stmt->bindParam(':marca', $marca);
                $stmt->bindParam(':modelo', $modelo);
                $stmt->bindParam(':kilometragem', $kilometragem);
                $stmt->bindParam(':imagem', $imagem);
                $stmt->execute();
                echo "<span id='sucess'>Carro Cadastrado!</span>";
            } else {
                echo "<span id='error'>Placa já existente!</span>";
            }
        } catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }


    function verificarCadastro($placa, $pdo) {
        //verificando se o RA informado já existe no BD para não dar exception
        $stmt = $pdo->prepare("select * from carros where placa = :placa");
        $stmt->bindParam(':placa', $placa);
        $stmt->execute();

        $rows = $stmt->rowCount();
        return $rows;
    }

    function consultar() {
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

    function buscarEdicao($placa) {
        $pdo = conectarBD();
        $stmt = $pdo->prepare('select * from carros where placa = :placa');
        $stmt->bindParam(':placa', $placa);
        $stmt->execute();
        return $stmt;
    }

    function alterar($placa, $novoMarca, $novoModelo, $novoKilometragem, $novoImagem) {
        try {
            $pdo = conectarBD();
            $stmt = $pdo->prepare('UPDATE carros SET marca = :novoMarca, modelo = :novoModelo, kilometragem = :novoKilometragem, imagem = :novoImagem WHERE placa = :placa');
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

    function excluir($placa) {
        try {
            $pdo = conectarBD();
            $stmt = $pdo->prepare('DELETE FROM carros WHERE placa = :placa');
            $stmt->bindParam(':placa', $placa);
            $stmt->execute();

            echo $stmt->rowCount() . " Carro da placa: $placa removido!";

        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    ?>