<?php require("start.php");

//Test Login
$service->login("Jana", "asdfghjkf");
$_SESSION["user"] = "Jana";
// $service->login("Tom", "12345678");
// $_SESSION["user"] = "Tom";

var_dump($_SESSION);


// Check if user is logged in
if(isset($_SESSION["user"])){
    if(!empty($_SESSION["user"])) {

      // Load user from BackendService
      $user = $service->loadUser($_SESSION["user"]);
      
      // Save form data to user data
      if(isset($_POST["firstname"]) && !empty($_POST["firstname"])) {
        $user->setFirstname($_POST["firstname"]);
      }
      if(isset($_POST["lastname"])&& !empty($_POST["lastname"])) {
        $user->setLastname($_POST["lastname"]);
      }
      if(isset($_POST["drinks"]) && !empty($_POST["drinks"])) {
        $user->setDrinks($_POST["drinks"]);
      }
      if(isset($_POST["comment"]) && !empty($_POST["comment"])) {
        $user->setComment($_POST["comment"]);
      }
      if(isset($_POST["layout"]) && !empty($_POST["layout"])) {
        $user->setLayout($_POST["layout"]);
      }

      // Verarbeiten der Formulardaten aus loadUser()
      $firstname = $user->getFirstname();
      $lastname = $user->getLastname();
      $drinks = $user->getDrinks();
      $comment = $user->getComment();
      $layout;

      if ($user->getLayout() !== null) {
        $layout = $user->getLayout();
      } else{ 
        $layout = 0; 
      }
      
      // Nutzer Speichern 
      $service->saveUser($user);
}
else{
  // Redirect to login page
  header("Location: login.php");
  exit();
}
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" type="text/css" href="styles.css" />
  <title>Settings</title>
</head>

<body> 
  <script src="main.js"></script>
  <div class="content">
    <h1>Profile Settings</h1>

    <a href="friends.php" id="goback">&lt; Go back</a><br /><br />
    <form method="post">
      <fieldset class="settingsform">
        <legend>Base Data</legend>
        <label for="firstname">First Name:</label>
        <input name="firstname" type="text" id="firstname" value="<?= $firstname ?>" >  <br/>
        <label for="lastname" >Last Name:</label>
        <input name="lastname" type="text" id="lastname" value="<?= $lastname ?>" > <br>
        <label for="drinks" >Coffee or Tea?</label>
        <select name="drinks" id="drinks">
          <!--changed order so "neither nor" stays default value-->
          <option <?= ($user->getDrinks() == "neither") ? "selected" : "" ?> value="neither">Neither nor</option>
          <option <?= ($user->getDrinks() == "tea") ? "selected" : "" ?> value="tea">Tea</option>
          <option <?= ($user->getDrinks() == "coffee") ? "selected" : "" ?> value="coffee">Coffee</option>
        </select>
      </fieldset>

      <fieldset class="commentform">
        <legend>Tell Us Something About Yourself</legend>
        <textarea id="comment" name="comment" rows="6" cols="50" 
        placeholder="<?= ($comment == null) ? 'Leave a comment here' : '' ?>" ><?= $comment ?></textarea>
      </fieldset>

      <fieldset class="radioform">
        <legend>Prefered Chat Layout</legend>
        <input name="layout" type="radio" value="1" id="layout" <?= ($user->getLayout() == "1") ? "checked" : "" ?> />
        <label for="layout1">Username and message in one line</label><br />
        <input name="layout" type="radio" value="2" id="layout" <?= ($user->getLayout() == "2") ? "checked" : "" ?> />
        <label for="layout2">Username and message in separated lines</label>
      </fieldset>
      <a href="friends.php"><button type="button" ; id="cancel" class="graybuttons">Cancel</button></a>
      <button type="submit" id="save" class="bluebuttons">Save</button>
    </form>


  </div>
</body>

</html>