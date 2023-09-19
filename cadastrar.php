<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>CRUD - Controle de Carros</title>
    <link rel="stylesheet" href="style.css">
    <script class="jsbin" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
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
    <div class="container">
        <i class="fas fa-car icon"></i>
        <h1>Cadastro de Carros</h1>
        <form method="post" class="car-form" enctype="multipart/form-data">
            <div class="form-group">
                <label for="placa">Placa:</label><br>
                <input type="text" id="placa" name="placa">
            </div>
            <br>
            <div class="form-group">
                <label for="marca">Marca:</label><br>
                <input type="text" id="marca" name="marca">
            </div>
            <br>
            <div class="form-group">
                <label for="modelo">Modelo:</label><br>
                <input type="text" id="modelo" name="modelo">
            </div>
            <br>
            <div class="form-group">
                <label for="quilometragem">Quilometragem:</label><br>
                <input type="text" id="quilometragem" name="quilometragem">
            </div>
            <br>
            <div class="form-group">
                <label for="imagem">Imagem:</label>
                <div class="image-upload-wrap">
                    <input class="file-upload-input" type='file' onchange="readURL(this);" accept="image/*" name="imagem"/>
                    <div class="drag-text">
                        <h4>Arraste e solte ou adicione uma imagem</h4>
                    </div>
                </div>
                <div class="file-upload-content">
                    <img class="file-upload-image" src="#" alt="your image" />
                    <div class="image-title-wrap">
                        <button type="button" onclick="removeUpload()" class="remove-image">Remove <span
                                class="image-title">Uploaded Image</span></button>
                    </div>
                </div>
            </div>
            <br>
            <input type="submit" value="Cadastrar" class="btn-submit">
        </form>
        <?php
        include("bd.php");

        if ($_SERVER["REQUEST_METHOD"] === 'POST') {
            // Validar os campos obrigatórios
            $placa = $_POST["placa"];
            $marca = $_POST["marca"];
            $modelo = $_POST["modelo"];
            $quilometragem = $_POST["quilometragem"];

            if (empty($placa) || empty($marca)) {
                echo "<span id='warning'>Placa e marca são obrigatórios!</span>";
            } else {
                $imagem_nome = $_FILES["imagem"]["name"]; // Obtenha o nome original da imagem
                $extensao = pathinfo($imagem_nome, PATHINFO_EXTENSION); // Obtenha a extensão do arquivo
        
                // Renomeie a imagem com a placa e a extensão
                $novo_nome_imagem = "archive/{$placa}." . $extensao;

                // Mova a imagem para a pasta "archive" e verifique se a operação foi bem-sucedida
                if (move_uploaded_file($_FILES["imagem"]["tmp_name"], $novo_nome_imagem)) {
                    cadastrar($placa, $marca, $modelo, $quilometragem, $novo_nome_imagem);
                } else {
                    echo "<span id='error'>Falha ao enviar a imagem!</span><br>";
                }
            }

        }
        ?>

    </div>
</body>

</html>