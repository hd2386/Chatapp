<?php
namespace Model;
use JsonSerializable;
class User implements JsonSerializable {
    private $username;
    private $firstname;
    private $lastname;
    private $drinks;
    private $comment;
    private $layout;


public function __construct($username = null) {
    $this->username = $username;
}

function getUsername() {
    return $this->username;
}

public function setFirstname($firstname) {
    $this->firstname = $firstname;
}

function getFirstname() {
    return $this->firstname;
}

public function setLastname($lastname) {
    $this->lastname = $lastname;
}

function getLastname() {
    return $this->lastname;
}

public function setDrinks($drinks) {
    $this->drinks = $drinks;
}

function getDrinks() {
    return $this->drinks;
}

public function setComment($comment) {
    $this->comment = $comment;
}

function getComment() {
    return $this->comment;
}

public function setLayout($layout) {
    $this->layout = $layout;
}

function getLayout() {
    return $this->layout;
}

public function jsonSerialize(): mixed {
        return get_object_vars($this);
    }

public static function fromJSON($data){
    $user = new User();

    foreach($data as $key =>$value){
        if(property_exists($user,$key)){
            $user->{$key}=$value;
        }
    }
    return $user;
}

/*public static function fromJSON($data): User {
        $user = new User();
        foreach ($data as $key => $value) {
            $user->{$key} = $value;
        } 
    return $user;
    }*/

}
