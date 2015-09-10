$(document).ajaxcom('[ajaxed]');

function User() {
}

User.prototype.url_auth = '/api/user/login';
User.prototype.url_logout = '/api/user/logout';
User.prototype.url_update = '/api/user/update';
User.prototype.url_signup = '/api/user/signup';
User.prototype.url_admin = '/admin';


User.prototype._onLogin = function (data, textStatus, jqXHR) {
    if (data.code == 200) {
        document.location = window.User.url_admin;
    } else {
        toastr.error("Login error");
    }
}

User.prototype._onUpdate = function (data, textStatus, jqXHR) {
    window.User._onLogin(data, textStatus, jqXHR);
}

User.prototype._onLogout = function (data, textStatus, jqXHR) {
    window.User._onLogin(data, textStatus, jqXHR);
}

User.prototype._onSignup = function (data, textStatus, jqXHR) {
    if (data.code == 200) {
        toastr.info(window.Language.msg_registration_ok, window.Language.msg_success);
        setTimeout(function () {
            window.User._onLogin(data, textStatus, jqXHR);
        }, 5000);
        return;
    }
    window.User._onLogin(data, textStatus, jqXHR);
}

User.prototype.login = function (login, pass) {
    $.ajax({
        url: this.url_auth,
        type: "POST",
        dataType: "json",
        data: {email: login, password: pass},
        success: window.User._onLogin,
        error: function (data, status, jqXHR) {
            toastr.error(status);
        }
    });
}

User.prototype.update = function (id, login, pass, name, surname, level, is_active) {
    $.ajax({
        url: this.url_update,
        type: "POST",
        dataType: "json",
        data: {email: login, password: pass, name: name, surname: surname},
        success: window.User._onUpdate,
        error: function (data, status, jqXHR) {
            toastr.error(status);
        }
    });
}

User.prototype.logout = function () {
    $.ajax({
        url: this.url_logout,
        type: "POST",
        dataType: "json",
        data: {},
        success: window.User._onLogout,
        error: function (data, status, jqXHR) {
            toastr.error(status);
        }
    });
}

User.prototype.signup = function (email, password, name, lastname) {
    $.ajax({
        url: this.url_signup,
        type: "POST",
        dataType: "json",
        data: {email: email, password: password, name: name, lastname: lastname},
        success: window.User._onSignup,
        error: function (data, status, jqXHR) {
            toastr.error(status);
        }
    });
}


window.User = new User();