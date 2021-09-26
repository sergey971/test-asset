<?php

error_reporting(E_ALL);
require_once "./connect/connect.php";

?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактирование</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
</head>

<body>
    <main class="mt-5 container">
        <div class="text-center">
            <span id="errorSpan" class="alert alert-danger" style="display:none;bottom:15px"></span>
            <h1 class="text-center mt-3">Редактирование актива</h1>
        </div>
        <?php
        $id = $_GET['id'];
        $query = $connect->query("SELECT * FROM `active` WHERE `id` = '$id'");
        while ($res = mysqli_fetch_assoc($query)) :
        ?>
            <form class="mt-4">
                <input type="hidden" id="id" name="id" value="<?= $res['id'] ?>">
                <div class="col-xs-3">
                    <input type="text" name="title" id="title" placeholder="Введите актив" class="form-control mt-2" value="<?= $res['title']; ?>">
                </div>
                
                <input type="text" name="sum" id="sum" placeholder="Введите сумму" class="form-control mt-2" value="<?= $res['sum']; ?>">
                <input type="text" name="interest" id="interest" placeholder="Введите %" class="form-control mt-2" value="<?= $res['interest']; ?>">
                <button class="btn btn-outline-primary mt-3" type="button" id="editBtn">Сохранить</button>
            </form>
        <?php
        endwhile;
        ?>
    </main>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $("#editBtn").click(function() {
            const id = $('#id').val()
            const title = $('#title').val()
            const sum = $('#sum').val()
            const interest = $('#interest').val()

            $.ajax({
                url: '/code/update.php',
                type: 'GET',
                cache: false,
                data: {
                    id,
                    title,
                    sum,
                    interest
                },
                dataType: 'html',
                success: function(data) {
                    if (data == 'ready') {
                        $('#errorSpan').hide()
                        location.href = '/'
                    } else {
                        $('#errorSpan').show()
                        $('#errorSpan').text(data)
                    }
                }
            })
        })
    </script>
</body>

</html>