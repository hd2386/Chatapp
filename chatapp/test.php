<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<?php
if(isset($_POST["test"])) {
    if(!empty($_POST["test"])) {
    echo "Wert: " . $_POST["test"];
    } else {
    echo "Kein Wert!";
    }
    } else {
    echo "Kein Parameter übergeben";
    }
?>

</body>
</html>

<script>


/*
für
< ?php echo $_GET["test"]; ?>

Aufruf von: http://localhost/chatapp/test.php 
ergibt: Warning: Undefined array key "test" in C:\xampp\htdocs\chatapp\test.php on line 11

Aufruf von: http://localhost/chatapp/test.php?test=
ergibt:
(leere Seite, keine Fehlermeldung)

http://localhost/chatapp/test.php?test=123
ergibt: 123 auf der HTML Seite
*/


</script>