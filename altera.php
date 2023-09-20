<?php
include("bd.php");

if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    if (isset($_POST['atualizar'])) {
        $placa = $_POST['placa'];
        $novoMarca = $_POST['novoMarca'];
        $novoModelo = $_POST['novoModelo'];
        $novoKilometragem = $_POST['novoKilometragem'];

        $stmt = consultarPorPlaca($placa);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (isset($_FILES['novaImagem']) && $_FILES['novaImagem']['tmp_name']) {
            $novaImagemNome = $placa . '.' . pathinfo($_FILES['novaImagem']['name'], PATHINFO_EXTENSION);
            $novaImagemTemp = $_FILES['novaImagem']['tmp_name'];


            $diretorioImagens = 'archives/';
            $caminhoNovaImagem = $diretorioImagens . $novaImagemNome;

            if ($row && isset($row['imagem'])) {
                $fotoAnterior = $diretorioImagens . $placa . '.' . pathinfo($row['imagem'], PATHINFO_EXTENSION);
                if (file_exists($fotoAnterior)) {
                    unlink($fotoAnterior);
                }
            }

            move_uploaded_file($novaImagemTemp, $caminhoNovaImagem);

            alterar($placa, $novoMarca, $novoModelo, $novoKilometragem, $caminhoNovaImagem);
        } else {
            alterar($placa, $novoMarca, $novoModelo, $novoKilometragem, null);
        }
    }
}



$placa = $_GET['placa'];

$stmt = consultarPorPlaca($placa);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>CRUD - Controle de Carros</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script class="jsbin" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <link rel="icon" href="icon.png" type="image/png">


</head>

<body>

    <div class="container">
        <i class="fas fa-car icon"></i>
        <h1>Edição de Carros</h1>

        <!-- Formulário de Edição -->
        <form method="post" enctype="multipart/form-data">
            <div class="form__group field">
                <label class="form__label" for="placa">Placa:</label>
                <input class="form__field" type="text" id="placa" name="placa"
                    value="<?php echo htmlspecialchars($row['placa']); ?>" readonly>
            </div><br>

            <div class="form__group field">
                <label class="form__label" for="novoMarca">Nova Marca:</label>
                <input class="form__field" type="text" id="novoMarca" name="novoMarca"
                    value="<?php echo htmlspecialchars($row['marca']); ?>" required>
            </div><br>

            <div class="form__group field">
                <label class="form__label" for="novoModelo">Novo Modelo:</label>
                <input class="form__field" type="text" id="novoModelo" name="novoModelo"
                    value="<?php echo htmlspecialchars($row['modelo']); ?>" required>
            </div><br>

            <div class="form__group field">
                <label class="form__label" for="novoKilometragem">Nova Quilometragem:</label>
                <input class="form__field" type="number" id="novoKilometragem" name="novoKilometragem"
                    value="<?php echo htmlspecialchars($row['quilometragem']); ?>" required>
            </div><br>

            <div class="form-group">
                <label for="imagem" class="">Imagem:</label>
                <div class="image-upload-wrap">
                    <input class="file-upload-input" type='file' onchange="readURL(this);" accept="image/*"
                        name="novaImagem" />
                    <div class="drag-text">
                        <h4>Arraste e solte ou adicione uma NOVA imagem</h4>
                    </div>
                </div>
                <div class="file-upload-content">
                    <img class="file-upload-image" src="#" alt="your image" />
                    <div class="image-title-wrap">
                        <button type="button" onclick="removeUpload()" class="remove-image">Remover <span
                                class="image-title">Imagem adicionada</span></button>
                    </div>
                </div><br>
            </div>

            <input class="form__field" type="submit" name="atualizar" value="Atualizar" class="btn-submit">
        </form>
    </div>
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {

                var reader = new FileReader();

                reader.onload = function (e) {
                    $('.image-upload-wrap').hide();

                    $('.file-upload-image').attr('src', e.target.result);
                    $('.file-upload-content').show();

                    $('.image-title').html(input.files[0].name);
                };

                reader.readAsDataURL(input.files[0]);

            } else {
                removeUpload();
            }
        }

        function removeUpload() {
            $('.file-upload-input').replaceWith($('.file-upload-input').clone());
            $('.file-upload-content').hide();
            $('.image-upload-wrap').show();
        }
        $('.image-upload-wrap').bind('dragover', function () {
            $('.image-upload-wrap').addClass('image-dropping');
        });
        $('.image-upload-wrap').bind('dragleave', function () {
            $('.image-upload-wrap').removeClass('image-dropping');
        });
    </script>
</body>

</html>