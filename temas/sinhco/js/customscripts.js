var HTMLLoader = 
  "<div class=\"col s12 center TabLoader\" style=\"margin-top: 10%\">" +
  "<div class=\"preloader-wrapper active\">"+
  "<div class=\"spinner-layer spinner-blue-only\">"+
  "<div class=\"circle-clipper left\">"+
  "<div class=\"circle\"></div>"+
  "</div><div class=\"gap-patch\">"+
  "<div class=\"circle\"></div>"+
  "</div><div class=\"circle-clipper right\">"+
  "<div class=\"circle\"></div>"+
  "</div></div></div></div>";
    

//Client side functions
function InitDropdown()
{
    $('.dropdown-button').dropdown({
        inDuration: 100,
        outDuration: 100,
        constrain_width: false,
        gutter: 0,
        belowOrigin: true,
        alignment: 'right'
        }
    );			  
}

function ShowLoadingSwal()
{
    swal({
        title: "Cargando...",
        text: "<div class=\"preloader-wrapper big active\">"+
            "<div class=\"spinner-layer spinner-blue-only\">"+
                "<div class=\"circle-clipper left\">"+
                "<div class=\"circle\"></div>"+
                "</div><div class=\"gap-patch\">"+
                "<div class=\"circle\"></div>"+
                "</div><div class=\"circle-clipper right\">"+
                "<div class=\"circle\"></div>"+
                "</div></div></div>",
        html: true,
        allowEscapeKey:false,
        showConfirmButton: false
    });		  
}

function toggleFullScreen() 
{
    if (!document.fullscreenElement &&    // alternative standard method
        !document.mozFullScreenElement && !document.webkitFullscreenElement && !document.msFullscreenElement ) {  // current working methods
        if (document.documentElement.requestFullscreen) {
        document.documentElement.requestFullscreen();
        } else if (document.documentElement.msRequestFullscreen) {
        document.documentElement.msRequestFullscreen();
        } else if (document.documentElement.mozRequestFullScreen) {
        document.documentElement.mozRequestFullScreen();
        } else if (document.documentElement.webkitRequestFullscreen) {
        document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
        }
    } else {
        if (document.exitFullscreen) {
        document.exitFullscreen();
        } else if (document.msExitFullscreen) {
        document.msExitFullscreen();
        } else if (document.mozCancelFullScreen) {
        document.mozCancelFullScreen();
        } else if (document.webkitExitFullscreen) {
        document.webkitExitFullscreen();
        }
    }
}

function ConfirmDelete(title,content,ckMessage = "",YesCallback,strDelete = "borrar", strCancel = "cancelar")
{
    var HTML = 
    '<div id="confirmar-eliminar" class="modal delete-item">'+
        '<div class="modal-content">'+
            '<h5>'+title+'</h5>'+
            '<p class="">'+content+'</p>'+
            ((ckMessage != "" ) ? 
            '<p><input type="checkbox" id="chkbx-confirmar"/>'+
            '<label for="chkbx-confirmar">'+ckMessage+'</label></p>' : '') + 
        '</div>'+
        '<div class="modal-footer">'+
            '<button type="submit" value="SI" id="delete-yes" class="'+ ((ckMessage != "") ? 'disabled ' : '') +'modal-action btn-flat waves-effect waves-light">'+strDelete+'</button>'+
            '<button type="submit" value="NO" id="delete-no" class=" modal-action modal-close btn-flat waves-effect waves-light">'+strCancel+'</button>'+
        '</div>'+
    '</div>';
    
    //console.log("Data->"+HTML);
    
    //Append to Body
    $('body').append(HTML);
    
    //CheckBox events.
    $('#confirmar-eliminar input:checkbox').unbind('change').change(function()
    {
        if($(this).is(":checked")) 
            $('#delete-yes').removeClass("disabled");
        else 
            $('#delete-yes').addClass("disabled");
    });    
    
    //Set Events
    if (YesCallback && typeof(YesCallback) === "function") 
        $('#delete-yes').unbind('click').click(function()
        {
            if(!$(this).hasClass("disabled"))
            {
                YesCallback();
                $("#confirmar-eliminar").closeModal({
                    complete: function(){
                      $("#confirmar-eliminar").remove();  
                    }
                });                
            }
        });
        
    $("#confirmar-eliminar").openModal();    
}

function bytesToSize(bytes) {
   var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
   if (bytes == 0) return '0 Byte';
   var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
   return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
};                