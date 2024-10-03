<?php
helper::importControl('todo');
class myTodo extends todo
{
    public function create($date = 'today', $userID = '', $from = 'todo', $param = '')
    {
        if($userID == '') $userID = $this->app->user->id;
        $user = $this->loadModel('user')->getById($userID, 'id');

        if($from == 'feedback' or $this->post->type == 'feedback')
        {
            if(!empty($_POST))
            {
                $todoID = $this->todo->create($date, $user->account);
                if(dao::isError()) die(js::error(dao::getError()));

                $this->loadModel('action')->create('todo', $todoID, 'FromFeedback', '', $this->post->feedback);

                $date = str_replace('-', '', $this->post->date);
                if($date == '')
                {
                    $date = 'future';
                }
                elseif($date == date('Ymd'))
                {
                    $date = 'today';
                }

                if(!empty($_POST['idvalue'])) return $this->send(array('result' => 'success'));

                if($this->app->getViewType() == 'xhtml') die(js::locate($this->createLink('todo', 'view', "todoID=$todoID"), 'parent'));
                if(isonlybody()) die(js::reload('parent.parent'));
                $location = $this->createLink('feedback', 'adminView', "feedbackID={$this->post->feedback}");
                die(js::locate($location, 'parent'));
            }

            $feedbackID = $param ? $param : 0;
            $feedback   = $this->loadModel('feedback')->getByID($feedbackID);
            $actions    = $this->loadModel('action')->getList('feedback', $feedbackID);
            foreach($actions as $action)
            {
                if($action->action == 'reviewed' and $action->comment)
                {
                    $feedback->desc .= $feedback->desc ? '<br/>' . $this->lang->feedback->reviewOpinion . '：' . $action->comment : $this->lang->feedback->reviewOpinion . '：' . $action->comment;
                }
            }

            /* Set Menu. */
            $this->lang->feedback->menu->browse['subModule'] = 'todo';

            $this->view->feedback = $feedback;
        }

        parent::create($date, $userID, $from);
    }
}
