<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// Startet das PHP-Sitzungskonzept, wenn der Nutzer schon einmal
// die Website geöffnet hatte, ist er bekannt, andernfalls wird
// eine neue Session erzeugt.

// Zugriff $_SESSION, z.B. $_SESSION["example"] = "xyz";


session_start();


spl_autoload_register(function($class) {
include str_replace('\\', '/', $class) . '.php';
}); 

# API-Dokumentation:
# https://online-lectures-cs.thi.de/chat/full/8f8b40b3-453c-4029-84e3-fdb583b782b3 

define('CHAT_SERVER_URL', 'https://online-lectures-cs.thi.de/chat/');
define('CHAT_SERVER_ID', '8f8b40b3-453c-4029-84e3-fdb583b782b3'); # Ihre Collection ID

$service = new Utils\BackendService(CHAT_SERVER_URL, CHAT_SERVER_ID);

?>
 

