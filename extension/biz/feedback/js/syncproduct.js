function jumpBrowse()
{
    window.parent.location.href = browseLink;
}

$("#dataform").submit(function(e)
{
    if(feedbackCount !== 0 || feedbackModuleCount > 1)
    {
        if(confirm(syncConfirm)) $("#needMerge").val('yes');
    }
});
