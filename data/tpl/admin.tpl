{extends file="main.tpl"}
{block name="scripts"}
    <script src="{$js}admin.js"></script>
{/block}
{block name="body"}
    <div class="container">
        <div class="page-header">
            <h1>Administration</h1>
        </div>
        <h2>Banners</h2>

        <div class="panel-group" id="accordion-banners" role="tablist" aria-multiselectable="true">
            {foreach from=$banners item=banner}
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading-banner{$banner.id}">
                        <h4 class="panel-title">
                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion-banners"
                               href="#collapse-banner{$banner.id}" aria-expanded="true"
                               aria-controls="collapse-banner{$banner.id}">
                                <i class="glyphicon {if $banner.active}glyphicon-eye-open{else}glyphicon-eye-close{/if}"></i>&nbsp;{$banner.hint}
                                ({$banner.href})
                            </a>
                        </h4>
                    </div>
                    <div id="collapse-banner{$banner.id}" class="panel-collapse collapse" role="tabpanel"
                         aria-labelledby="heading-banner{$banner.id}">
                        <div class="panel-body">
                            {include file="service.banner.tpl" banner=$banner}
                        </div>
                    </div>
                </div>
            {/foreach}
        </div>
        {include file="service.new-banner.tpl"}

        <h2>Users</h2>

        <div class="panel-group" id="accordion-users" role="tablist" aria-multiselectable="true">
            {foreach from=$users item=user}
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading{$user.id}">
                        <h4 class="panel-title">
                            <a class="collapsed" data-toggle="collapse" data-parent="#accordion-users"
                               href="#collapse{$user.id}" aria-expanded="true" aria-controls="collapse{$user.id}">
                                <i class="glyphicon glyphicon-hand-right"></i>&nbsp;{$user.name} {$user.surname}
                                ({$user.id})
                            </a>
                        </h4>
                    </div>
                    <div id="collapse{$user.id}" class="panel-collapse collapse" role="tabpanel"
                         aria-labelledby="heading{$user.id}">
                        <div class="panel-body">
                            {include file="service.profile.tpl" email=$user.email name=$user.name surname=$user.surname level=$user.level id=$user.id isActive=$user.isActive admin=true}
                        </div>
                    </div>
                </div>
            {/foreach}
        </div>
    </div>
{/block}