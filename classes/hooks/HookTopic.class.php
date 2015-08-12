<?php

class PluginGmappost_HookTopic extends Hook
{
    public function RegisterHook()
    {
        $this->AddHook('template_form_add_topic_topic_end', 'TemplateFormAddTopicBegin', __CLASS__);
        $this->AddHook('template_form_add_topic_question_end', 'TemplateFormAddTopicBegin', __CLASS__);
        $this->AddHook('template_form_add_topic_link_end', 'TemplateFormAddTopicBegin', __CLASS__);
        $this->AddHook('template_form_add_topic_photoset_end', 'TemplateFormAddTopicBegin', __CLASS__);

        $this->AddHook('template_html_head_end', 'AddJS', __CLASS__);

        $this->AddHook('topic_add_after', 'TopicSubmitAfter', __CLASS__);
        $this->AddHook('topic_edit_after', 'TopicSubmitAfter', __CLASS__);

        $this->AddHook('template_main_menu_item', 'TemplateMainMenuItem', __CLASS__);
    }

    public function AddJS()
    {
        return $this->Viewer_Fetch(Plugin::GetTemplatePath('gmappost') . 'js_vars.tpl');
    }

    public function TemplateMainMenuItem()
    {
        return $this->Viewer_Fetch(Plugin::GetTemplatePath('gmappost') . 'main_menu_item.tpl');
    }

    public function TemplateFormAddTopicBegin()
    {
        $iTopicId = getRequest('topic_id');
        $oTopic = $this->Topic_GetTopicById($iTopicId);

        if ($oTopic) {
            $lat = $oTopic->getgLat();
            $long = $oTopic->getgLong();
        } else {
            $lat = 0;
            $long = 0;
        }

        $this->Viewer_Assign('geopost_lat', $lat);
        $this->Viewer_Assign('geopost_lng', $long);

        return $this->Viewer_Fetch(Plugin::GetTemplatePath('gmappost') . 'actions/ActionTopic/form_edit_topic.tpl');
    }

    public function TopicSubmitAfter($data)
    {
        $lat = (float)getRequest('lat', 0);
        $long = (float)getRequest('lng', 0);

        $oTopic = $data['oTopic'];
        if ($lat && $long) {
            $oTopic->setgLat($lat);
            $oTopic->setgLong($long);
        } else {
            $oTopic->setgLat(null);
            $oTopic->setgLong(null);
        }
        $this->Topic_UpdateGeoData($oTopic);
    }
}