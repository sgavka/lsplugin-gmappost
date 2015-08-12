<?php

if (!class_exists('Plugin')) {
    die('Hacking attempt!');
}

class PluginGmappost extends Plugin
{
    protected $aInherits = array(
        'action' => array(
            'ActionAjax' => '_ActionAjax',
        ),
        'entity' => array(
            'ModuleTopic_EntityTopic' => '_ModuleTopic_EntityTopic',
        ),
        'module' => array(
            'ModuleTopic' => '_ModuleTopic',
        ),
        'mapper' => array(
            'ModuleTopic_MapperTopic' => '_ModuleTopic_MapperTopic',
        ),
    );

    public function Activate()
    {
        if (!$this->isFieldExists(Config::Get('db.table.topic'), 'topic_g_lng')) {
            $this->ExportSQL(dirname(__FILE__) . '/sql_dumps/install.sql');
        }

        return true;
    }

    public function Init()
    {
        $this->Viewer_AppendScript('https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=' .
            Config::Get('plugin.gmappost.google_api_key'));
        $this->Viewer_AppendScript(Plugin::GetTemplateWebPath(__CLASS__) . 'js/markerclusterer_compiled.js');
        $this->Viewer_AppendScript(Plugin::GetTemplateWebPath(__CLASS__) . 'js/gmappost.js');

        $this->Viewer_AppendStyle(Plugin::GetTemplateWebPath(__CLASS__) . 'css/styles.css');
    }
}