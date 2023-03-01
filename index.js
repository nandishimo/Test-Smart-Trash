$(document).ready(() => {
    //on page load, bind submit button to Login function
    $('#userM').hide();
    $('#roleM').hide();
    CheckRank();
});

//check login status and rank
function CheckRank(){
    var postData = {};
    postData['action'] = "checkRank";
    AjaxRequest("service.php", "post", postData, "json", CheckSuccess, AjaxError);
}

//if user is not logged in, boot them back to login page
//if user is lowest rank (10), keep usermanagement and role management hidden
function CheckSuccess(data){
    if(data['rank']=="nothing"){
        location.replace("login.php");
    }
    else if(data['rank']<10){
        $('#userM').show();
        $('#roleM').show();
    }
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