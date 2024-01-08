<?php
require("start.php");
use Utils\BackendService;
use Model\Friend;
use Model\User;

$backendService = new BackendService(CHAT_SERVER_URL, CHAT_SERVER_ID);
$friendsData = $backendService -> loadFriends($_SESSION["user"]);
$availableUsers = $backendService -> loadUsers($_SESSION["user"]); // das ist für die Auswahllist
$friends = []; //leere freundeliste
$users = [];  //leere userliste

if(!isset($_SESSION["user"]) || !$_SESSION["user"]){
    header("Location: login.php");
    die();
}
if (isset($_POST["action"])){ //aktionsziel von method=post
  if($_POST["action"] === "accept"){
    $requestedUsername = $_POST["requested-username"] ?? ""; 
    if(!empty($requestedUsername)) {  //if requested User nicht leer ist
      $backendService->friendAccept($requestedUsername);
    }
  }
  elseif ($_POST["action"] === "decline") {
    $requestedUsername = $_POST["requested-username"] ?? ''; //wenn die requested-username keine value hat dann leereszeichen"
    if (!empty($requestedUsername)) { 
      $backendService->friendDismiss($requestedUsername);
    }
  }
  elseif($_POST["action"] === "add-friend"){
    $friendUsername = $_POST["friend-username"] ?? "";
    if(!empty($friendUsername)){
      if($friendUsername!== $_SESSION["username"]){ //check if it sends to yourself.
        $backendService ->friendRequest($friendUsername);
      } else { 
        echo "You cant send a request to yourself";
      }
    } else {
      echo "Please give a username";
    }
  }
}
if(isset($_GET["action"]) && $_GET["action"] === "remove" && isset($_GET["friend"])){
  $friendUsername = $_GET["friend"];
  $backendService->removeFriend($friendUsername);
  header("Location: friends.php");
}

foreach ($availableUsers as $user){
  $user = User::fromJSON($availableUsers);
  $users[] = $user;
}

foreach ($friendsData as $friendData) {   //in diesem foreach Function: friendsData wird als Model/Friend Objekt erzeugt 
  $friend = Friend::fromJSON($friendData);  //sogenannte Friend wird von JSON zu einer php variable gespeichert
  $friends[] = $friend ; //freund wird zu leeres freundeliste ergänzt
}
//var_dump($friends);

?>

<html>
  <head>
    <meta charset="UTF-8" />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
      crossorigin="anonymous"
    />
    <title>Friends-List</title>
  </head>
  <body>
    <div class="container">
      <h1>Friends</h1>
      <a href="logout.php" id="logout" class="btn btn-secondary"> &lt Logout </a>
      <a href="settings.php" id="settings" class="btn btn-secondary"> Settings </a>
      <hr />
      <div class="container">
        <ul id="friends-list" class="list-group mt-3">
          <?php if(empty($friends)){?>
            <li class="list-group-item">No Friends Found</li> 
          <?php } ?>
          <?php foreach ($friends as $friend) { ?>
                <?php if ($friend->getStatus() === "accepted") { ?>
                  <?php 
                  $unreadCounts = $backendService->getUnread();
                  $friendUsername = $friend->getUsername();
                  $unreadCount = isset($unreadCounts->$friendUsername)?$unreadCounts->$friendUsername : 0;
                  ?>
                    <li class="list-group-item">
                    <div class= "d-flex justify-content-between align-items-center w-100">
                        <a class="me-3 text-decoration-none text-dark" href="chat.php?friend=<?= $friend-> getUsername() ?>"> 
                          <?= $friend->getUsername()?>
                        </a>
                        <span class="badge bg-primary rounded-pill"><?= $unreadCount ?></span>
                      </div>
                    </li>
                <?php } ?>
            <?php } ?>
          </ul>
      </div>
      <hr />
      <h2>New Requests</h2>
      <div>
        <ul id="new-request" class="list-group">
          <?php foreach ($friends as $friend) { ?>
                <?php if ($friend->getStatus() === 'requested') { ?>
                  <li class="list-group-item mb-1" data-bs-toggle="modal" data-bs-target="#friendRequestModal-<?= $friend->getUsername() ?>" style="cursor: pointer;">
                    New Request from: <?= $friend->getUsername() ?>
                  </li>
                  <div class="modal fade" id="friendRequestModal-<?= $friend->getUsername() ?>" tabindex="-1" aria-labelledby="friendRequestModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="friendRequestModalLabel">Friend Request from <?= $friend->getUsername() ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Do you want to accept the friend request?
                            </div>
                            <div class="modal-footer">
                                <form method="post" action="friends.php">
                                    <input type="hidden" name="requested-username" value="<?= $friend->getUsername() ?>">
                                    <button type="submit" name="action" value="accept" class="btn btn-success">Accept</button>
                                    <button type="submit" name="action" value="decline" class="btn btn-danger">Reject</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>    
                <?php } ?>
            <?php } ?>
        </ul>
      </div>
      <hr />
      <br />
      <div class="sendfriendrequest">
        <p hidden>Error Message</p>
        <form method="post" action="friends.php">
          <div class="input-group">
          <input
            placeholder="Add Friend to List"
            type="text"
            id="friend-request-name"
            list="friend-selector"
            name="friend-username"
            class="form-control"
          />
          <datalist id="friend-selector">
            <?php foreach ($availableUsers as $user){ //alle users
              $userIsFriend = false;
              foreach($friends as $friend){  //nur freunde
                if($friend->getUsername() === $user && $friend->getStatus() === "accepted"){ //filter freunde die in users sind und deren status accepted sind.
                  $userIsFriend = true; //true
                  break;
                }
              }
              ?>
              <?php if ($user !== $_SESSION["user"] && !$userIsFriend){ //filter die users keine Freunde(status: "accepted") sind und die aktuelle Nutzer  ?>
                <option value= "<?=$user ?>" >
              <?php } ?>
            <?php } ?>
          </datalist>
          <button id="but" type="submit"  value="add-friend" class="btn btn-outline-primary">
            Add
          </button>
          </div>
        </form>
      </div>
    </div>
    <script>
      function loadFriends() {
      var xhttp = new XMLHttpRequest();
      xhttp.open("GET", "ajax_load_friends.php", true);
      xhttp.send();
      xhttp.onreadystatechange = function () {
      if (xhttp.readyState === 4 && xhttp.status === 200) {
      var friendsData = JSON.parse(xhttp.responseText);

      let acceptedFriends = friendsData.filter(friend => friend.status === "accepted");
      let requestedFriends = friendsData.filter(friend => friend.status === "requested");

      // Update accepted friends
      const friendList = document.getElementById("friends-list");
      friendList.innerHTML = "";
      if (acceptedFriends.length === 0) {
        friendList.innerHTML = `<li class="list-group-item">No Friends Found</li>`;
      } else {
        acceptedFriends.forEach(friend => {
          let unreadCount = friend.unread || "0";
          friendList.innerHTML += `
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <a class="text-decoration-none text-dark me-3" href="chat.php?friend=${friend.username}">${friend.username}</a>
              <span class="badge bg-primary rounded-pill">${unreadCount}</span>
              <?php 
              //
              /*if ($unreadCount > 0) { ?>  --> condition of unreadcount > 0 --> hier wird nicht gebraucht da Tom keine ungelesen Nachrichten von Backend besitzt.
                <span class="badge bg-primary rounded-pill"><?= $unreadCount ?></span>
              }
              */
              ?>
            </li>
          `;
        });
      }

      // Update friend requests
      const newRequestsList = document.getElementById("new-request");
      newRequestsList.innerHTML = "";
      requestedFriends.forEach(request => {
        let requestId = `friendRequestModal-${request.username}`;
        newRequestsList.innerHTML += `
          <li class="list-group-item request-li" data-bs-toggle="modal" data-bs-target="#${requestId}">
            New Request from: ${request.username}
          </li>
        `;

        // Add modal for each request
        document.body.innerHTML += `
          <div class="modal fade" id="${requestId}" tabindex="-1" aria-labelledby="${requestId}Label" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="${requestId}Label">Friend Request from ${request.username}</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  Do you want to accept the friend request?
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-success" onclick="respondToRequest('${request.username}', 'accept')">Accept</button>
                  <button type="button" class="btn btn-danger" onclick="respondToRequest('${request.username}', 'decline')">Decline</button>
                </div>
              </div>
            </div>
          </div>
        `;
      });
    } else if (xhttp.readyState === 4) {
      console.error("Error loading friends.");
    }
  };
}
  setInterval(function() {
   loadFriends();
  }, 4000);
  </script>

  <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
      crossorigin="anonymous"
    ></script>
  </body>
</html>