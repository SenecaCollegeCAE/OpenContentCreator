<?php
    session_start();
    
    //if (empty($_SESSION['rand_code'])) {
        $str = "";
        $length = 0;
        for ($i = 0; $i < 5; $i++) { //the number of characters on the captcha
            
            //randomly generate yes or no
            $yesno = mt_rand(0, 1);
            
            if($yesno == 1) //1
                $str .= chr(rand(65, 90)); // this numbers refer to numbers of the ascii table (Uppercase)
            else //0                           
                $str .= chr(rand(97, 122)); // this numbers refer to numbers of the ascii table (small-caps)
        }
        $_SESSION['rand_code'] = $str;
    //}
    
    $imgX = 200;
    $imgY = 100;
    $image = imagecreatetruecolor(200, 100); //image size
    
    $backgr_col = imagecolorallocate($image, 238,239,239); //background color
    $border_col = imagecolorallocate($image, 208,208,208); //border color
    $text_col = imagecolorallocate($image, 0,0,0); //text color
    
    //generate random colors for lines, dots and rectangles using imagecolorallocate function
    $line_color = imagecolorallocate($image, mt_rand(0,255), 0, 255); 
    $dots_color = imagecolorallocate($image, mt_rand(0,255),255,mt_rand(0,255));   
    $rect_color = imagecolorallocate($image, 0,mt_rand(50,127),50);
        
    imagefilledrectangle($image, 0, 0, 200, 100, $backgr_col); //fill the image with the background color
    imagerectangle($image, 0, 0, 199, 99, $border_col); //fill the image with the border color
    
    // generate random dots
    for( $i=0; $i<($imgX * $imgY); $i++ ) {
        imagefilledellipse($image, mt_rand(0,$imgX), mt_rand(0,$imgY), mt_rand(0,3), mt_rand(0,3), $dots_color);
    }
    
    // generate random lines
    for( $i=0; $i<($imgX + $imgX)/3; $i++ ) {
       imageline($image, mt_rand(0,$imgX), mt_rand(0,$imgY), mt_rand(0,$imgX), mt_rand(0,$imgY), $line_color);
    }
    
    // generate random rectangles
    for( $i=0; $i<($imgX + $imgY)/3; $i++ ) {
        imagerectangle($image, mt_rand(0,$imgX), mt_rand(0,$imgY), mt_rand(0,$imgX), mt_rand(0,$imgY), $rect_color);
    }
    
    $font = "./images/arial.ttf";
    $font_size = mt_rand(25, 35); //randomly generate a font size
    $angle = mt_rand(-25, 25); // randomly generate an angle for the words
    $box = imagettfbbox($font_size, $angle, $font, $_SESSION['rand_code']); //create a bounding box with the text
    $x = (int)($imgX - $box[4]) / 2; 
    $y = (int)($imgY - $box[5]) / 2;
    imagettftext($image, $font_size, $angle, $x, $y, $text_col, $font, $_SESSION['rand_code']); //write the text on top of the generated image
    
    header("Content-type: image/png"); //creates an image in php format, to use it, just use the include function
    imagepng($image); //outputs a png image
    imagedestroy ($image); //destroys the image and frees up memory
?>