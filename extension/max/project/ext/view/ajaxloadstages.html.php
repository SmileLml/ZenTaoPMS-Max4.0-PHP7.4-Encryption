<table class='table table-form'>
  <thead>
    <tr>
      <th class='c-id'><?php echo $lang->idAB;?></th>
      <th class='required'><?php echo $lang->stage->name;?></th>
      <th class='c-user'><?php echo $lang->programplan->PM;?></th>
      <th class='w-150px'><?php echo $lang->programplan->percent;?></th>
      <th class='c-type'><?php echo $lang->programplan->attribute;?></th>
      <th class='c-date required'><?php echo $lang->programplan->begin;?></th>
      <th class='c-date required'><?php echo $lang->programplan->end;?></th>
      <th class='c-acl'><?php echo $lang->programplan->acl;?></th>
      <th class='w-110px'><?php echo $lang->programplan->milestone;?></th>
    </tr>
  </thead>
  <tbody>
      <?php foreach($stageIdList as $stageID):?>
      <tr>
        <td><?php echo sprintf('%03d', $stageID) . html::hidden("executionIDList[$productID][$stageID]", $stageID);?></td>
        <td title='<?php echo $executions[$stageID]->name;?>'><?php echo html::input("names[$productID][$stageID]", $executions[$stageID]->name, "class='form-control'");?></td>
        <td><?php echo html::select("PMs[$productID][$stageID]", $users, $executions[$stageID]->PM, "class='form-control picker-select'");?></td>
        <td>
          <div class='input-group'>
            <input type='text' name='percents[<?php echo $productID;?>][<?php echo $stageID;?>]' id='percent<?php echo $stageID;?>' value='<?php echo $executions[$stageID]->percent;?>' class='form-control'/>
            <span class='input-group-addon'>%</span>
          </div>
        </td>
        <td class=''><?php echo html::select("attributes[$productID][$stageID]", $lang->stage->typeList, $executions[$stageID]->attribute, "class='form-control'");?></td>
        <td><?php echo html::input("begins[$productID][$stageID]", '', "id='begins{$stageID}' class='form-control form-date'");?></td>
        <td><?php echo html::input("ends[$productID][$stageID]", '', "id='ends{$stageID}' class='form-control form-date'");?></td>
        <td class=''><?php echo html::select("acl[$productID][$stageID]", $lang->execution->aclList, 'open', "class='form-control'");?></td>
        <td class='text-center'><?php echo html::radio("milestone[$productID][$stageID]", $lang->programplan->milestoneList, 0);?></td>
        <?php echo html::hidden("parents[$productID][$stageID]", $executions[$stageID]->parent);?>
      <?php endforeach;?>
  </tbody>
</table>
