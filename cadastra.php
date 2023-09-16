<!-- faltando fazer select de RA já existentes que no cap 9 já fiz -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CRUD - Controle de alunos</title>

    <style>
        #sucess {
            color: green;
            font-weight: bold;
        }

        #error {
            color: red;
            font-weight: bold;
        }

        #warning {
            color: orange;
            font-weight: bold;
        }

    </style>

</head>

<body>

<a href="index.html">Home</a>
<hr>

<h2>Cadastro de Alunos</h2>
<div>
    <form method="post">

        RA:<br>
        <input type="text" size="10" name="ra"><br><br>

        Nome:<br>
        <input type="text" size="30" name="nome"><br><br>

        Curso:<br>
        <select name="curso">
            <option></option>
            <option value="Edificações">Edificações</option>
            <option value="Enfermagem">Enfermagem</option>
            <option value="GeoCart">Geodésia e Cartografia</option>
            <option value="Informática">Informática</option>
            <option value="Mecânica">Mecânica</option>
            <option value="Qualidade">Qualidade</option>
        </select><br><br>

        <input type="submit" value="Cadastrar">

        <hr>

    </form>
</div>

</body>
</html>

<?php
   include("bd.php");

    if ($_SERVER["REQUEST_METHOD"] === 'POST') {
        //inserindo dados
        $placa = $_POST["placa"];
        $marca = $_POST["marca"];
        $modelo = $_POST["modelo"];
        $kilometragem = $_POST["kilometragem"];
        $imagem = $_POST["imagem"];

        if ((trim($placa) == "") || (trim($marca) == "")) {
            echo "<span id='warning'>placa e marca são obrigatórios!</span>";
        } else {
            cadastrar($placa, $marca, $modelo, $kilometragem, $imagem);
        }
    }
?>