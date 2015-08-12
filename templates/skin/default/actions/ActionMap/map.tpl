{include file='header.tpl' }

<div id="gmap-map-page"></div>
{if $oConfig->GetValue('plugin.gmappost.page.map.autocomplete')}
    <input id="gmap-input" class="controls" type="text" placeholder="{$aLang.plugin.gmappost.enter_location}">
{/if}

{include file='footer.tpl'}