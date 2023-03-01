var roles = {};
$(document).ready(() => {
    //on page load, check current logged in user rank
    CheckRank();
    //get all roles and users
    GetRoles();
    GetUsers();
    //bind submit button to AddUser function
    $('button[type="submit"]').click(AddUser);
    $('#logout').click(Logout);
});
//check if user is logged in and their rank
function CheckRank(){
    var postData = {};
    postData['action'] = "checkRank";
    AjaxRequest("service.php", "post", postData, "json", CheckSuccess, AjaxError);
}

//if user is not logged in, redirect to login page
//if user is low rank, redirect to home page
function CheckSuccess(data){
    if(data['rank']=="nothing"){
        location.replace("login.php");
    }
    else if(data['rank']>=10){
        location.replace("index.php");
    }
}

function Logout(){
    var postData = {};
    postData['action'] = "logout";
    AjaxRequest("service.php", "post", postData, "json", location.replace("login.php"), AjaxError);
}
function DeleteUser(){
    var postData = {};
    postData['action'] = "deleteUser";
    postData['userID'] = $(this).parent().next().html();
    AjaxRequest("service.php", "post", postData, "json", DeleteSuccess, AjaxError);
}

function DeleteSuccess(data){
    alert(data['message']);
    GetUsers();
}

function GetUsers(){
    var postData = {};
    postData['action'] = "getUsers";
    AjaxRequest("service.php", "post", postData, "json", DisplayUsers, AjaxError);
}

function GetRoles(){
    var postData = {};
    postData['action'] = "getRoles";
    AjaxRequest("service.php", "post", postData, "json", SaveRoles, AjaxError);
}

function SaveRoles(data){
    roles = data['roles'];
}

//display table of users with delete button and dropdown for changing role
function DisplayUsers(data){
    if (data['result'] == "error"){ alert("Error : "+data['message']); return;}
    if (data['result'] != "success"){ alert("Unknown response from server"); return;}
    $('#users').html("<table><tr><th>Delete</th><th>UserID</th><th>Username</th><th>Hashed Password</th><th>Change Role</th></tr></table>");
    for (let i = 0; i < data['users'].length; i++){
        let row = document.createElement("tr");
        row.innerHTML = `<td><button name="${data['users'][i]['user_id']}">Delete</button></td>
        <td>${data['users'][i]['user_id']}</td>
        <td>${data['users'][i]['username']}</td>
        <td>${data['users'][i]['password']}</td>
        <td><select name="role"></select></td>`;
        $('#users table').append(row);
    }
    for(let i = 0; i < roles.length; i++){
        $('#users select').append(`<option value="${roles[i]['role_id']}">${roles[i]['role_name']}</option>`);
    }
    
    for (let i = 0; i < data['users'].length; i++){
        $('#users select')[i].value = data['users'][i]['role_id'];
    }    
    $('#users button').click(DeleteUser);
    $('#users select').change(UpdateUser);
}
function UpdateUser(){
    var postData = {};
    postData['action'] = "updateUser";
    postData['userID'] = $(this).parent().prev().prev().prev().html();
    postData['roleID'] = $(this).val();
    AjaxRequest("service.php", "post", postData, "json", AddSuccess, AjaxError);
};

//allow user to be created. service will verify if change is allowed based on rank
function AddUser(){
    if($('#username').val() == "" || $('#password').val() == ""){
        alert("Username and password required");
        return;
    }
    var postData = {};
    postData['action'] = "addUser";
    postData['username'] = $('#username').val();
    postData['password'] = $('#password').val();
    postData['roleID'] = $('#role').val();
    AjaxRequest("service.php", "post", postData, "json", AddSuccess, AjaxError);
}
//reload table of users on success
function AddSuccess(data){
    if (data['result'] == "error"){ alert("Error : "+data['message']);}
    GetUsers();
}

//generic Ajax helper function
function AjaxRequest(url, method, data, dataType, successMethod, errorMethod) {   
    var options = {};
    options['url'] = url;
    options['method'] = method;
    options['data'] = data;
    options['dataType'] = dataType;
    options['success'] = successMethod;
    options['error'] = errorMethod;
    $.ajax(options);
}
//generic Ajax error handler
function AjaxError(request, status, errorMessage) {
    console.log(request);
    console.log(status);
    console.log(errorMessage);
}