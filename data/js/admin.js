function Admin() {
}

Admin.prototype.url_user_update = function (i) {
    return '/admin/user/' + i + '/update';
}

Admin.prototype._onUpdate = function (data, status, jqXHR) {
    if (data.code == 200) {
        toastr.info("Saved");
    }
}

window.Admin = new Admin();

window.User.update = function (id, login, pass, name, surname, level, is_active) {
    $.ajax({
        url: window.Admin.url_user_update(id),
        type: "POST",
        dataType: "json",
        data: {email: login, password: pass, name: name, surname: surname, level: level, isActive: is_active},
        success: window.Admin._onUpdate,
        error: function (data, status, jqXHR) {
            toastr.error(status);
        }
    });
}

//banner API
function Banner() {
}

Banner.prototype.url_update = function (id) {
    return "/banners/api/" + id + "/update";
};
Banner.prototype.url_delete = function (id) {
    return "/banners/api/" + id + "/delete";
};
Banner.prototype.url_create = "/banners/api/create";
Banner.prototype.url_set_common = "/banners/api/set-common";

Banner.prototype.create = function (hint, active, link, priority, text) {
    $.ajax({
        url: this.url_create,
        type: "POST",
        dataType: "json",
        data: {hint: hint, active: active, link: link, priority: priority, text: text},
        success: window.Banner._onCreate,
        error: function (data, status, jqXHR) {
            toastr.error(status);
        }
    });
};

Banner.prototype._onCreate = function (data, textStatus, jqXHR) {
    if (data.code == 200) {
        document.location = window.User.url_admin;
    } else {
        toastr.error("Banner creation error");
    }
};

Banner.prototype.update = function (id, hint, active, link, priority, text) {
    $.ajax({
        url: this.url_update(id),
        type: "POST",
        dataType: "json",
        data: {id: id, hint: hint, active: active, link: link, priority: priority, text: text},
        success: window.Banner._onUpdate,
        error: function (data, status, jqXHR) {
            toastr.error(status);
        }
    });
};

Banner.prototype.setCommon = function (dataObj) {
    $.ajax({
        url: this.url_set_common,
        type: "POST",
        dataType: "json",
        data: dataObj,
        success: window.Banner._onUpdate,
        error: function (data, status, jqXHR) {
            toastr.error(status);
        }
    });
};

Banner.prototype._onUpdate = function (data, textStatus, jqXHR) {
    if (data.code == 200) {
        toastr.success("Operation success");
    } else {
        toastr.error("Operation error");
    }
};

Banner.prototype.delete = function (id) {
    $.ajax({
        url: this.url_delete(id),
        type: "POST",
        dataType: "json",
        data: {id: id},
        success: window.Banner._onDelete,
        error: function (data, status, jqXHR) {
            toastr.error(status);
        }
    });
};

Banner.prototype._onDelete = function (data, textStatus, jqXHR) {
    window.Banner._onCreate(data, textStatus, jqXHR);
};

window.Banner = new Banner();