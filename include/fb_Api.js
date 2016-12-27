function getUserData() {
    FB.api('/me',{fields: 'id,name,email'}, function(response) {
        var id = response.id;
        var name = response.name;
        var email = response.email;
        checkUser(id,name,email);
        //console.log(name+email+id);
    });
}

window.fbAsyncInit = function() {
    //SDK loaded, initialize it
    FB.init({
        appId      : '945163155612764',
        xfbml      : true,
        version    : 'v2.2'
    });

    //check user session and refresh it
    FB.getLoginStatus(function(response) {
        if (response.status === 'connected') {
            //user is authorized
            document.getElementById('loginBtn').style.display = 'none';
            document.getElementById('loginOut').style.display = 'block';
            getUserData();
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
    js.src = "//connect.facebook.com/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

//add event listener to login button
document.getElementById('loginBtn').addEventListener('click', function() {
    //do the login
    FB.login(function(response) {
        if (response.authResponse) {
            //user just authorized your app
            document.getElementById('loginBtn').style.display = 'none';
            document.getElementById('loginOut').style.display = 'block';
            getUserData();
        }
    }, {scope: 'email,user_photos,user_videos', return_scopes: true});
}, false);


function fbLogout() {
    FB.logout(function(){document.location.reload();});
}
function checkUser(fb_id,fb_name,fb_email) {
    var id = fb_id;
    var name = fb_name;
    var email = fb_email;
    console.log(name+email+id);

    $.post('check_user.php',{id:id,name:name,email:email},
        function (response) {
            console.log(response);
            if(response == 0)
                console.log('Error');
            else if(response == 1)
                console.log(response);
        });

}