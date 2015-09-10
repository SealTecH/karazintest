<form id="edit-profile-{$id}">
    <div class="form-group">
        <label for="email-{$id}">Email address</label>
        <input type="email" class="form-control" id="email-{$id}" placeholder="Enter email" value="{$email}">
    </div>
    <div class="form-group">
        <label for="password-{$id}" class="text-danger">Password</label>
        <input type="password" class="form-control" id="password-{$id}" placeholder="Enter new password to change">
    </div>
    <hr>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="name-{$id}">Name</label>
                <input type="text" class="form-control" id="name-{$id}" placeholder="Name" value="{$name}">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="surname-{$id}">Surname</label>
                <input type="text" class="form-control" id="surname-{$id}" placeholder="Surname" value="{$surname}">
            </div>
        </div>
    </div>

    <div class="form-group">
        <label for="leve-{$id}l">Access level</label>
        <input type="text" class="form-control" id="level-{$id}" value="{$level}" {if !isset($admin)}disabled{/if}>
        {if !isset($admin)}<span id="helpBlock" class="help-block">You cannot change your access level. It can be edited by system administrator only</span>{/if}
    </div>

    {if isset($admin)}
        <div class="checkbox">
            <label><input type="checkbox" id="is_active-{$id}" {if $isActive=="1"}checked{/if}>Active?
        </div>
    {/if}

    <div class="form-group"><a class="btn btn-success"
                               onclick="window.User.update({$id}, $('#email-{$id}').val(),$('#password-{$id}').val(),$('#name-{$id}').val(),$('#surname-{$id}').val(),$('#level-{$id}').val(),$('#is_active-{$id}').is(':checked'));">Save
            profile</a>
        {if !isset($admin)}<a class="btn btn-warning" onclick="window.User.logout();">Log out</a>{/if}
    </div>

</form>