<?php

class PluginGmappost_ActionMap extends ActionPlugin
{
    protected $oUserCurrent = null;
    protected $sMenuHeadItemSelect = 'map';
    protected $sMenuItemSelect = 'map';
    protected $sMenuSubItemSelect = 'map';

    public function Init()
    {
    }

    protected function RegisterEvent()
    {
        $this->AddEvent('index', 'EventMap');
        $this->SetDefaultEvent('index');
    }

    protected function EventMap()
    {
        $this->Viewer_Assign('noSidebar', true);
        $this->Viewer_AddHtmlTitle($this->Lang_Get('plugin.gmappost.map_menu'));
        $this->SetTemplateAction('map');
    }

    public function EventShutdown()
    {
        $this->Viewer_Assign('sMenuHeadItemSelect', $this->sMenuHeadItemSelect);
        $this->Viewer_Assign('sMenuItemSelect', $this->sMenuItemSelect);
        $this->Viewer_Assign('sMenuSubItemSelect', $this->sMenuSubItemSelect);
    }
}