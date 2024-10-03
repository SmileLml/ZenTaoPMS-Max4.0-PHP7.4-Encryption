<?php
class admin extends control
{
    public function license()
    {
        $ioncubeProperties = array();
        if(function_exists('ioncube_license_properties'))
        {
            $properties = ioncube_license_properties();

            if($properties)
            {
                foreach($properties as $key => $property) $ioncubeProperties[$key] = $property['value'];
            }
        }

        $this->view->title      = $this->lang->admin->license;
        $this->view->position[] = $this->lang->admin->license;

        $this->view->ioncubeProperties = $ioncubeProperties;
        $this->display();
    }
}
