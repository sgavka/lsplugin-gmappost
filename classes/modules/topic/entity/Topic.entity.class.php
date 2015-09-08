<?php

class PluginGmappost_ModuleTopic_EntityTopic extends PluginGmappost_Inherit_ModuleTopic_EntityTopic
{
    public function setgLat($coord)
    {
        $this->_aData['topic_g_lat'] = $coord;
    }

    public function setgLng($coord)
    {
        $this->_aData['topic_g_long'] = $coord;
    }
}
