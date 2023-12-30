<?php require("start.php");


// Go to Profile of Jana or Tom
// http://localhost/chatapp/profile.php?name=Jana


// Test Login
$service->login("Tom", "12345678");
$_SESSION["user"] = "Tom";




// Check if user is logged in
if (isset($_SESSION["user"])) {
  if (!empty($_SESSION["user"])) {

    //Namen des Users aus $_GET Query auslesen
    $username = $_GET["name"];
    
    // Load user from BackendService
    $user = $service->loadUser($username);

    // Verarbeiten der Formulardaten aus loadUser()
    $firstname = $user->getFirstname();
    $lastname = $user->getLastname();
    $drinks = $user->getDrinks();
    $comment = $user->getComment();
  } else {
    // Redirect to friends page
    header("Location: friends.php");
    exit();
  }
} else {
  // Redirect to login page
  header("Location: login.php");
  exit();
}




?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" type="text/css" href="styles.css" />
  <title>Profile</title>
</head>

<body>
  <script src="main.js"></script>
  <div class="content">
    <h1>Profile of <?= $username ?></h1>

    <a href="chat.php?friend=<?=$username ?>" id="backtochat"> &lt; Back to Chat</a> |
    <a href="friends.php?removefriend=<?=$username ?>" id="removefriend">Remove Friend</a>
    <br>
    <br>
    <div class="profilecontent">
      <div">
        <img class="squarephoto" src="./images/profile.png" />
    </div>

    <div class="textfield">

      <div class="profile-info">
        <p><b>Name: </b><?= $firstname . ' ' . $lastname ?>
          <br>
        <p id="drinks"><b>Coffee or Tea? </b> <?= $drinks ?></p>
      </div>
      <div class="profile-text">
        <p> <b>Something about me: </b> <br>
          <?= $comment ?>
        </p>
      </div>
    </div>
  </div>
  </div>
</body>

</html>