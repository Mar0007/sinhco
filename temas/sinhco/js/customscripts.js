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
    
var preloader = '<div class="preloader-wrapper small active">'+
    '<div class="spinner-layer spinner-blue-only">'+
      '<div class="circle-clipper left">'+
        '<div class="circle"></div>'+
      '</div><div class="gap-patch">'+
        '<div class="circle"></div>'+
      '</div><div class="circle-clipper right">'+
        '<div class="circle"></div>'+
      '</div>'+
    '</div>'+
  '</div>'
  
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
        
    $("#confirmar-eliminar").openModal({
        complete: function(){
            $("#confirmar-eliminar").remove(); 
        }
    });
    $("#confirmar-eliminar").css("display","table");        
}

function bytesToSize(bytes) {
   var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
   if (bytes == 0) return '0 Byte';
   var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
   return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
};


function CustomParseDate(DateStr)
{
    DateStr = DateStr.split("-");

    var monthNames = [
        "Enero", "Febrero", "Marzo",
        "Abril", "Mayo", "Junio", "Julio",
        "Agosto", "Septiembre", "Octubre",
        "Noviembre", "Diciembre"
    ];

    day = DateStr[2];
    monthIndex = parseInt(DateStr[1]);
    year = DateStr[0];

    //console.table(Str);
    //console.log(day, monthNames[monthIndex - 1], year);
    return monthNames[monthIndex - 1] + " " + day + ", " + year;
}


//Check for filezise
function handleFileSelect(evt) 
{
    var files = evt.target.files; // FileList object
    var max_size = $("#maxsize").val(); // Max file size

    // files is a FileList of File objects. List some properties.
    var output = [];
    for (var i = 0, f; f = files[i]; i++) 
    {
    //console.log("FileSize->"+f.size);
        if(f.size > max_size) 
        { // Check if file size is larger than max_size
            //Reset preview          
            //$(this).parents(".modal").find('img').attr('src',$("#InitImage").attr('src'));
            
            if($(this).parent().find("img").length > 0)
                $(this).parent().find("img").attr('src',$("#InitImage").attr('src'));
            else
                $(this).parents(".modal").find('img').attr('src',$("#InitImage").attr('src'));     
            
            //Clear input:file
            $(this).val('');
            //Notify          
            alert("Error: La imagen sobrepasa el tamaño maximo.\nTamaño maximo: " + bytesToSize(max_size) + ".\nTamaño de su imagen: "+bytesToSize(f.size));          
            return false;
        }
    }
    
    //Set preview.
    readURL(this);
}

    
//FOR IMAGE PREVIEW
function readURL(input) 
{
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) 
        {
            if($(input).parent().find("img").length > 0)            
                $(input).parent().find("img").attr('src',e.target.result);
            else
                $(input).parents(".modal").find('img').attr('src',e.target.result);
        }
                                
        reader.readAsDataURL(input.files[0]);
    }
}

function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

String.prototype.ltrim = function() {
    var trimmed = this.replace(/^\s+/g, '');
    return trimmed;
};

$(document).ready(function()
{
    $('.disable-enter').on('keyup keypress', function(e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) 
        {
            e.preventDefault();
            return false;
        }
    });    
});

// ----------- Search --------------
$(document).ready(function() 
{
    //Mirror search inputs
    $('.mirror').on('keypress', function() {
        $('.mirror').val($(this).val().ltrim());
    });    
    
    if(typeof SearchModule === 'undefined' || SearchModule === null)
    {
        $(".search-textbox").closest("form").hide();
        console.info("renderResults->Is not defined");
        return;
    }

    //Disable form submit
    $('.search-textbox').parents("form").submit(function(e) {e.preventDefault()}); 

    //Bind on key events
    $('.search-textbox').bind('keyup', debounce(function (e) {
        if ($(this).val() < 2) 
        {
            renderResults(this,true);
            return;
        }

        if (e.which === 38 || e.which === 40 || e.keyCode === 13) return;


        renderResults(this);
    }));

    $('.search-textbox').bind('keydown', debounce(function (e) {
        // Escape.
        if (e.keyCode === 27) 
        {
            $(this).val('');
            $(this).blur();
            renderResults(this,true);
            return;
        }
    }));


});

var debounce = function (fn) {
    var timeout;
    return function () {
    var args = Array.prototype.slice.call(arguments),
        ctx = this;

    clearTimeout(timeout);
    timeout = setTimeout(function () {
        fn.apply(ctx, args);
    }, 200);
    };
};

var LastSearch = "";
var AjaxRequest;
function renderResults(searchinput,bClear)
{
    //Get Input
    var search = $(searchinput).val();

    //Check for changes
    if(LastSearch == search) return;
    
    //Store last change
    LastSearch = search;

    //Cancel last Ajax
    if(AjaxRequest) AjaxRequest.abort();

    //Run Ajax
    AjaxRequest = (bClear) ? $.get(SearchModule.DefaultAjaxURL) : 
                             $.post(SearchModule.SearchAjaxURL,{search:search});
    
    //Bind events
    AjaxRequest.done(SearchAjaxDone);
    AjaxRequest.fail(SearchAjaxFail);
}

var SearchAjaxDone = function(data)
{
    if(data == "none")
    {
        if(SearchModule.EmptyText)
            $(SearchModule.ContainerSelector).html('<li class="DataEmpty center"><div class="center grey-text">'+SearchModule.EmptyText+'</div></li>');
        else
            $(SearchModule.ContainerSelector).empty();
        return;
    }
    
    if(isHTML(data))
    {
        $(SearchModule.ContainerSelector).html(data);
        if ((typeof SearchModule.DoneExtraAction === typeof(Function))) 
            SearchModule.DoneExtraAction();         
        return;
    }
    SearchAjaxFail({responseText:"SearchAjaxDone-> Data is not HTML"});
};

var SearchAjaxFail = function(AjaxObject)
{
    Materialize.toast('Error del servidor', 3000, "red");				
    console.error("GetAjax->Search:" + AjaxObject.responseText);
};

function isHTML(str) 
{
    var doc = new DOMParser().parseFromString(str, "text/html");
    return Array.from(doc.body.childNodes).some(node => node.nodeType === 1);
}

// ----------- END Search --------------