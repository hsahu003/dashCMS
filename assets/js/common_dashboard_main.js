/*admin module*/
//---------------------------------function for removing admin ajax STARTS--------------------------------------------------//
function remove_admin(){

    var IDtoDelete;
    var IDsToDelete = [];
    var admin_selected = document.getElementsByClassName('admin-selected');
    for(var i = 0; i < admin_selected.length; i++)
    {
        if (admin_selected[i].checked) {
        IDtoDelete =  admin_selected[i].getAttribute('data-UID');
        IDsToDelete.push(IDtoDelete);
        }
    }

    //checks if button pressed only with admins selected and then process
    if (IDsToDelete.length != 0) 
    {
        IDsToDelete = Object.assign({}, IDsToDelete);
        //send ajax
        ajax({
            type:'POST',
            url: site_url('ajax/delete-admin'),
            data: "data="+JSON.stringify(IDsToDelete),
            onSuccess: function(return_data)
            {   
                /*this trim function is used to remove unsual white spaces in the
                * begining of the string which is respose of ajax request
                */
                var superAdminMessage = return_data.trim();
                //if request is to delete super admin then show message that super admin can't be deleted
                if (superAdminMessage != '') 
                {      
                    display_err(superAdminMessage);
                }
                else
                {
                    console.log('null');
                    window.location =  site_url('dashboard/settings/admin/view');
                } 
            }
    })
    }
}
//---------------------------------function for removing admin ajax ENDS--------------------------------------------------//

//--------------------------------function for disabling admin ajax SATRS-----------------------------------//
function disable_admin(){

    var IDtoDisable;
    var IDsToDisable = [];
    var admin_selected = document.getElementsByClassName('admin-selected');
    for(var i = 0; i < admin_selected.length; i++)
    {
        if (admin_selected[i].checked) {
        IDtoDisable =  admin_selected[i].getAttribute('data-UID');
        IDsToDisable.push(IDtoDisable);
        }
    }

    //checks if button pressed only with admins selected and then process
    if (IDsToDisable.length != 0) 
    {
        IDsToDisable = Object.assign({}, IDsToDisable);
        //send ajax
        ajax({
            type:'POST',
            url: site_url('ajax/disable-admin'),
            data: "data="+JSON.stringify(IDsToDisable),
            onSuccess: function(return_data)
            {   
                /*this trim function is used to remove unsual white spaces in the
                * begining of the string which is respose of ajax request
                */
                var superAdminMessage = return_data.trim();
                //if request is to delete super admin then show message that super admin can't be deleted
                if (superAdminMessage != '') 
                {      
                    display_err(superAdminMessage);
                }
                else
                {
                    console.log('null');
                    window.location =  site_url('dashboard/settings/admin/view');
                } 
            }
    })
    }
}

//--------------------------------------------------function for disabling admin ajax ENDS--------------------------------------------------------//

//--------------------------------------------------function for sorting admins on view admin page STARTS-----//
function sort_admins(filter){
	window.location =  site_url('dashboard/settings/admin/view/' + filter.value);
}
//--------------------------------------------------function for sorting admins on view admin page ENDS-----//