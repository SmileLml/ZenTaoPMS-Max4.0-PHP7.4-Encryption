<?php
class workflow extends control
{
    /**
     * Get apps by ajax.
     *
     * @param  string $exclude
     * @access public
     * @return void | array
     */
    public function ajaxGetApps($exclude = '')
    {
        $html = '';
        $apps = $this->workflow->getApps($exclude, false);
        foreach($apps as $app => $appName)
        {
            $html .= "<option value='{$app}'>{$appName}</option>";
        }
        die($html);
    }
}
