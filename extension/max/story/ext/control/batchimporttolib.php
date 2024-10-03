<?php
class myStory extends story
{
    /**
     * Batch import to lib.
     *
     * @access public
     * @return void
     */
    public function batchImportToLib()
    {
        $storyIDList = $this->post->storyIdList;
        $this->story->importToLib($storyIDList);
        if(dao::isError()) return $this->send(array('result' => 'fail', 'message' => dao::getError()));

        return $this->send(array('result' => 'success', 'message' => $this->lang->importSuccess, 'locate' => 'reload'));
    }
}
