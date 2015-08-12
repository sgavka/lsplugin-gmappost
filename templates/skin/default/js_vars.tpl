<script type="text/javascript">
    {literal}
    var pageMap = {/literal}{$oConfig->GetValue('plugin.gmappost.page.map')|json_encode}{literal};

    var pageTopicAdd = {/literal}{$oConfig->GetValue('plugin.gmappost.page.topicAdd')|json_encode}{literal};

    var tileLayers = {/literal}{$oConfig->GetValue('plugin.gmappost.tile_layers')|json_encode}{literal};
    {/literal}

    jQuery(document).ready (function ($) {
        ls.lang.load ({lang_load name="plugin.gmappost.add_marker,plugin.gmappost.delete_marker"});
    });
</script>
