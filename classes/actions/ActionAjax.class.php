<?php

class PluginGmappost_ActionAjax extends PluginGmappost_Inherit_ActionAjax
{

    protected function RegisterEvent()
    {
        parent::RegisterEvent();

        $this->AddEvent('g_map', 'EventGMap');
    }

    public function EventGMap()
    {
        $iTopLeftX = getRequest('x1', false);
        $iTopLeftY = getRequest('y1', false);
        $iBotRightX = getRequest('x2', false);
        $iBotRightY = getRequest('y2', false);

        if ($iTopLeftX == false || $iTopLeftY == false || $iBotRightX == false || $iBotRightY == false) {
            $this->Viewer_SetResponseAjax(json_encode(array(
                    'result' => 'error',
                    'message' => 'some error'
                )
            ));

            return;
        }

        $aTopicId = $this->Topic_getTopicsIdByBounds($iTopLeftX, $iTopLeftY, $iBotRightX, $iBotRightY);
        $aTopic = $this->Topic_GetTopicsAdditionalData($aTopicId, array('blog' => array('owner' => array()), 'vote'));
        $aTopicData = array();
        /** @var ModuleTopic_EntityTopic $oTopic */
        foreach ($aTopic as $oTopic) {
            $aTopicData[] = array(
                't_id' => $oTopic->getId(),
                'gps' => array(
                    round($oTopic->getgLat(), 8),
                    round($oTopic->getgLng(), 8)
                ),
                'url' => $oTopic->getUrl(),
                'name' => $oTopic->getTitle(),
            );
        }

        $this->Viewer_SetResponseAjax('json');
        $this->Viewer_AssignAjax('data', $aTopicData);
    }

}

