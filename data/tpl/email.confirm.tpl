{extends file="email.tpl"}
{block name="title"}{t}Drive E-mail confirmation{/t}{/block}
{block name="body"}
    {$user.name} {$user.lastname},
    <br>
    {t}to confirm your e-mail use this link: {/t}<a href="{$baseURL}/api/user/activate/{$user.id}/{$hash}">{$baseURL}
    /api/user/activate/{$user.id}/{$hash}</a>
{/block}