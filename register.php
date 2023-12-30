<?php require("start.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="styles.css">
  <title>Register</title>
  <script src="main.js"></script>
</head>

<body>
  <div class="center">
    <img src="./images/user.png" alt="chat.png" width="100">
    <h1>Register yourself</h1>
    <fieldset class="registerform">
      <legend>Register</legend>
      <form onsubmit="return validateForm()">
        <label for="username">Username:</label>
        <input type="text" id="username" placeholder="Username" name="username" required><br><br>
        <label for="password">Passwort: </label>
        <input type="password" id="password" placeholder="Password" name="password" required><br><br>
        <label for="confirmpassword">Confirm Password: </label>
        <input type="password" id="confirmpassword" placeholder="Confirm Password" name="confirmpassword" required><br><br>
    </fieldset>
    <button type="button" class="graybuttons" onclick="window.location.href='register.php'">Cancel</button>
    <input type="submit" class="bluebuttons" value="Create Accout" />
    </form>
  </div>
</body>

</html>