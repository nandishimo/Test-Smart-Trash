$(document).ready(() => {
    //on page load, query db for list of users
    CheckRank();
    GetRoles();
    //bind submit button to AddUser function
    $('button[type="submit"]').click(AddRole);
    $('#logout').click(Logout);
});
function CheckRank(){
    var postData = {};
    postData['action'] = "checkRank";
    AjaxRequest("service.php", "post", postData, "json", CheckSuccess, AjaxError);
}

function CheckSuccess(data){
    if(data['rank']=="nothing"){
        location.replace("login.php");
    }
    else if(data['rank']==10){
        location.replace("index.php");
    }
}

function Logout(){
    var postData = {};
    postData['action'] = "logout";
    AjaxRequest("service.php", "post", postData, "json", location.replace("login.php"), AjaxError);
}
function DeleteRole(){
    var postData = {};
    postData['action'] = "deleteRole";
    postData['roleID'] = $(this).parent().next().html();
    AjaxRequest("service.php", "post", postData, "json", DeleteSuccess, AjaxError);
}

function DeleteSuccess(data){
    if (data['result'] == "error"){ alert("Error : "+data['message']); GetRoles(); return;}
    alert(data['message']);
    GetRoles();
}

function GetRoles(){
    var postData = {};
    postData['action'] = "getRoles";
    AjaxRequest("service.php", "post", postData, "json", DisplayRoles, AjaxError);
}

//display list of roles, allow role name, description, and rank to be changed
//delete button to delete role
//service checks if change is allowed based on user rank
function DisplayRoles(data){
    if (data['result'] == "error"){ alert("Error : "+data['message']); return;}
    if (data['result'] != "success"){ alert("Unknown response from server"); return;}
    $('#roles').html("<table><tr><th>Delete</th><th>RoleID</th><th>Role Name</th><th>Description</th><th>Rank</th></tr></table>");
    for (let i = 0; i < data['roles'].length; i++){
        let row = document.createElement("tr");
        row.innerHTML = `<td><button class="delete" name="${data['roles'][i]['role_id']}">Delete</button></td>
        <td>${data['roles'][i]['role_id']}</td>
        <td><input type='text' value='${data['roles'][i]['role_name']}'></td>
        <td><input type='text' value='${data['roles'][i]['role_description']}'></td>
        <td><select value="10">
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
        <option value="10">10</option></select></td>
        <td><button class="update">Update</button></td>`;
        $('#roles table').append(row);
        $('#roles select')[i].value = data['roles'][i]['role_rank'];
    }
    $('.delete').click(DeleteRole);
    $('.update').click(ChangeRole);
}
function ChangeRole(){
    var postData = {};
    postData['action'] = "changeRole";
    postData['roleID'] = $(this).parent().prev().prev().prev().prev().html();
    postData['roleName'] = $(this).parent().prev().prev().prev().children().val();
    postData['roleDesc'] = $(this).parent().prev().prev().children().val();
    postData['roleRank'] = $(this).parent().prev().children().val();
    AjaxRequest("service.php", "post", postData, "json", AddSuccess, AjaxError);
};

//add a new role, role name is required, creds are validated on service side
function AddRole(){
    if($('#roleName').val() == ""){
        alert("Role name is required");
        return;
    }
    var postData = {};
    postData['action'] = "addRole";
    postData['roleName'] = $('#roleName').val();
    postData['roleDesc'] = $('#roleDesc').val();
    postData['roleRank'] = $('#rank').val();
    AjaxRequest("service.php", "post", postData, "json", AddSuccess, AjaxError);
}
//reload table of roles on success
function AddSuccess(data){
    if (data['result'] == "error"){ alert("Error : "+data['message']);}
    GetRoles();
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