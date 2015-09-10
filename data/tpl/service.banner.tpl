{if isset($banner.id)}
    <form id="image-banner-{$banner.id}" enctype="multipart/form-data" method="POST"
          action="/banners/api/{$banner.id}/set-image" target="_blank">
        <span id="helpBlock"
              class="help-block">{if strlen($banner.filename)>0}This banner image file is "{htmlspecialchars($banner.filename)}"{/if}</span>

        <div class="form-group">
            <label for="banner-file-input">Attach image file</label>
            <input type="file" name="imagefile" id="banner-file-input-{$banner.id}">

            <p class="help-block">Please upload 250x50 image files</p>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-success" value="Attach image file">
        </div>
    </form>
{/if}

<form id="edit-banner-{$banner.id}">

    <div class="form-group">
        <label for="banner-hint-{$banner.id}">Hint</label>
        <input type="text" class="form-control" id="banner-hint-{$banner.id}" placeholder="Enter hint"
               value="{$banner.hint}">
    </div>
    <div class="form-group">
        <label for="banner-text-{$id}">Text</label>
        <input type="text" class="form-control" id="banner-text-{$banner.id}" value="{$banner.text}"
               placeholder="Enter text">
    </div>
    <div class="form-group">
        <label for="banner-priority-{$id}">Priority</label>
        <input type="number" min="0" max="1000" class="form-control" id="banner-priority-{$banner.id}"
               value="{$banner.priority}" placeholder="Enter banner priority">
        <span id="helpBlock" class="help-block">Banner priority sets seed for random numbers generator. Even if you set maximum priority for the banner, It will not guarantee that this banner will be displayed firstly always. Seed sets display frequency for banner, but of course, it has indirect influence on banner position.</span>
    </div>
    <div class="form-group">
        <label for="banner-link-{$banner.id}">Link</label>
        <input type="text" class="form-control" id="banner-link-{$banner.id}" value="{$banner.href}"
               placeholder="Enter banner link">
    </div>


    <div class="checkbox">
        <label><input type="checkbox" id="banner-is-active-{$banner.id}" {if $banner.active}checked{/if}>Active?</label>
        <span id="helpBlock" class="help-block">Disabled banners will not be displayed.</span>
    </div>

    <div class="form-group">
        {if isset($banner.id)}
            <a class="btn btn-success"
               onclick="window.Banner.update({$banner.id}, $('#banner-hint-{$banner.id}').val(),$('#banner-is-active-{$banner.id}').is(':checked'),$('#banner-link-{$banner.id}').val(),$('#banner-priority-{$banner.id}').val(),$('#banner-text-{$banner.id}').val());">Save</a>
            <a class="btn btn-danger" onclick="window.Banner.delete({$banner.id});">Delete</a>
        {else}
            <a class="btn btn-success"
               onclick="window.Banner.create($('#banner-hint-{$banner.id}').val(),$('#banner-is-active-{$banner.id}').is(':checked'),$('#banner-link-{$banner.id}').val(),$('#banner-priority-{$banner.id}').val(),$('#banner-text-{$banner.id}').val());">Create
                banner</a>
        {/if}
    </div>
</form>