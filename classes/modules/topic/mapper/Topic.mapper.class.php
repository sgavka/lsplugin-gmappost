<?php

class PluginGmappost_ModuleTopic_MapperTopic extends PluginGmappost_Inherit_ModuleTopic_MapperTopic
{
    public function UpdateGeoData($oTopic)
    {
        $sql = "UPDATE " . Config::Get('db.table.topic') . " AS _t
                SET _t.topic_g_lat = ?f,
                    _t.topic_g_lng = ?f
                WHERE
                    _t.topic_id = ?d ";

        $this->oDb->query($sql, $oTopic->getgLat(), $oTopic->getgLng(), $oTopic->getId());

        return true;
    }

    public function DeleteGeoData($oTopic)
    {
        $sql = "UPDATE " . Config::Get('db.table.topic') . " AS _t
                SET _t.topic_g_lat = NULL,
                    _t.topic_g_lng = NULL
                WHERE
                    _t.topic_id = ?d ";

        $this->oDb->query($sql, $oTopic->getId());

        return true;
    }

    public function getTopicsIdByBounds($iTopLeftX, $iTopLeftY, $iBotRightX, $iBotRightY)
    {
        $x1 = min($iTopLeftX, $iBotRightX);
        $x2 = max($iTopLeftX, $iBotRightX);
        $y1 = min($iTopLeftY, $iBotRightY);
        $y2 = max($iTopLeftY, $iBotRightY);

        $sql = "SELECT
                  _t.topic_id
                FROM " . Config::Get('db.table.topic') . " AS _t
                WHERE
                    _t.topic_g_lat >= ?f
                    AND _t.topic_g_lat < ?f
                    AND _t.topic_g_lng >= ?f
                    AND _t.topic_g_lng < ?f
                    AND _t.topic_publish = 1";

        $aTopicsId = array();
        if ($aRows = $this->oDb->select($sql, $x1, $x2, $y1, $y2)) {
            foreach ($aRows as $aTopic) {
                $aTopicsId[] = $aTopic['topic_id'];
            }
        }

        return $aTopicsId;
    }
}
