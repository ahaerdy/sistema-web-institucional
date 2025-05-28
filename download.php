<?php
session_start();

$url = urldecode($_SERVER['REQUEST_URI']);
 
if(substr($url, 0, 7) == '/images' || substr($url, 0, 8) == '/up_foto' || substr($url, 0, 6) == 'images' || substr($url, 0, 4) == '/adm')
{
    $path = $_SERVER['DOCUMENT_ROOT'] . $url;

    if(file_exists($path))
    {
        $fsize      = filesize($path);
        $path_parts = pathinfo($path); 
        $ext        = strtolower($path_parts["extension"]); 
        
        // Determine Content Type 
        switch ($ext)
        { 
          case "pdf": $ctype="application/pdf"; break; 
          case "exe": $ctype="application/octet-stream"; break; 
          case "zip": $ctype="application/zip"; break; 
          case "doc": $ctype="application/msword"; break; 
          case "xls": $ctype="application/vnd.ms-excel"; break; 
          case "ppt": $ctype="application/vnd.ms-powerpoint"; break; 
          case "gif": $ctype="image/gif"; break; 
          case "png": $ctype="image/png"; break; 
          case "jpeg": $ctype="image/jpg"; break; 
          case "jpg": $ctype="image/jpg"; break; 
          case "mp4": $ctype="video/mp4"; break; 
          default: $ctype="application/force-download"; 
        }

        header("Pragma: public"); // required 
        header('Cache-Control: max-age=86400');
        header('Expires: '. gmdate('D, d M Y H:i:s \G\M\T', time() + 86400));
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
        header("Cache-Control: private",false); // required for certain browsers 
        header("Content-Type: $ctype"); 
        header("Content-Disposition: attachment; filename=\"".basename($path)."\";" ); 
        header("Content-Transfer-Encoding: binary"); 
        header("Content-Length: ".$fsize); 
        ob_clean(); 
        flush(); 
        readfile( $path ); 
    }
    else
    {
        //print "Acesso negado!";
        header('HTTP/1.0 404 Not Found');
        echo "<h1>404 Not Found</h1>";
         echo "The page that you have requested could not be found.";
         die;
    }
}
else
{
    $sessao = substr($url, 0, -4);
    $sessao = substr($sessao, -4);
    //&& $_SESSION['confirmar'] == $sessao)
    if (isset($_SESSION['login']) && !empty($_SESSION['login'])) 
    {
        // unset($_SESSION['confirmar']);
        if((substr($url, 0, 13) != '/arquivo_site'))
        {
            $url = utf8_decode(urldecode($_SERVER['REQUEST_URI']));
            if(stristr($url, '?', 1))
              $url = stristr($url, '?', 1);
            $url = str_replace(array('/'), '', $url);
            $url = substr($url, 0, -4);
            $url = base64_decode($url);
        }
       
        chdir('../');

        $path = trim(getcwd() . $url);
        if(file_exists($path)):
          $fsize      = filesize($path);
          $path_parts = pathinfo($path); 
          $ext        = strtolower($path_parts["extension"]); 
          
          // Determine Content Type 
          switch ($ext)
          { 
            case "pdf": $ctype="application/pdf"; break; 
            case "exe": $ctype="application/octet-stream"; break; 
            case "zip": $ctype="application/zip"; break; 
            case "doc": $ctype="application/msword"; break; 
            case "xls": $ctype="application/vnd.ms-excel"; break; 
            case "ppt": $ctype="application/vnd.ms-powerpoint"; break; 
            case "gif": $ctype="image/gif"; break; 
            case "png": $ctype="image/png"; break; 
            case "jpeg": $ctype="image/jpg"; break;  
            case "jpg": $ctype="image/jpg"; break; 
            case "mp4": $ctype="video/mp4"; break; 
            default: $ctype="application/force-download"; 
          }

          if($ctype == 'video/mp4'):
            Stream($path, $ctype);
          else:
            header('Pragma: public');
            header('Cache-Control: max-age=86400');
            header('Expires: '. gmdate('D, d M Y H:i:s \G\M\T', time() + 86400));
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
            header("Cache-Control: private",false); // required for certain browsers 
            header("Content-Type: $ctype"); 
            header("Content-Disposition: attachment; filename=\"".basename($path)."\";" ); 
            header("Content-Transfer-Encoding: binary"); 
            header("Content-Length: ".$fsize); 
            ob_clean(); 
            flush(); 
            readfile($path);
            exit;
          endif;
          
        else:
          header('HTTP/1.0 404 Not Found');
          echo "<h1>404 Not Found</h1>";
          echo "The page that you have requested could not be found.";
          die;
        endif;
    }
    else
    {
       //print "Acesso negado!";
       header('HTTP/1.0 404 Not Found');
       echo "<h1>404 Not Found</h1>";
       echo "The page that you have requested could not be found.";
       die;
    }
}


function Stream($file, $ctype)
{
    $fsize      = filesize($file);
    header("Pragma: public"); // required 
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
    header("Cache-Control: private",false); // required for certain browsers 
    header("Content-Type: $ctype"); 
    header("Content-Disposition: attachment; filename=\"video.mp4\"" ); 
    header("Content-Transfer-Encoding: binary"); 
    header("Content-Length: ".$fsize); 

    $mtime = filemtime($_SERVER['SCRIPT_FILENAME']);
    $gmdate_mod = gmdate('D, d M Y H:i:s', $mtime) . ' GMT';
    header("Last-Modified: $gmdate_mod");
    header('Expires: ' . date('D, d M Y H:i:s', time() + (60*60*24*45)) . ' GMT');

    if (isset($_SERVER['HTTP_RANGE']))  {
        rangeDownload($file);
    }else {
      header('HTTP/1.1 206 Partial Content');
      header("Content-Length:1");
      readfile($file);
    }
}

function rangeDownload($file) {

    $fp = @fopen($file, 'rb');

    $size   = filesize($file); // File size
    $length = $size;           // Content length
    $start  = 0;               // Start byte
    $end    = $size - 1;       // End byte
    // Now that we've gotten so far without errors we send the accept range header
    /* At the moment we only support single ranges.
     * Multiple ranges requires some more work to ensure it works correctly
     * and comply with the spesifications: http://www.w3.org/Protocols/rfc2616/rfc2616-sec19.html#sec19.2
     *
     * Multirange support annouces itself with:
     * header('Accept-Ranges: bytes');
     *
     * Multirange content must be sent with multipart/byteranges mediatype,
     * (mediatype = mimetype)
     * as well as a boundry header to indicate the various chunks of data.
     */
    header("Accept-Ranges: 0-$length");
    // header('Accept-Ranges: bytes');
    // multipart/byteranges
    // http://www.w3.org/Protocols/rfc2616/rfc2616-sec19.html#sec19.2
    if (isset($_SERVER['HTTP_RANGE'])) {

        $c_start = $start;
        $c_end   = $end;
        // Extract the range string
        list(, $range) = explode('=', $_SERVER['HTTP_RANGE'], 2);
        // Make sure the client hasn't sent us a multibyte range
        if (strpos($range, ',') !== false) {

            // (?) Shoud this be issued here, or should the first
            // range be used? Or should the header be ignored and
            // we output the whole content?
            header('HTTP/1.1 416 Requested Range Not Satisfiable');
            header("Content-Range: bytes $start-$end/$size");
            // (?) Echo some info to the client?
            exit;
        }
        // If the range starts with an '-' we start from the beginning
        // If not, we forward the file pointer
        // And make sure to get the end byte if spesified
        if ($range0 == '-') {

            // The n-number of the last bytes is requested
            $c_start = $size - substr($range, 1);
        }
        else {

            $range  = explode('-', $range);
            $c_start = $range[0];
            $c_end   = (isset($range[1]) && is_numeric($range[1])) ? $range[1] : $size;
        }
        /* Check the range and make sure it's treated according to the specs.
         * http://www.w3.org/Protocols/rfc2616/rfc2616-sec14.html
         */
        // End bytes can not be larger than $end.
        $c_end = ($c_end > $end) ? $end : $c_end;
        // Validate the requested range and return an error if it's not correct.
        if ($c_start > $c_end || $c_start > $size - 1 || $c_end >= $size) {

            header('HTTP/1.1 416 Requested Range Not Satisfiable');
            header("Content-Range: bytes $start-$end/$size");
            // (?) Echo some info to the client?
            exit;
        }
        $start  = $c_start;
        $end    = $c_end;
        $length = $end - $start + 1; // Calculate new content length
        fseek($fp, $start);
        header('HTTP/1.1 206 Partial Content');
    }
    // Notify the client the byte range we'll be outputting
    header("Content-Range: bytes $start-$end/$size");
    header("Content-Length: $length");

    // Start buffered download
    $buffer = 1024 * 8;
    while(!feof($fp) && ($p = ftell($fp)) <= $end) {

        if ($p + $buffer > $end) {

            // In case we're only outputtin a chunk, make sure we don't
            // read past the length
            $buffer = $end - $p + 1;
        }
        set_time_limit(0); // Reset time limit for big files
        echo fread($fp, $buffer);
        flush(); // Free up memory. Otherwise large files will trigger PHP's memory limit.
    }

    fclose($fp);
}
?>