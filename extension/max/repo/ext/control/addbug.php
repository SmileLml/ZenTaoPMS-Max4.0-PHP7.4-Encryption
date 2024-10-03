<?php
helper::importControl('repo');;
class myRepo extends repo
{
    /**
     * addBug
     *
     * @param  int    $repoID
     * @param  string $file
     * @param  int    $v1
     * @param  int    $v2
     * @access public
     * @return void
     */
    public function addBug($repoID, $file, $v1, $v2)
    {
        if($this->get->repoPath) $file = $this->get->repoPath;
        if(!empty($_POST))
        {
            $result = $this->repo->saveBug($repoID, $file, $v1, $v2);
            if(dao::isError()) die(json_encode($result));

            $bugID    = $result['id'];
            $repo     = $this->repo->getRepoById($repoID);
            $entry    = $repo->name . '/' . $this->repo->decodePath($file);
            $location = sprintf($this->lang->repo->reviewLocation, $entry, $repo->SCM != 'Subversion' ? substr($v2, 0, 10) : $v2, $this->post->begin, $this->post->end);
            if(empty($v1))
            {
                $revision = $repo->SCM != 'Subversion' ? substr($v2, 0, 10) : $v2;
                $link = $this->repo->createLink('view', "repoID=$repoID&objectID=0&entry={$file}&revision=$v2&showBug=true", '', true) . '#L' . $this->post->begin;
            }
            else
            {
                $revision  = $repo->SCM != 'Subversion' ? substr($v1, 0, 10) : $v1;
                $revision .= ' : ';
                $revision .= $repo->SCM != 'Subversion' ? substr($v2, 0, 10) : $v2;
                $link = $this->repo->createLink('diff', "repoID=$repoID&objectID=0&entry={$file}&oldRevision=$v1&newRevision=$v2&showBug=true", '', true) . '#L' . $this->post->begin;
            }

            $actionID = $this->loadModel('action')->create('bug', $bugID, 'repoCreated', '', html::a($link, $location, '', "class='iframe'"));
            $this->loadModel('mail')->sendmail($bugID, $actionID);

            echo json_encode($result);
        }
    }
}
