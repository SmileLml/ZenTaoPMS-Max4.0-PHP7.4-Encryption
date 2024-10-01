$('#project').change(function()
{
    var link = createLink('project', 'ajaxGetExecutions', 'project=' + $(this).val());
    $('td.executionBox').load(link, function(){$('#execution').change().chosen();});

    link = createLink('issue', "ajaxGetProjectIssues", "projectID=" + $(this).val());
    if($(this).val() == projectID) link = createLink('issue', "ajaxGetProjectIssues", "projectID=" + $(this).val() + '&append=' + linkedIssues);
    $('td.issueBox').load(link, function(){$('#issues').val(linkedIssues).chosen();});
});
