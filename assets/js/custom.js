form = document.getElementById("custom-form");
addEvent(form, "submit", function(){
    var a = ajax;
    a.url = form.action;
    a.data = a.serialize(form);
    a.success = function (response, x){
        /*parse json response*/
        var data = JSON.parse(response);
        /*remove text from error fields*/
        var els = form.getElementsByClassName("error");
        for (var i = 0; i < els.length; i++){
            els[i].innerText = "";
        }
        if (data.success){
            form.reset();
            alert(data.msg);
        }else{
            for (property in data.errors){
                console.log("error-"+property);
                console.log(data.errors[property]);
                document.getElementsByClassName("error-"+property)[0].innerText = data.errors[property]["msg"];
            }
        }



    }
    /*Send request*/
    a.send();

    return false;
})
