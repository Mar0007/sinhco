<?php
require_once("funciones.php");	
require_once("config.php");

inicio_sesion();

if(!login_check($mysqli) || !esadmin($mysqli))
{
    echo "<h2>Acceso denegado</h2>";
    return;
} 


$action = ( isset($_GET['action']) ) ? $_GET['action'] : null;
$id     = ( isset($_GET['id']) ) ? basename($_GET['id']) : null;
$prefix = ( isset($_GET['prefix']) ) ? basename($_GET['prefix']) . "_" : "";

if(empty($action) || empty($id)) return;

$PathFolder = "uploads/images/editor/" . $prefix . $id . "/" ;

//1 - Filelist, 2 - Insert, 3 - Delete
switch ($action)
{
    case 1:
        // Array of image objects to return.
        $response = array();

        // Image types.
        $image_types = array(
                        "image/gif",
                        "image/jpeg",
                        "image/pjpeg",
                        "image/jpeg",
                        "image/pjpeg",
                        "image/png",
                        "image/x-png"
                    );
        $allowedExts = array("gif", "jpeg", "jpg", "png", "blob");                    

        // Filenames in the uploads folder.
        if(is_dir($PathFolder))        
            $fnames = scandir($PathFolder);
        else 
        {
            $fnames = null;
        }

        // Check if folder exists.
        if ($fnames) {
            // Go through all the filenames in the folder.
            foreach ($fnames as $name) {
                // Filename must not be a folder.
                if (!is_dir($name)) {
                    // Check if file is an image.
                    //if (in_array(_mime_content_type("uploads/images/editor/" . $name), $image_types)) {
                    $ext = pathinfo($name, PATHINFO_EXTENSION);
                    if(in_array($ext,$allowedExts)){
                        // Build the image.
                        $img = new StdClass;
                        $img->url   = GetImageURL($PathFolder . $name);
                        $img->thumb = GetImageURL($PathFolder . $name,200,200);
                        $img->name = $name;

                        // Add to the array of image.
                        array_push($response, $img);
                    }
                }
            }
        }

        // Folder does not exist, respond with a JSON to throw error.
        else {
            $response = new StdClass;
            $response->error = "Images folder does not exist!";
        }

        $response = json_encode($response);

        // Send response.
        echo stripslashes($response);       
        break;
    case 2:
        // Allowed extentions.
        $allowedExts = array("gif", "jpeg", "jpg", "png", "blob");
        $allowedMime = array("image/gif","image/jpeg","image/pjpeg","image/x-png","image/png");

        // Get filename.
        $temp = explode(".", $_FILES["file"]["name"]);

        // Get extension.
        $extension = end($temp);

        // An image check is being done in the editor but it is best to
        // check that again on the server side.
        // 
        //$finfo = finfo_open(FILEINFO_MIME_TYPE);
        //$mime = finfo_file($finfo, $_FILES["file"]["tmp_name"]);
        $mime = $_FILES["file"]["type"];
        
        if (in_array($mime,$allowedMime) && in_array(strtolower($extension), $allowedExts)) 
        {
            // Generate new random name.
            $name = sha1(microtime()) . "." . $extension;

            // Save file in the uploads folder.
            if (!is_dir($PathFolder)) mkdir($PathFolder);

            move_uploaded_file($_FILES["file"]["tmp_name"], $PathFolder . $name);

            // Generate response.
            $response = new StdClass;
            $response->link = GetImageURL($PathFolder . $name);            
            echo stripslashes(json_encode($response));
        }         
        break;    
    case 3:   
        // Get src.
        //$src = $_POST["src"];
        $name = $_POST["name"];        

        // Check if file exists.
        if (file_exists($PathFolder . $name)) 
        {
            // Delete file.
            @unlink($PathFolder . $name);
        }
        break;  
    
    default:
        break;         
}

?>