<?php

error_reporting(E_ALL);
require_once "./connect/connect.php";

if (!isset($_GET['page'])) $page = 1;
else $page = mysqli_real_escape_string($connect, trim($_GET['page']));
if (ctype_digit($page) === false) $page = 1;
$active = "active";
$count_query = $connect->query("SELECT COUNT(*) FROM $active");
$count_array = $count_query->fetch_array(MYSQLI_NUM);
$count = $count_array[0];
$limit = 5;
$start = ($page * $limit) - $limit;
$length = ceil($count / $limit);

if (isset($_GET['del'])) {
    $del = $_GET['del'];
    $query = $connect->query("DELETE FROM `active` WHERE id=$del");
}

if ((int)$page > $length) $start = 0;
$query = $connect->query("SELECT * FROM `active` ORDER BY `date` DESC LIMIT $start, $limit");



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <title>Активы</title>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">№</th>
                            <th scope="col">Актив</th>
                            <th scope="col">Сумма актива</th>
                            <th scope="col">Рост актива %</th>
                            <th scope="col">Дата</th>
                            <th scope="col">Редактировать</th>
                            <th scope="col">Удалить</th>
                            
                        </tr>
                    </thead>
                    <?php while ($res = mysqli_fetch_assoc($query)) : ?>
                    <tbody>
                        
                        <tr>
                                <th><?= $res['id'] ?></th>
                                <td><?= $res['title'] ?></td>
                                <td><?= $res['sum'] ?></td>
                                <td><?= $res['interest'] ?></td>
                                <td><?= $res['date'] ?></td>
                                <td><a button type="button" class="btn btn-success" href="update.php?id=<?= $res['id']; ?>">Редактировать</a></td>
                                <td><a button type="button" class="btn btn-danger" href="?del=<?= $res['id']; ?>">Удалить</a></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <main class="mt-5 container">
    <div class="text-center">
        <span id="errorSpan" class="alert alert-danger" style="display:none;bottom:15px"></span>
        <h1 class="text-center mt-3">Добавить актив</h1>
    </div>
    <form class="mt-2">
        <input type="text" name="title" id="title" placeholder="Введите актив" class="form-control mt-2">
        <input type="text" name="sum" id="sum" placeholder="Введите сумму" class="form-control mt-2">
        <input type="text" name="interest" id="interest" placeholder="Введите %" class="form-control mt-2">        
        <button class="btn btn-outline-primary mt-3" type="button" id="addBtn">Добавить</button>
    </form>
</main>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $("#addBtn").click(function () {
        const title = $('#title').val()
        const sum = $('#sum').val()
        const interest = $('#interest').val()

        $.ajax({
            url: '/code/add.php',
            type: 'POST',
            cache: false,
            data: {title, sum, interest},
            dataType: 'html',
            success: function (data) {
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
<?php

function Pagination($length, $page)


{
    if ($length < 5) foreach (range(1, $length) as $p) echo  '<a href="index.php?page=' . $p . ' "> ' . $p . '</a>';

    if ($length > 4 && $page < 5) foreach (range(1, 5) as $p) echo '<a href="index.php?page=' . $p . ' "> ' . $p . '</a>';

    if ($length - 5 < 5 && $page > 5 && $length - 5 > 0) foreach (range($length - 4, $length) as $p) echo '<a href="index.php?page=' . $p . ' "> ' . $p . '</a>';

    if ($length > 4 && $length - 5 < 5 && $page == 5) foreach (range($page - 2, $length) as $p) echo '<a href="index.php?page=' . $p . ' "> ' . $p . '</a>';

    if ($length > 4 && $length - 5 > 5 && $page >= 5 && $page <= $length - 4) foreach (range($page - 2, $page + 2) as $p) echo '<a href="index.php?page=' . $p . ' "> ' . $p . '</a>';

    if ($length > 4 && $length - 5 > 5 && $page > $length - 4) foreach (range($length - 4, $length) as $p) echo '<a href="index.php?page=' . $p . ' "> ' . $p . '</a>';
}
?>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-2" style="margin-left: 380px">
                            <?php Pagination($length, $page); ?>
                        </div>
                    </div>
</div>

</body>

</html>