<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php
    $foo = 12455;
    if ($foo == 12345) {
        header("Location: login.php");
        exit();
    }?>
</head>


<!-- ... -->

<body>
    <p>Hallo, Welt!</p>
</body>
<!-- ... -->

</html>