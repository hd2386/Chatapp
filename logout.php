<?php
session_start(); 

$_SESSION["user"] = false;
session_unset(); 
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>logout</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
      crossorigin="anonymous"
    />
  </head>

  <body class="bg-light">
    <script src="main.js"></script>
    <div class="container text-center">
      <img
        src="./images/logout.png"
        alt="Logout"
        class="rounded-circle mt-5"
        style="width: 200px"
      />
      <!-- Card -->
      <div class="card mt-5 mx-auto" style="width: 18rem">
        <div class="card-body">
          <h1 class="card-title">Logged out...</h1>
          <p class="card-text">See u!</p>
          <a href="login.php" class="btn btn-primary">Login again</a>
        </div>
      </div>
    </div>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
