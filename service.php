<?
require_once "db.php";
session_start();
error_log(json_encode($_POST));
//store clean POST data in variables
$action;
$userID;
$user;
$roleID;
$password;
$userRank = "nothing"; //default user rank is nothing because null allows comparison
$roleName;
$roleDesc;
$roleRank;

if (isset($_POST['action'])) {
    $action = strip_tags($_POST['action']);
}
if (isset($_POST['userID'])) {
    $userID = $connection->real_escape_string(strip_tags(trim($_POST['userID'])));
}
if (isset($_POST['username'])) {
    $user = $connection->real_escape_string(strip_tags(trim($_POST['username'])));
}
if (isset($_POST['roleID'])) {
    $roleID = $connection->real_escape_string(strip_tags(trim($_POST['roleID'])));
}
if (isset($_POST['password'])) {
    $password = $connection->real_escape_string(strip_tags(trim($_POST['password'])));
}
if (isset($_POST['roleName'])) {
    $roleName = $connection->real_escape_string(strip_tags(trim($_POST['roleName'])));
}
if (isset($_POST['roleDesc'])) {
    $roleDesc = $connection->real_escape_string(strip_tags(trim($_POST['roleDesc'])));
}
if (isset($_POST['roleRank'])) {
    $roleRank = $connection->real_escape_string(strip_tags(trim($_POST['roleRank'])));
}

//check if there is a logged in user and if so, get their rank for permission checks
if (isset($_SESSION['userID'])) {dewa
    $userRank = GetUserRank($_SESSION['userID']);
}
//default response is error of unknown type, specific error messages will be set if checks fail
$response['result'] = "error";
$response['message'] = "Unknown error";

if ($action == "register" || $action == "login") {
    //do basic checks on input i.e. minimum lengths and such
    //no empty string for username or password
    if (isset($user) && strlen($user) > 0) {
        if (isset($password) && strlen($password) > 0) {
            if ($action == "register") {
                AddUser($user, $password, 4); //default role id is 4 with lowest rank of 10
            } else if ($action == "login") {
                Login($user, $password);
            }
        } else {
            $response['message'] = 'Invalid password';
        }
    } else {
        $response['message'] = 'Invalid username';
    }
    echo json_encode($response);
    exit;
}
//grab rank of currently logged in user for sanity checks client side
if ($action == "checkRank") {
    $response['rank'] = $userRank;
}
//allow anyone to logout and clear session
if ($action == "logout") {
    session_unset();
    session_destroy();
    $response['result'] = "success";
}
/////////////////////////////////////////////////////////////////
// ALL ACTIONS AFTER THIS POINT REQUIRE A USER TO BE LOGGED IN //
/////////////////////////////////////////////////////////////////
if (isset($_SESSION['userID'])) {

    //For all actions below, check if the user has permission (compare rank)
    //Check if required variables are set and meet any other requirements
    //call helper function to perform action (query db, updates, deletes, etc)

    if ($action == "getUsers") {
        //there must be a user logged in with rank greater than 10 to see user data
        if ($userRank < 10) {
            GetUsers();
        } else {
            $response['message'] = "You do not have permission to view this page";
        }
    }
    if ($action == "deleteUser") {
        if (isset($userID)) {
            //current user must have a higher rank than the user they are trying to delete
            if ($userRank < GetUserRank($userID)) {
                DeleteUser($userID);
            } else {
                $response['message'] = "You do not have permission to delete this user";
            }
        } else {
            $response['message'] = "Trying to delete a user without a userID";
        }
    }
    if ($action == "addUser") {
        //current user must have a higher rank than the user they are trying to add
        if ($userRank < GetRoleRank($roleID)) {
            //check if username & password are not empty
            if (isset($user) && strlen($user) > 0) {
                if (isset($password) && strlen($password) > 0) {
                    //check if roleID is set
                    if (isset($_POST['roleID'])) {
                        AddUser($user, $password, $roleID);
                    } else {
                        $response['message'] = "Trying to add a user without a roleID";
                    }
                } else {
                    $response['message'] = "Trying to add a user without a password";
                }
            } else {
                $response['message'] = "Invalid username";
            }
        } else {
            $response['message'] = "You do not have sufficient privileges to give a user this role";
        }
    }
    if ($action == "updateUser") {
        //current user must have a higher rank than the user they are trying to update 
        //current user must have higher rank than the role they are trying to update to
        if ($userRank < GetUserRank($userID)) {
            if ($userRank < GetRoleRank($roleID)) {
                //check if userid and roleid are set for function call
                if (isset($userID) && isset($roleID)) {
                    UpdateUser($userID, $roleID);
                } else {
                    $response['message'] = "Missing user ID or new role ID";
                }
            } else {
                $response['message'] = "You do not have sufficient privileges to give a user this role";
            }
        } else {
            $response['message'] = "You do not have sufficient privileges to change this users role";
        }
    }
    if ($action == "getRoles") {
        //need to be any rank above basic user (rank 10) to see role data
        if ($userRank < 10) {
            GetRoles();
        } else {
            $response['message'] = "You do not have permission to view this page";
        }
    }
    if ($action == "addRole") {
        //user must have a higher rank than the role they are trying to add
        if ($userRank < $roleRank) {
            if (isset($roleName) && isset($roleRank)) {
                //need a role name and rank before adding a role
                if (!isset($roleDesc)||strlen($roleDesc) == 0) {
                    $roleDesc = null; //if no description is given, set it to null
                }
                AddRole($roleName, $roleDesc, $roleRank);
            } else {
                $response['message'] = "Invalid role data";
            }
        } else {
            $response['message'] = "You do not have permission to add a role";
        }
    }
    if ($action == "deleteRole") {
        //check if user has priviliges to delete role
        if ($userRank < GetRoleRank($roleID)) {
            DeleteRole($roleID);
        } else {
            $response['message'] = "You do not have permission to delete this role";
        }
    }

    if ($action == "changeRole") {
        //user needs higher rank than role they want to change and the rank they want to change to
        if ($userRank < GetRoleRank($roleID) && $userRank < $roleRank) {
            if (isset($roleName) && isset($roleRank)) {
                //need a role name and rank before changing a role
                if (!isset($roleDesc)||strlen($roleDesc) == 0) {
                    $roleDesc = null; //if no description is given, set it to empty string
                }    
                    ChangeRole($roleID, $roleName, $roleDesc, $roleRank);
            } else{
                $response['message'] = "Invalid role name or rank";
            }
        } else {
            $response['message'] = "You do not have sufficient privileges to edit this role";
        }
    }

} else {
    $response['message'] = "This action requires a user to be logged in";
}

///////////////
// Functions //
///////////////
//helper function to edit roles
function ChangeRole($roleid, $rolename, $roledesc, $rolerank)
{
    global $connection, $response;
    //check if role exists
    if ($result = mySQLQuery("SELECT * FROM roles WHERE role_id='$roleid';")) {
        if ($result->num_rows > 0) {
            //user must be of higher rank than role
            if ($result = mySQLQuery("UPDATE roles SET role_name='$rolename', role_description='$roledesc', role_rank='$rolerank' WHERE role_id='$roleid';")) {
                $response['result'] = "success";
                $response['message'] = "Role changed";
            } else {
                $response['message'] = "Error occured while changing role. Please contact server admin";
            }
        } else {
            $response['message'] = "Role not found";
        }
    } else {
        $response['message'] = "Error encountered whilst querying roles table";
    }
}
//helper function to delete a role
function DeleteRole($roleid)
{
    global $connection, $response;
    //check if role is in use exists
    if ($result = mySQLQuery("SELECT * FROM roles WHERE role_id='$roleid';")) {
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            //check if role is in use
            if ($result = mySQLQuery("SELECT * FROM userroles WHERE role_id='$roleid';")) {
                if ($result->num_rows == 0) {
                    if ($result = mySQLQuery("DELETE FROM roles WHERE role_id='$roleid';")) {
                        $response['result'] = "success";
                        $response['message'] = "Role " . $row['row_name'] . " deleted";
                    } else {
                        $response['message'] = "Error occured while deleting role. Please contact server admin";
                    }
                } else {
                    $response['message'] = "Role is in use and cannot be deleted";
                }
            } else {
                $response['message'] = "Error encountered whilst querying userroles table";
            }
        } else {
            $response['message'] = "Role does not exist";
        }
    } else {
        $response['message'] = "Error encountered whilst querying roles table";
    }
}

//helper function to get a list of all roles
function GetRoles()
{
    global $connection, $response;
    if ($result = mySQLQuery("SELECT * FROM roles;")) {
        while ($row = $result->fetch_assoc()) {
            $response['roles'][] = $row;
        }
        $response['result'] = "success";
    } else {
        $response['message'] = "Error retrieving users";
    }
}

//helper function to insert role into roles table
function AddRole($rolename, $description, $rank)
{
    
    global $connection, $response;
    if ($result = mySQLQuery("INSERT INTO roles (role_name, role_description, role_rank) VALUES ('$rolename', '$description', '$rank');")) {
        $response['result'] = "success";
    } else {
        $response['message'] = "Error adding role";
    }
}

//function to update the associated role of a user
function UpdateUser($userid, $roleid)
{
    global $connection, $response;
    if ($result = mySQLQuery("UPDATE userroles SET role_id = '$roleid' WHERE user_id = '$userid';")) {
        $response['result'] = "success";
        $response['message'] = "User updated successfully";
    } else {
        $response['message'] = "Error updating user";
    }
}

//helper method to get the rank associated with a user's role
function GetUserRank($userid)
{
    global $connection, $response;
    if ($result = mySQLQuery("SELECT role_rank FROM userroles JOIN roles ON userroles.role_id = roles.role_id WHERE user_id = $userid;")) {
        if ($result->num_rows > 0) { //check if user has a role
            $row = $result->fetch_assoc();
            return $row['role_rank'];
        } else {
            $response['message'] = "Invalid user ID";
        }
    } else {
        $response['message'] = "Error getting user rank";
    }
}

//helper method to get the rank associated with a role
function GetRoleRank($roleid)
{
    global $connection, $response;
    if ($result = mySQLQuery("SELECT role_rank FROM roles WHERE role_id = '$roleid';")) {
        if ($result->num_rows > 0) { //check if a role exists for this id
            $row = $result->fetch_assoc();
            return $row['role_rank'];
        } else {
            $response['message'] = "Invalid role ID";
        }
    } else {
        $response['message'] = "Error getting role rank";
    }
}

//helper method to delete a user
function DeleteUser($userID)
{
    global $connection, $response;
    //check if user exists and get their role
    if ($result = mySQLQuery("SELECT * FROM users WHERE user_id='$userID';")) {
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            //transaction to do back to back deletes (userroles and users)
            $connection->begin_transaction();
            try {
                mySQLQuery("DELETE FROM userroles WHERE user_id='$userID';");
                mySQLQuery("DELETE FROM users WHERE user_id='$userID';");
                $connection->commit();//commit if both queries succeed
                $response['result'] = "success";
                $response['message'] = "User " . $row['username'] . " deleted";
            } catch (mysqli_sql_exception $ex) {
                $connection->rollback();//rollback on exception
                $response['message'] = "Error occured while deleting user. Please contact server admin";
                throw $ex;
            }
        } else {
            $response['message'] = "User does not exist";
        }
    } else {
        $response['message'] = "Error encountered whilst querying database";
    }
}

//helper method to get a list of all users
function GetUsers()
{
    global $connection, $response;
    if ($result = mySQLQuery("SELECT * FROM users JOIN userroles ON users.user_id = userroles.user_id JOIN roles ON userroles.role_id = roles.role_id;")) {
        while ($row = $result->fetch_assoc()) {
            $response['users'][] = $row;
        }
        $response['result'] = "success";
    } else {
        $response['message'] = "Error retrieving users";
    }
}

//method to authenticate a user and password against database, save user id to session
function Login($user, $password)
{
    global $connection, $response;
    if ($result = mySQLQuery("SELECT users.user_id, password, role_name, role_rank FROM users JOIN userroles ON users.user_id = userroles.user_id JOIN roles ON userroles.role_id = roles.role_id WHERE username = '$user';")) {
        if (mysqli_num_rows($result) == 1) {//credentials should match exactly one user
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                $_SESSION['userID'] = $row['user_id'];
                $response['result'] = "success";
                $response['message'] = "$user logged in successfully with ID: $row[user_id] and Role: $row[role_name]";
            } else {
                $response['message'] = 'Invalid password';
            }
        }
    } else {
        $response['message'] = "Username not found";
    }
}

//method to add a new user to the database, requires password and role
function AddUser($user, $password, $role_id)
{
    global $connection, $response;
    $pw = password_hash($password, PASSWORD_DEFAULT);
    //check if username exists, no dupes
    $result = mySQLQuery("SELECT * FROM users WHERE username='$user';");
    if (mysqli_num_rows($result) == 0) {
        //transacation to do back to back inserts (users and userroles)
        $connection->begin_transaction();
        try {
            mySQLQuery("INSERT INTO users (username, password) VALUES('$user','$pw');");
            $last_id = $connection->insert_id;
            mySQLQuery("INSERT INTO userroles (user_id, role_id) VALUES('$last_id', '$role_id');");
            $connection->commit();
            $response['result'] = "success";
            $response['message'] = "User $user created successfully";
        } catch (mysqli_sql_exception $ex) {
            $connection->rollback();
            $response['message'] = "Error occured while adding user. Please contact server admin";
            throw $ex;
        }
    } else {
        $response['message'] = "User already exists";
    }
}
error_log(json_encode($response));
echo json_encode($response);
