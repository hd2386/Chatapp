<?php 
namespace Model;
use JsonSerializable;
class Friend implements JsonSerializable{

private $username;
private $status;

public function __construct($username = null) {
    $this->username = $username;
}

public function getUsername() {
    return $this->username;
}

public function getStatus() {
    return $this->status;
}

public function setAccepted() {
    $this->status = "accepted";
}

public function setDismissed() {
    $this->status = "dismissed";
}

#[\ReturnTypeWillChange] 
public function jsonSerialize() {
        return [
            'username' => $this->getUsername(),
            'status' => $this->getStatus()
        ];
}

/*public function jsonSerialize() {
    return get_object_vars($this);
    }*/

public static function fromJSON($data) {
        $friend = new Friend();

        foreach ($data as $key => $value) {
            if (property_exists($friend, $key)) {
                $friend->{$key} = $value;
            }
        }
        return $friend;
}

/*public static function fromJSON($data): void {
        $user = new User("default");
        foreach ($data as $key => $value) {
            $user->{$key} = $value;
        }
    
}*/ 

}