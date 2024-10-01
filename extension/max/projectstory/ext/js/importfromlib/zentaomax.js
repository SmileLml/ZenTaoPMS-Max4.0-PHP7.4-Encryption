function reload(libID)
{
    link = createLink('projectstory', 'importFromLib', 'projectID=' + projectID + '&productID=' + productID + '&libID=' + libID);
    location.href = link;
}
