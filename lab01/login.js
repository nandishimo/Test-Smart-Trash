$(document).ready(() => {
    //on page load, bind submit button to Login function
    $('button[type="submit"]').click(Login);
});

function Login(){
    if($('#username').val() == "" || $('#password').val() == ""){
        alert("Username and password required");
        return;
    }
    var postData = {};
    postData['action'] = $('.form').children('input[type="hidden"]').attr('name');
    postData['username'] = $('.form').children('input[name="username"]').val();
    postData['password'] = $('.form').children('input[name="password"]').val();
    AjaxRequest("service.php", "post", postData, "json", LoginSuccess, AjaxError);
}

//alert user of login result and redirect to home page if successful
function LoginSuccess(data){
    if(data['result'] == "error"){
        alert("Error : "+data['message']);
    }
    else if(data['result'] == "success"){
        alert(data['message']);
        location.replace("index.php");
        
    }
    else{
        alert("Unknown response from server");
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