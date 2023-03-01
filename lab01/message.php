<?php

?>
<!DOCTYPE html>
<html>
    <head>
        <title>CMPE2550 - LAB02</title>
        <meta charset="UTF-8">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="message.js"></script>
        <link href="style.css" rel="stylesheet" type="text/css"/>

    </head>
    <body>
    <header>
        <h1>CMPE2550 - LAB02 - Messages with REST</h1><hr/>
    </header>
    <div class = 'container'>
        <a href="index.php">Home</a>    
        <a href="users.php">User Management</a>
        <a href="roles.php">Role Management</a>
        <a id="logout" href="login.php">Logout</a>
        <div class = 'form'>
            <input type="hidden" name="addMessage" id="inputhidden">
            <label for="filter">Filter : </label><input type="text" name="filter" id="filter" placeholder="Supply a filter">
            <button id="btnFilter">Search</button>
            <label for="message">Message : </label><input type="text" name="message" id="message" placeholder="Enter a message to share">
            <button id="btnSend">Send Message</button>
        </div>
        <div id='messages'>

        </div>
    </div>
    <div>
        Messages need messaging!
    </div>
    <footer>
        Nandish Patel - Nov 2022
    </footer>
        
        <input type="button" id="testGET" value="GET">
        <input type="button" id="testPOST" value="POST">
        <input type="button" id="testPUT" value="PUT">
        <input type="button" id="testDELETE" value="DELETE">

        <hr/>
        <div id="output">
            
        </div>

    </body>
</html>