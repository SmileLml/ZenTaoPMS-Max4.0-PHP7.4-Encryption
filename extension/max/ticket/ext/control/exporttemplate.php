<?php
helper::importControl('ticket');
class myticket extends ticket
{
    /**
     * Export template.
     *
     * @access public
     * @return void
     */
    public function exportTemplate()
    {
        if($_POST)
        {
            $this->ticket->setListValue();
            $this->fetch('transfer', 'exportTemplate', 'model=ticket');
        }

        $this->loadModel('transfer');

        $this->display();
    }
}