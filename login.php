<?php
use Utils\BackendService;
require("start.php");

if(isset($_SESSION["user"]) && $_SESSION["user"]) {
    header("Location: friends.php");
    die();
}

if (isset($_POST['action']) && $_POST["action"]=="Login") {
    $username = $_POST['username'] ?? ''; //wenn "username nicht eingegeben ist, dann $username = ""
    $password = $_POST['password'] ?? ''; //wenn "password nicht eingegeben ist, dann $password = ""

    $backendService = new BackendService(CHAT_SERVER_URL, CHAT_SERVER_ID);
    $loginResult = $backendService->login($username, $password);

    if ($loginResult === true) {
        $_SESSION["user"] = $username;
        header("Location: friends.php");
    } else {
        echo "Wrong Password or Username";
 
    }
    
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Login</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
      crossorigin="anonymous"
    />
  </head>

  <body class="bg-light">
    <script src="main.js"></script>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <img
            src="./images/chat.png"
            alt="Chat"
            class="rounded-circle mx-auto d-block mt-5 mb-5"
            style="width: 200px"
          />
          <div class="card">
            <div class="card-body">
              <h1 class="card-title text-center">Please sign in</h1>
              <form method="post" action="login.php">
                <div class="form-group">
                  <label for="username">Username:</label>
                  <input
                    type="text"
                    id="username"
                    class="form-control"
                    placeholder="Username"
                    name="username"
                  />
                </div>
                <div class="form-group">
                  <label for="password">Password:</label>
                  <input
                    type="password"
                    id="password"
                    class="form-control"
                    placeholder="Password"
                    name="password"
                  />
                </div>
                <button type="submit" class="btn btn-primary w-100 mt-2" name="action" value="Login">
                  Login
                </button>
              </form>
              <a href="register.php" class="btn btn-secondary w-100 mt-2"
                >Register</a
              >
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>