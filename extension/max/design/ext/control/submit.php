<?php
class myDesign extends design
{
    public function submit($productID = 0)
    {
        if($_POST)
        {
            $reviewRange = $this->post->range;
            $object      = $this->post->object;
            $product     = $this->loadModel('product')->getByID($productID);
            $projectID   = !empty($product->project) ? $product->project : $this->session->project;
            $checkedItem = $reviewRange == 'all' ? '' : $this->cookie->checkedItem;
            unset($_GET['onlybody']);

            die(js::locate($this->createLink('review', 'create', "project={$projectID}&object=$object&productID=$productID&reviewRange=$reviewRange&checkedItem={$checkedItem}"), 'parent.parent'));
        }

        $this->display();
    }
}
