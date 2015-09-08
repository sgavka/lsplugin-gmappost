<?php

class PluginGmappost_ModuleTopic extends PluginGmappost_Inherit_ModuleTopic
{
    public function UpdateGeoData($oTopic)
    {
        if (is_null($oTopic->getgLat()) && is_null($oTopic->getgLng())) {
            return $this->oMapperTopic->DeleteGeoData($oTopic);
        }

        return $this->oMapperTopic->UpdateGeoData($oTopic);
    }

    public function getTopicsIdByBounds($iTopLeftX, $iTopLeftY, $iBotRightX, $iBotRightY)
    {
        return $this->oMapperTopic->getTopicsIdByBounds($iTopLeftX, $iTopLeftY, $iBotRightX, $iBotRightY);
    }
}
