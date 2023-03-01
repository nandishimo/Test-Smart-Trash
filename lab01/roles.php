<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="roles.js"></script>
    <link href="style.css" rel="stylesheet" type="text/css"/>
    <title>Role Management</title>
</head>
<body>
    <header>
        <h1>Role Management</h1>
    </header>
    <div class = 'container'>
        <a href="index.php">Home</a>
        <a href="message.php">Messaging</a>
        <a href="users.php">User Management</a>
        <a id="logout" href="login.php">Logout</a>
        <div class = 'form'>
            <input type="hidden" name="addRole" id="inputhidden">
            <label for="roleName">Role Name : </label><input type="text" name="roleName" id="roleName" placeholder="Enter a role name here">
            <label for="roleDesc">Description : </label><input type="text" name="roleDesc" id="roleDesc" placeholder="Enter a description here">
            <label for="rank">Rank : </label>
            <select name="rank" id="rank">
                <option value="0">0</option>
                <option value="1">1</option>    
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10" selected="selected">10</option>
            </select>
            <button type="submit">Add Role</button>
        </div>
        <div id='roles'>

        </div>
    </div>
    <div>
        Roles need managing!
    </div>
    <footer>
        Nandish Patel - Nov 2022
    </footer>
</body>
</html>