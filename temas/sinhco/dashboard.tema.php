<?php 
        //$Experimental
        $WebTitle .= " - Dashboard";
        
        
        $idusuario = $_SESSION['idusuario'];
        /*
        $stmt = $mysqli->select("usuarios",["nombre"],["idusuario" => $idusuario]);
        if(!$stmt)
        {
            if($mysqli->error()[2] != "")
                echo "Error:".$mysqli->error()[2];
                
           return;
        }        
        $nombre = $stmt[0]["nombre"];
        */
        $nombre = $_SESSION['usuario'];
        $MenuHTML = menu($mysqli, 2, 'side-nav fixed leftside-navigation' ,'slide-out',
        '
                <li class="user-details cyan darken-2">
                <div class="row">
                    <div class="col s4 m4 l4">
                        <img src=' . GetUserImagePath($idusuario) . ' alt="" class="circle responsive-img valign profile-image" style="margin-top:15px">
                    </div>
                    <div class="col s8 m8 l8">
                        <ul id="profile-dropdown" class="dropdown-content">
                            <li><a href="'.GetURL("dashboard/usuarioperfil/".$idusuario).'"><i class="mdi-action-settings"></i> Config</a>
                            </li>
                            <li><a href="#"><i class="mdi-communication-live-help"></i> Ayuda</a>
                            </li>
                            <li class="divider"></li>
                            </li>
                            <li><a href="'.GetURL("logout.php").'"><i class="mdi-hardware-keyboard-tab"></i> Logout</a>
                            </li>
                        </ul>
                        <a class="btn-flat dropdown-button waves-effect waves-light white-text profile-btn" href="#" data-activates="profile-dropdown">
                            <div class="row">
                                <div class="col s9">
                                <span style="margin-left:-10px">'. $nombre .'</span>
                                </div>
                                <div class="col s2">
                                    <i class="mdi-navigation-arrow-drop-down"></i>                                                        
                                </div>
                            </div>                            
                        </a>
                        <p class="user-roal">Admin</p>
                    </div>
                </div>
                </li> 
        '       
        );
    
    
    //<--- Get Module ---> 
      $ModuloHTML = modulo($modulo ,$mysqli, "", "ModuleView",true);
?>
<!DOCTYPE html>
<html>
<head>
    <meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
    <meta content="es_HN" http-equiv="Content-Language">
    <meta name="Author" content="">
    <meta name="Designer" content="">
    <meta name="Date" content="">
    <title><?php echo $WebTitle ?></title>

    <!-- JQuery -->
    <script type="text/javascript" src="<?php echo GetURL("recursos/jquery.js")?>"></script>				
    <!-- JQuery UI -->
    <link type="text/css" rel="stylesheet" href="<?php echo GetURL("recursos/jquery-ui.min.css")?>"/>
    <link type="text/css" rel="stylesheet" href="<?php echo GetURL("recursos/jquery-ui.structure.min.css")?>"/>
    <link type="text/css" rel="stylesheet" href="<?php echo GetURL("recursos/jquery-ui.theme.min.css")?>"/>
    <script src="<?php echo GetURL("recursos/jquery-ui.min.js")?>"></script>      
    
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="<?php echo GetURL($tema."css/materialize.min.css")?>" media="screen,projection">
    <script type="text/javascript" src="<?php echo GetURL($tema."js/materialize.min.js")?>"></script>
    
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Sweet Alert -->
    <script src="<?php echo GetURL("recursos/sweetalert/dist/sweetalert.min.js")?>"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo GetURL("recursos/sweetalert/dist/sweetalert.css")?>">        
    
    <!-- Custom CSS -->
    <link type="text/css" rel="stylesheet" href="<?php echo GetURL($tema."css/styles.css")?>" media="screen,projection">
    <link type="text/css" rel="stylesheet" href="<?php echo GetURL($tema."css/stylesgk.css")?>" media="screen,projection">
    <link type="text/css" rel="stylesheet" href="<?php echo GetURL("recursos/iconfont.css")?>">
    
    <!-- Perfect Scroll -->
    <link rel='stylesheet' href="<?php echo GetURL("recursos/perfect-scrollbar/css/perfect-scrollbar.css")?>" />
    <script src="<?php echo GetURL("recursos/perfect-scrollbar/js/perfect-scrollbar.jquery.js")?>"></script>
    
    <script>
        $(document).ready(function() 
        {
            $(".button-collapse").sideNav();
            swal.setDefaults({ html: 'true' });
            //$('#ModuleView').perfectScrollbar();
            
            // Search class for focus
            $('.header-search-input').focus(
            function(){
                $(this).parent('div').addClass('header-search-wrapper-focus');
            }).blur(
            function(){
                $(this).parent('div').removeClass('header-search-wrapper-focus');
            });
            
            // Perfect Scrollbar
            $('select').not('.disabled').material_select();
                var leftnav = $(".page-topbar").height();  
                var leftnavHeight = window.innerHeight - leftnav;
            $('.leftside-navigation').height(leftnavHeight).perfectScrollbar({
                suppressScrollX: true
            });
                var righttnav = $("#chat-out").height();
            $('.rightside-navigation').height(righttnav).perfectScrollbar({
                suppressScrollX: true
            });                         
        });
        
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

    </script>
    
    <style>
        .user-details {
            background: url("<?php echo GetURL("uploads/covers/cover-small.jpg")?>") no-repeat center center
        }
                 
    </style>
</head>
<body>
    
    <!--div class="navbar-fixed">
        <nav>
            <div class="nav-wrapper">
                <a href="#!" class="brand-logo">Logo</a>            
                <a href="dashboard.php" class="brand-logo"><i class="material-icons left">cloud</i>Dashboard</a>
                <a href="#" data-activates="slide-out" class="button-collapse"><i class="material-icons">menu</i></a>
                <a href="#!" class="breadcrumb">Dashboard</a>
                <a href="#!" class="breadcrumb">Menu</a>
                <a href="#!" class="breadcrumb">Third</a>
            </div>
        </nav>
    </div-->          
   <!-- START HEADER -->
    <header id="header" class="page-topbar">
        <!-- start header nav-->
        <div class="navbar-fixed" style="z-index:1000" >
            <nav class="navbar-color">
                <div class="nav-wrapper">
                    <ul class="left">                      
                      <li>
                          <h1 class="logo-wrapper">
                              <a href="<?php echo GetURL("dashboard/")?>" class="brand-logo darken-1">
                                <img src="<?php echo GetURL("uploads/static/sinhco-white.png");?>" alt="logo-top" style="display:inherit;margin-top:-8px">
                              </a>
                          </h1>
                      </li>
                    </ul>
                    <a href="#" data-activates="slide-out" class="button-collapse"><i class="material-icons">menu</i></a>
                    <div class="header-search-wrapper hide-on-med-and-down">
                        <i class="mdi-action-search"></i>
                        <input type="text" name="Search" class="header-search-input z-depth-2" placeholder="Buscar..."/>
                    </div>
                    <ul class="right hide-on-med-and-down">
                        <li><a href="javascript:void(0);" OnClick="toggleFullScreen()" class="waves-effect waves-block waves-light toggle-fullscreen white-text"><i class="mdi-action-settings-overscan"></i></a>
                        </li>
                        <li><a href="javascript:void(0);" class="waves-effect waves-block waves-light notification-button white-text" data-activates="notifications-dropdown"><i class="mdi-social-notifications"></i>                        
                        </a>
                        </li>                        
                        <li><a href="#" data-activates="chat-out" class="waves-effect waves-block waves-light chat-collapse white-text"><i class="mdi-communication-chat"></i></a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <!-- end header nav-->
    </header>
    <!-- END HEADER -->
    
    <!-- START LEFT SIDEBAR NAV-->
        
    <?php
        echo $MenuHTML;        
    ?>
    <!-- END LEFT SIDEBAR NAV-->
    
   <!-- START MAIN -->
    <div id="main">
        <!-- START WRAPPER -->
        <div class="wrapper">
            <?php
                echo $ModuloHTML;
            ?>
        </div>    
    </div>    
</body>
</html>