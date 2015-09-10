{extends file="email.tpl"}
{block name="title"}{t}Drive password reset{/t}{/block}
{block name="body"}
    {t}your new password: {/t}<b>{$password}</b>
{/block}