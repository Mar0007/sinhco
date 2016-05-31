<?php
	global $mysqli;
	global $OnDashboard;
	
	if($OnDashboard != 1 || !login_check($mysqli))
	{
		echo "<h1>Acceso denegado</h1>";
		return;
	}
	
	if(!esadmin($mysqli))
	{
		echo "<h1>No tiene permisos para ver este modulo.</h1>";
		return;
	}	   

?>

<div id="DashboardInfo" style="display:none">
</div>


<script>
    
$(document).ready(function() {
    $("#ModuleView").append(HTMLLoader);		        
    GetAjaxData();
});
      
      
var ajax_request;
function GetAjaxData()
{
    //Prevent parallel execution of ajax.
    if(ajax_request) ajax_request.abort();
    //Clear table
    //$("#DashboardInfo").empty();
    
    //Get data
    ajax_request = $.ajax({
        url:"<?php echo GetURL("modulos/moddashboard/servicedashboard.php")?>",
        method: "POST",
        data: {info:true}
    });
    
    ajax_request.done(function(data)
    {
        $("#ModuleView").find('.TabLoader').remove();			
        $("#DashboardInfo").append(data).fadeIn();
        
        $.getScript('<?php echo GetURL("recursos/linfo/layout/scripts.min.js")?>',function()
        {
            Linfo.init();
        })
    });
        
   ajax_request.fail(function(AjaxObject,textStatus,error)
   {
       console.error("Error: "+AjaxObject.responseText);
       console.error("Error: "+textStatus);
       console.error("Error: "+error);
   });			  
}             
</script>