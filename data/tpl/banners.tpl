{extends file="main.tpl"}
{block name="body"}
    <div class="center-container">
        <div id="container">
            <div id="logo"></div>
            {foreach from=$banners item=banner}
                <a class="banner" href="{$banner.href}" title="{$banner.hint}">
                    <div class="banner" style="background-image: url('{$images}banners/{$banner.filename}');">
                        <div class="banner-overlay">
                            <div class="banner-text">{$banner.text}</div>
                        </div>
                    </div>
                </a>
            {/foreach}
        </div>
    </div>
{/block}