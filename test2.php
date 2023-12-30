<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<?php
$list=array(1, 2, 3, 4, 5);
?>
<!-- var_dump gibt Inhalt einer Variablen aus. Kein sinnvolles HTML. -->
<!-- foreach für Interieren und Ausgeben der Liste -->
<body>
<?php
foreach($list as $value) {
?>
<p><?= $value; ?></p>
<?php
}
?>
</body>
<!-- ... -->
</body>
</html>