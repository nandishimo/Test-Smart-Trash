$(document).ready(function() {

    $("#testGET").click(TestGET);
    $("#testPOST").click(TestPOST);
    $("#testPUT").click(TestPUT);
    $("#testDELETE").click(TestDELETE);

});

function Filter(){
    var filter = $("#filter").val();
    var url = "REST/example/place/" + filter;
    AjaxRequest(url, "GET", data, "json", FilterSuccess, AjaxError);
}

function FilterSuccess(data)
{

}

function AjaxRequest(url, method, data, dataType, success, error){
    var options = {};
    options['url'] = url;
    options['method'] = method;
    options['data'] = data;
    options['dataType'] = dataType;
    options['success'] = success;
    options['error'] = error;
    $.ajax(options);
}

//generic Ajax error handler
function AjaxError(request, status, errorMessage) {
    console.log(request);
    console.log(status);
    console.log(errorMessage);
}

// HTTP/1.1 methods:    POST    GET        Put      DELETE
// CRUD Operation:      Create  Retrieve   Update   Delete
// SQL Operation:       insert  select     update   delete

function TestDELETE() {

    var deleteData = {};
    deleteData["DELETEtest"] = "This is data in the DELETE object.";

    var options = {};
    options["method"] = "DELETE";
    options["url"] = "REST/example/place/11";
    options["dataType"] = "json";
    options["data"] = deleteData;
    options["success"] = successCallback;
    options["error"] = errorCallback;
    $.ajax(options);

};

function TestPUT() {

    var putData = {};
    putData["PUTtest"] = "This is data in the PUT object.";

    var options = {};
    options["method"] = "PUT";
    options["url"] = "REST/example/place/20";
    options["dataType"] = "json";
    options["data"] = putData;
    options["success"] = successCallback;
    options["error"] = errorCallback;
    $.ajax(options);

};

function TestPOST() {

    var postData = {};
    postData["POSTtest"] = "This is data in the POST object.";

    var options = {};
    options["method"] = "POST";
    options["url"] = "REST/example/place/30";
    options["dataType"] = "json";
    options["data"] = postData;
    options["success"] = successCallback;
    options["error"] = errorCallback;
    $.ajax(options);

};

function TestGET() {

    var getData = {};
    getData["GETtest"] = "This is data in the GET object.";

    var options = {};
    options["method"] = "GET";
    options["url"] = "REST/example/place/40";
    options["dataType"] = "json";
    options["data"] = getData;
    options["success"] = successCallback;
    options["error"] = errorCallback;
    $.ajax(options);

};

function successCallback(returnedData) {

    console.log(returnedData);
    $("#output").html(returnedData);
};



function errorCallback(jqObject, returnedStatus, errorThrown) {
    console.log(returnedStatus + " : " + errorThrown);


};