{extends file="main.tpl"}
{block name="body"}
    <div class="container">
        <div class="page-header">
            <h1>Error uploading image</h1>
        </div>
        <p>There was error while your banner image uploading.</p>

        <p>Please note, that you have to upload valid images, which supported by your server. This application needs GD2
            library and list of supported image types depends on your library capabilities.</p>

        <p>Also you have to upload <b>250x50px images only</b>.</p>
    </div>
{/block}