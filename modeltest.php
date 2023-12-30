<?php require("start.php");
$user = new Model\User("Test");
$json = json_encode($user);
echo $json . "<br>";
$jsonObject = json_decode($json);
$newUser = Model\User::fromJson($jsonObject);
echo "<br>" . "before var_dump" . "<br>";
var_dump($newUser);

// json_decode(json_encode($newUser)); wird natürlich KEIN Objekt der Klasse User werden, 
// es wird stattdessen ein object der Klasse stdClass (vergl. Object-Klasse in Java)
// $jsonObject = json_decode($json);
// $newUser = Model\User::fromJson($jsonObject);

// so würde es gehen
?>
