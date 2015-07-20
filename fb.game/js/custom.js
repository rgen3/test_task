function getUserData() {
    FB.api('/me', function(response) {
        console.log(response);
        var userId = response.id,
            gender = response.gender,
            lastName = response.last_name,
            name     = response.name;
        $.ajax({
            url : "creator.php",
            data: response,
            method: "POST",
            success: function(data){

            }
        });
    });
}

window.fbAsyncInit = function() {
    //SDK loaded, initialize it
    FB.init({
        appId      : '432343876946616',
        xfbml      : true,
        version    : 'v2.2'
    });

    //check user session and refresh it
    FB.getLoginStatus(function(response) {
        if (response.status === 'connected') {
            $(document).on("click", ".fbLoginBtn", function(){
                getUserData();
            });
        } else {
            //user is not authorized
        }
    });
};

//load the JavaScript SDK
(function(d, s, id){
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) {return;}
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

//add event listener to login button
fbLoginOnClick = function() {
    //do the login
    FB.login(function(response) {
        if (response.authResponse) {
            //user just authorized your app
            document.getElementById('loginBtn').style.display = 'none';
            getUserData();
        }
    }, {scope: 'email,public_profile', return_scopes: true});
};

