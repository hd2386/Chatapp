<?php
require("start.php");
# Helper-Link to see Friends and so on
# https://online-lectures-cs.thi.de/chat/helper/5a4b8b37-601f-4b73-8479-73124952c25f#Jerry


$service = new Utils\BackendService(CHAT_SERVER_URL, CHAT_SERVER_ID);


# var_dump($service->login("Test123", "12345678"));
# var_dump($service->loadUser("Test123"));

# echo " \n test(): ";
echo "<br> <br>";
# var_dump($service->test());
echo "<br> <br>";
echo " login: ";
var_dump($service->login("Tom", "12345678"));
echo "<br> register: ";
#var_dump($service->register("Jana", "asdfghjkf"));
var_dump($_SESSION);  
echo "<br>  loadUser: ";
var_dump($service->loadUser("Tom"));
echo "<br> saveUser: ";
var_dump($service->saveUser("Tom"));
echo "<br> loadMsg: ";
var_dump($service->loadMessages("Jerry"));
echo "<br> loadFriends: ";
var_dump($service->loadFriends());
echo "<br> loadUsers: ";
var_dump($service->loadUsers());
echo "<br> sendMsg: ";
var_dump($service->sendMessage(array("message" => "Hey!", "to" => "Jerry")));
echo "<br> friendRequest: ";
var_dump($service->friendRequest("Truck"));
echo "<br> friendAccept: ";
var_dump($service->friendAccept("Truck"));
echo "<br> friendDismiss: ";
var_dump($service->friendDismiss("Trick"));
echo "<br> removeFriend: ";
var_dump($service->removeFriend("Tick")());
echo "<br> getUnread: ";
var_dump($service->getUnread());


?>