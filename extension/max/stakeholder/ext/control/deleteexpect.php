<?php
class myStakeholder extends stakeholder
{
	/** 
	 * Deleted expect.
	 *
	 * @access public
	 * @param  int    $expectID
	 * @param  string $confirm  yes|no
	 * @return void
	 */
	public function deleteExpect($expectID, $confirm = 'no')
	{   
		if($confirm == 'no')
		{   
			die(js::confirm($this->lang->stakeholder->confirmDeleteExpect, inLink('deleteExpect', "expectID=$expectID&confirm=yes")));
		}   
		else
		{   
			$this->stakeholder->deleteExpect($expectID);
			die(js::reload('parent'));
		}   
	}
}
