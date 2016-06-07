<?php
//session_cache_limiter('none');
require_once("funciones.php"); 
$sImagePath = (isset($_GET["file"])) ? preg_replace('/^' . preg_quote(CurrentFolder(), '/') . '/', '', $_GET["file"]) : null;

if($sImagePath == null || !file_exists($sImagePath))
{
    $modulo = "404";
    require_once("index.php");
}
else 
{
    if(!sendHTTPCacheHeaders($sImagePath,true))
    {
        //Still valid in cache
        return;
    }
}
 
$iThumbnailWidth = (isset($_GET["width"])) ? (int)$_GET['width'] : null;
$iThumbnailHeight = (isset($_GET["height"])) ? (int)$_GET['height'] : null;
$iMaxWidth = (isset($_GET["maxw"])) ? (int)$_GET["maxw"] : null;
$iMaxHeight = (isset($_GET["maxh"])) ? (int)$_GET["maxh"] : null;

$sType = ''; 
if ($iMaxWidth != null && $iMaxHeight != null) $sType = 'scale';
else if ($iThumbnailWidth != null && $iThumbnailHeight != null) $sType = 'exact';
 
$img = NULL;

//echo "File->";
//echo "$sImagePath<br>";
 
$sExtension = pathinfo($sImagePath, PATHINFO_EXTENSION);
switch ($sExtension) 
{
    case 'jpg':
    case 'jpeg':
        $img = @imagecreatefromjpeg($sImagePath)
            or die("Cannot create new JPEG image");
        break;
            
    case 'png':
        $img = @imagecreatefrompng($sImagePath)
            or die("Cannot create new PNG image.");
        break;
        
    case 'gif':
        $img = @imagecreatefromgif($sImagePath)
            or die("Cannot create new GIF image");
        break;
}
 
if ($img) 
{
 
    $iOrigWidth = imagesx($img);
    $iOrigHeight = imagesy($img);    
 
    if ($sType == 'scale') {
 
        // Get scale ratio
 
        $fScale = min($iMaxWidth/$iOrigWidth,
              $iMaxHeight/$iOrigHeight);
 
        if ($fScale < 1) {
 
            $iNewWidth = floor($fScale*$iOrigWidth);
            $iNewHeight = floor($fScale*$iOrigHeight);
 
            $tmpimg = imagecreatetruecolor($iNewWidth,
                               $iNewHeight);
 
            if(($sExtension == "png") OR ($sExtension == "gif"))
                GetTransparency($tmpimg,$iNewWidth,$iNewHeight);
            
            imagecopyresampled($tmpimg, $img, 0, 0, 0, 0,
            $iNewWidth, $iNewHeight, $iOrigWidth, $iOrigHeight);
 
            imagedestroy($img);
            $img = $tmpimg;
        }     
 
    } else if ($sType == "exact") {
 
        $fScale = max($iThumbnailWidth/$iOrigWidth,
              $iThumbnailHeight/$iOrigHeight);
 
        if ($fScale < 1) {
 
            $iNewWidth = floor($fScale*$iOrigWidth);
            $iNewHeight = floor($fScale*$iOrigHeight);
 
            $tmpimg = imagecreatetruecolor($iNewWidth,
                            $iNewHeight);
            $tmp2img = imagecreatetruecolor($iThumbnailWidth,
                            $iThumbnailHeight);
 
            imagecopyresampled($tmpimg, $img, 0, 0, 0, 0,
            $iNewWidth, $iNewHeight, $iOrigWidth, $iOrigHeight);
 
            if ($iNewWidth == $iThumbnailWidth) {
 
                $yAxis = ($iNewHeight/2)-
                    ($iThumbnailHeight/2);
                $xAxis = 0;
 
            } else if ($iNewHeight == $iThumbnailHeight)  {
 
                $yAxis = 0;
                $xAxis = ($iNewWidth/2)-
                    ($iThumbnailWidth/2);
 
            }
            
            if(($sExtension == "png") OR ($sExtension == "gif"))
               GetTransparency($tmp2img,$iThumbnailWidth,$iThumbnailHeight);            
 
            imagecopyresampled($tmp2img, $tmpimg, 0, 0,
                       $xAxis, $yAxis,
                       $iThumbnailWidth,
                       $iThumbnailHeight,
                       $iThumbnailWidth,
                       $iThumbnailHeight);
 
            imagedestroy($img);
            imagedestroy($tmpimg);
            $img = $tmp2img;
        }    
 
    }
    else {
     if(($sExtension == "png") OR ($sExtension == "gif"))
     {
        $tmpimg = imagecreatetruecolor($iOrigWidth,
                            $iOrigHeight);        
                            
        GetTransparency($tmpimg,$iOrigWidth,$iOrigHeight);
        imagecopyresampled($tmpimg, $img, 0, 0, 0, 0,
        $iOrigWidth, $iOrigHeight, $iOrigWidth, $iOrigHeight);
        
        imagedestroy($img);
        $img = $tmpimg;        
     }              

    }            
        
    //$MIMEType = mime_content_type($sImagePath);
    //header("Content-type: image/jpeg");
    //imagejpeg($img);
    
    
    switch ($sExtension)
    {
        case 'jpg':
        case 'jpeg':
            header("Content-type: image/jpeg");
            imagejpeg($img);
            break;
                
        case 'png':
            header("Content-type: image/png");
            imagepng($img);
            break;
            
        case 'gif':
            header("Content-type: image/gif");
            imagegif($img);
            break;        
    } 
       
}
 
 
 
 function GetTransparency(&$tmp,$Width,$Height)
 {
    imagealphablending($tmp, false);
    imagesavealpha($tmp,true);
    $transparent = imagecolorallocatealpha($tmp, 255, 255, 255, 127);
    imagefilledrectangle($tmp, 0, 0, $Width, $Height, $transparent);    
 }
 
   /**
   * @return false if not cached or modified, true otherwise.
   * @param bool check_request set this to true if you want to check the client's request headers and "return" 304 if it makes sense. will only output the cache response headers otherwise.
   **/     
  function sendHTTPCacheHeaders($cache_file_name, $check_request = false)
  {
    $mtime = @filemtime($cache_file_name);

    if($mtime > 0)
    {
      $gmt_mtime = gmdate('D, d M Y H:i:s', $mtime) . ' GMT';
      //$etag = sprintf('%08x-%08x', crc32($cache_file_name), $mtime);
      $etag = sprintf('%08x-%08x', hash_file('crc32', $cache_file_name), $mtime);

      header('ETag: ' . $etag);
      header('Last-Modified: ' . $gmt_mtime);
      header('Cache-Control: private');
      // we don't send an "Expires:" header to make clients/browsers use if-modified-since and/or if-none-match

      if($check_request)
      {
        if(isset($_SERVER['HTTP_IF_NONE_MATCH']) && !empty($_SERVER['HTTP_IF_NONE_MATCH']))
        {
          $tmp = explode(';', $_SERVER['HTTP_IF_NONE_MATCH']); // IE fix!
          if(!empty($tmp[0]) && strtotime($tmp[0]) == strtotime($gmt_mtime))
          {
            header('HTTP/1.1 304 Not Modified');
            return false;
          }
        }

        if(isset($_SERVER['HTTP_IF_NONE_MATCH']))
        {
          if(str_replace(array('\"', '"'), '', $_SERVER['HTTP_IF_NONE_MATCH']) == $etag)
          {
            header('HTTP/1.1 304 Not Modified');
            return false;
          }
        }
      }
    }

    return true;
  }
?>