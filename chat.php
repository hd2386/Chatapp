<?php
require ("start.php");




?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="styles.css" />
    <title>Chat</title>
  </head>

  <body>
    <script src="main.js"></script>

    <div class="content">
      <h1 id="title">Chat with <?php echo $_GET["friend"]?></h1>
      <a href="friends.php" id="goback"> &lt; Back</a> |
      <a href="profile.php?name=<?php echo $_GET["friend"]?>" id="profile"> Profile</a> |
      <a href="friends.php?action=remove&friend=<?php echo $_GET["friend"]; ?>" id="removefriend">Remove Friend</a>
      <hr />

      <div class="chat-box" id="chat-container"></div>

      <div class="new-message-div">
        <form id="chat-form">
          <input type="text" id="newmessage" placeholder="New Message" /> <br />
          <button
            type="button"
            class="graybuttons"
            id="sendmessagebutton"
            onclick="sendMessage()"
          >
            Send
          </button>
        </form>
      </div>
    </div>
  </body>
</html>