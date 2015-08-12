{*{include file=$aTemplatePathPlugin.geopost|cat:'js_vars.tpl'}*}
<div>
    <a href="javascript://" class="gmap-btn button button-primary" id="gmap-btn">{if $geopost_lat && $geopost_lng}{$aLang.plugin.gmappost.delete_marker}{else}{$aLang.plugin.gmappost.add_marker}{/if}</a>
</div>

<div id="gmap-showmap" class="gmap-slow-showmap{if $geopost_lat && $geopost_lng} active{/if}">
    <input type="hidden" value="{$geopost_lat}" name="lat"/>
    <input type="hidden" value="{$geopost_lng}" name="lng"/>
    <div id="gmap-map-topic"></div>

    {if $oConfig->GetValue('plugin.gmappost.page.topicAdd.autocomplete')}
        <input id="gmap-input" class="controls" type="text" placeholder="{$aLang.plugin.gmappost.enter_location}">
    {/if}
</div>