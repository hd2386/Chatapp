/*
//alte Version
window.backendUrl = "https://online-lectures-cs.thi.de/chat/8f8b40b3-453c-4029-84e3-fdb583b782b3";
window.token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyIjoiVG9tIiwiaWF0IjoxNzAwMDQyMDQ0fQ.vgL9anGYJELCgl0dpiAgABixCM7EAELdbLIeZloa8UA"
// Das Token für Tom, in unserem Fall ist deshalb Tom eingeloggt.
*/
/*

Tom
    User: Tom
    Password: 12345678
    Token: eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyIjoiVG9tIiwiaWF0IjoxNzAwNjgyNjM0fQ.FsiX6DBnJQ_MbqkuEexiMALvc1lcCPQV0VJufaZyLxk

Jerry
    User: Jerry
    Password: 87654321
    Token: eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyIjoiSmVycnkiLCJpYXQiOjE3MDA2ODI2MzR9.VAn872ZcMe9VT4EmVK47_fD2SltKpNSRWxp1qHVWGlI
*/

window.backendUrl =
  "https://online-lectures-cs.thi.de/chat/5a4b8b37-601f-4b73-8479-73124952c25f";
window.token =
  "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyIjoiVG9tIiwiaWF0IjoxNzAwNjgyNjM0fQ.FsiX6DBnJQ_MbqkuEexiMALvc1lcCPQV0VJufaZyLxk";
// Toms Token

const currentUser = {
  username: "Tom",
  token: window.token,
};

if (window.location.href.includes("register.php")) {
  let users = [];
  validateForm();
}

if (window.location.href.includes("friends.php")) {
  let users = [];
  updateAuswahlList();
  window.setInterval(function () {
    loadFriends();
  }, 1000);
}

if (window.location.href.includes("chat.php")) {
  const friend = getChatpartner();
  loadFriends();
  //Führt jedes Sekunde, die folgende listMessages() Methode aus:
  window.setInterval(function () {
    addFriendNameToQueryAndTitle(friend);
    listMessages(friend, function (data) {
      clearMessages();
      displayMessages(data);
    });
  }, 1000);
}

/*
if (window.location.href.includes("profile.php")) {
  const name = addQueryParams();
}

// aufgabe 4
/*

function addQueryParams() {
  const url = new URL(window.location.href);
  // Access the query parameters using searchParams
  const queryParams = url.searchParams;
  // Retrieve the value of the "name" parameter
  const name = queryParams.get("name");
  //set query param for link to chat and friends
  let chatlink = document.getElementById("backtochat");
  if (chatlink) {
    chatlink.href = "chat.php?friend=" + name;
  }
  let removelink = document.getElementById("removefriend");
  if (removelink) {
    removelink.href = "friends.php?removefriend=" + name;
  }
}

// for friends.html
function updateAuswahlList() {
  const datalist = document.getElementById("friend-selector");
  datalist.innerHTML = "";
  // listUsers fonksiyonunu çağırırken bir geri çağrı fonksiyonunu kullan
  listUsers(function (users) {
    //für die Async
    const input = document
      .getElementById("friend-request-name") //nimmt das Inputvalue als kleinzeichen von dem ID
      .value.toLowerCase();
    users.forEach((username) => {
      if (
        username.toLowerCase().includes(input) &&
        username !== currentUser.username //wenn username beinhaltet das Input
      ) {
        const option = document.createElement("option");
        option.value = username;
        datalist.appendChild(option);
      }
    });
  });
}

function listUsers(callback) {
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function () {
    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
      users = JSON.parse(xmlhttp.responseText);
      callback(users);
    }
  };
  xmlhttp.open("GET", backendUrl + "/user", true);
  xmlhttp.setRequestHeader("Authorization", "Bearer " + token);
  xmlhttp.send();
}

document
  .getElementById("friend-request-name")
  .addEventListener("input", checkInput);
function checkInput() {
  const inputElement = document.getElementById("friend-request-name");
  const buttondedector = document.getElementById("but");
  const inputValue = inputElement.value.toLowerCase();
  if (inputValue == currentUser.username) {
    inputElement.classList.add("warning-border");
    buttondedector.disabled = true;
  } else {
    buttondedector.disabled = false;
  }
}

function sendFriendRequest() {
  const friendUsername = document.getElementById("friend-request-name").value;
  if (
    users.includes(friendUsername) &&
    friendUsername !== currentUser.username
  ) {
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
      if (xmlhttp.readyState == 4 && xmlhttp.status == 204) {
        console.log("Requested to " + friendUsername);
        listUsers(handleFriendRequest);
        //wegen merge, wird hoffentlich ausgeführt jedes Mal, wenn ein Freund hinzugefügt wurde
      }
    };
    xmlhttp.open("POST", backendUrl + "/friend", true);
    xmlhttp.setRequestHeader("Content-type", "application/json");
    xmlhttp.setRequestHeader("Authorization", "Bearer " + token);
    let data = {
      username: friendUsername,
    };
    let jsonString = JSON.stringify(data);
    xmlhttp.send(jsonString);
  }
}

function handleFriendRequest(friends) {
  let acceptedFriends = friends.filter(
    (friend) =>
      friend.status === "accepted" && friend.username !== currentUser.username
  );

  let requestedFriends = friends.filter(
    (friend) => friend.status === "requested"
  );
  // freund requests and freundlist actualisation
  renderFriendList(acceptedFriends);
  renderRequestedList(requestedFriends);
}

function renderFriendList(friends) {
  const friendList = document.getElementById("friends-list");
  friendList.innerHTML = ""; // Önceki liste içeriğini temizleme
  friends[0].unread = 2; //to set unread on 2

  friends.forEach((friend) => {
    const li = document.createElement("li");
    var friendDiv = document.createElement("div");
    friendDiv.classList.add("friend-entry");
    li.appendChild(friendDiv);
    var link = document.createElement("a");
    var linkText = document.createTextNode(friend.username);
    link.appendChild(linkText);
    link.href = "chat.html?friend=" + friend.username;
    friendDiv.appendChild(link);

    if (friend.unread > 0) {
      li.style.fontWeight = "bold";
      var unread = document.createElement("span");
      unread.classList.add("badge");
      unread.textContent = friend.unread;
      friendDiv.appendChild(unread);
    }
    friendList.appendChild(li);
  });
}

function renderRequestedList(requests) {
  const newRequestsList = document.getElementById("new-request");
  const buttons = document.getElementsByClassName("friend-request-entry");
  newRequestsList.innerHTML = ""; // clear the list before run

  requests.forEach((request) => {
    const li = document.createElement("li");
    li.textContent = `New Request to: ${request.username}`;
    li.classList.add("request-li");
    const acceptButton = document.createElement("button");
    acceptButton.textContent = "Accept";
    acceptButton.classList.add("bluebuttons");
    acceptButton.classList.add("friend-blue-button-position");
    li.appendChild(acceptButton);

    const declineButton = document.createElement("button");
    declineButton.textContent = "Decline";
    declineButton.classList.add("graybuttons");
    declineButton.classList.add("friend-gray-button-position");
    li.appendChild(declineButton);
    newRequestsList.appendChild(li);
  });
}

function loadFriends() {
  let xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function () {
    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
      let data = JSON.parse(xmlhttp.responseText);
      handleFriendRequest(data);
    }
  };
  xmlhttp.open("GET", backendUrl + "/friend", true);
  xmlhttp.setRequestHeader("Content-type", "application/json");
  xmlhttp.setRequestHeader("Authorization", "Bearer " + token);
  xmlhttp.send();
}

//chat.js merged

function addFriendNameToQueryAndTitle(friend) {
  let title = document.getElementById("title");
  if (title) {
    title.innerText = "Chat with " + friend;
  }
  
  //set query param for link to profile of friend
  let profilelink = document.getElementById("profile");
  if (profilelink) {
    profilelink.href = "profile.php?name=" + friend;
  }
  let removelink = document.getElementById("removefriend");
  if (removelink) {
    removelink.href = "friends.php?removefriend=" + friend;
    
  }
  
}

function clearMessages() {
  let parent = document.getElementById("chat-container");
  let container = parent.querySelector(".container");
  if (container) {
    parent.removeChild(container);
  }
}

function displayMessages(data) {
  let chatbox = document.getElementById("chat-container");
  let container = document.createElement("div");
  container.setAttribute("class", "container");

  for (let i = 0; i < data.length; i++) {
    let m = data[i];
    let messageDiv = document.createElement("div");
    messageDiv.setAttribute("class", "chat-message");

    let senderName = document.createElement("p");
    senderName.setAttribute("class", "chat-sendername");
    senderName.innerText = m.from;
    messageDiv.appendChild(senderName);
    let textElement = document.createElement("p");
    textElement.innerText = m.msg;
    //  textElement.setAttribute("class", "chat-message");
    messageDiv.appendChild(textElement);

    let timeStamp = document.createElement("span");
    timeStamp.setAttribute("class", "chat-timestamp");

    // convert UNIX time to hh:mm:ss format
    const date = new Date(m.time);
    const hours = date.getUTCHours().toString().padStart(2, "0");
    const minutes = date.getUTCMinutes().toString().padStart(2, "0");
    const seconds = date.getUTCSeconds().toString().padStart(2, "0");
    const formattedTime = `${hours}:${minutes}:${seconds}`;

    timeStamp.innerText = formattedTime;
    messageDiv.appendChild(timeStamp);
    container.appendChild(messageDiv);
  }
  chatbox.insertBefore(container, chatbox.firstChild);
  scrollToBottom();
}

// Scroll to the bottom after appending messages
function scrollToBottom() {
  let chatbox = document.getElementById("chat-container");
  chatbox.scrollTop = chatbox.scrollHeight;
}

// List Messages (GET) Example JS Code from https://online-lectures-cs.thi.de/chat/dummy#list-messages
/*
Lists all messages exchanged between the authenticated user and another. This request requires a token to be sent along.
URL: https://online-lectures-cs.thi.de/chat/8f8b40b3-453c-4029-84e3-fdb583b782b3/message/<user>
As an example, https://online-lectures-cs.thi.de/chat/8f8b40b3-453c-4029-84e3-fdb583b782b3/message/Jerry sends all messages between Jerry and Tom if you use the token from Tom.
*/

// RESPONSE HTTP-Status-Code 200 with JSON-document as payload.
// [{msg: "Hello, World!", from: "Tom", time: 0}, {msg: "42", from: "Jerry", time: 1}]
function listMessages(username, callback) {
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function () {
    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
      var data = JSON.parse(xmlhttp.responseText);
      callback(data);
      console.log(data);
    }
  };
  xmlhttp.open("GET", backendUrl + "/message/" + username, true);
  // Add token, e. g., from Tom
  xmlhttp.setRequestHeader("Authorization", "Bearer " + token);
  xmlhttp.send();
}

//Send Message(POST) Example JS Code from https://online-lectures-cs.thi.de/chat/dummy#send-message
/*
Send a message to another user. This request requires a token to be sent along and requires the HTTP method POST.
URL: https://online-lectures-cs.thi.de/chat/8f8b40b3-453c-4029-84e3-fdb583b782b3/message
*/
// REQUEST Requires JSON payload in request
// {"msg": "Example", "to": "Jerry"}

//RESPONSE HTTP-Status-Code 204 and no payload.
function sendMessage() {
  let xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function () {
    if (xmlhttp.readyState == 4 && xmlhttp.status == 204) {
      console.log("done...");
    }
  };

  xmlhttp.open("POST", backendUrl + "/message", true);
  xmlhttp.setRequestHeader("Content-type", "application/json");
  // Add token, e. g., from Tom
  xmlhttp.setRequestHeader("Authorization", "Bearer " + token);

  // Get message from input form
  let messageInput = document.getElementById("newmessage");

  console.log("Input Value:", messageInput.value);
  let messageValue = messageInput.value;

  if (!messageValue.trim()) {
    console.log("Message is empty!");
    return;
  }

  // Create request data with message and receiver
  let data = {
    message: messageValue,
    to: friend,
  };

  let jsonString = JSON.stringify(data); // Serialize as JSON
  xmlhttp.send(jsonString); // Send JSON-data to server

  //clear input after sending
  document.getElementById("newmessage").value = "";
}

function getChatpartner() {
  const url = new URL(window.location.href);
  // Access the query parameters using searchParams
  const queryParams = url.searchParams;
  // Retrieve the value of the "friend" parameter
  const friendValue = queryParams.get("friend");
  return friendValue;
}

// for register.html

function validateForm() {
  var username = document.getElementById("username").value;
  var password = document.getElementById("password").value;
  var confirmpassword = document.getElementById("confirmpassword").value;

  // Check if the username already exists in the 'users' array
  if (users.some(match)) {
    alert("Choose another username");
    return false;
  }

  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function () {
    if (xmlhttp.readyState == 4) {
      if (xmlhttp.status == 204) {
        // The username exists, display an alert
        console.log("Exists");
        alert("Choose another username");
      } else if (xmlhttp.status == 404) {
        // The username does not exist, display an alert
        console.log("Does not exist");
        alert("Account created");
      }
    }
  };

  xmlhttp.open(
    "GET",
    "https://online-lectures-cs.thi.de/chat/5a4b8b37-601f-4b73-8479-73124952c25f/user/" +
      username,
    true
  );
  xmlhttp.send();

  if (username.length < 3) {
    alert("The username must be at least three characters long.");
    return false;
  }

  if (password.length < 8) {
    alert("The password must be at least eight characters long.");
    return false;
  }

  if (password !== confirmpassword) {
    alert("The password confirmation does not match the password.");
    return false;
  }

  return true;
}

function match(user) {
  return user.username === username;
}
