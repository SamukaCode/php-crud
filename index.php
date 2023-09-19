<?php
include('bd.php');

$totalCarros = contarCarros();
$totalFiat = contarCarrosPorMarca('Fiat'); 
$totalHonda = contarCarrosPorMarca('Honda'); 
$totalChevrolet = contarCarrosPorMarca('Chevrolet'); 
$totalVolkswagen = contarCarrosPorMarca('Volkswagen');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Controle de Carros</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
</head>

<body>

    <div class="container">
        <i class="fas fa-car icon"></i>
        <h1>Controle de Carros</h1>
        <h2>Gerencie seus veículos de forma eficiente</h2>
        <form>
            <input type="button" value="Cadastrar" onclick="window.open('cadastrar.php', '_top');">
            <br><br>
            <input type="button" value="Consultar" onclick="window.open('consultar.php', '_top');">
        </form>
    </div>

    <div class="info-container">
        <div class="info-item">
            <label>Total de Carros Cadastrados:</label>
            <span>
                <?php echo $totalCarros; ?>
            </span>
        </div>
    </div>
    <div class="info-container">
        <div class="info-item">
            <label>Total de Carros da Fiat:</label>
            <span>
                <?php echo $totalFiat; ?>
            </span>
        </div>
        <div class="info-item">
            <label>Total de Carros da Honda:</label>
            <span>
              <?php echo $totalHonda; ?>
            </span>
        </div>
    </div>
    <div class="info-container">
        <div class="info-item">
            <label>Total de Carros da Chevrolet:</label>
            <span>
                 <?php echo $totalChevrolet; ?>
            </span>
        </div>
        <div class="info-item">
            <label>Total de Carros da Volkswagen:</label>
            <span>
                <?php echo $totalVolkswagen; ?>
            </span>
        </div>
    </div>

</body>
</html>