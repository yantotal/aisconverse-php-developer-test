<?php
/**
 * Created by PhpStorm.
 * User: YanTotal
 * Date: 14.07.15
 * Time: 18:47
 */

//check file type
$imageinfo = getimagesize($_FILES['img']['tmp_name']);
if($imageinfo['mime'] != 'image/gif' && $imageinfo['mime'] != 'image/jpeg' && $imageinfo['mime'] != 'image/png') {
    echo "Sorry, we only accept images\n";
    exit;
}
if($_FILES["img"]["size"] > 1024*3*1024)
{
    echo ("File size exceeds 3Mb");
    exit;
}
//if file uploaded
if(is_uploaded_file($_FILES["img"]["tmp_name"]))
{
    $watermark = htmlspecialchars(stripslashes($_POST["watermark"]));
    //move file to upload directory
    move_uploaded_file($_FILES["img"]["tmp_name"], 'img/'.$_FILES["img"]["name"]);
    $img_src = 'img/'.$_FILES["img"]["name"];
    $info = pathinfo($img_src);
    $extension = strtolower($info['extension']);
    switch ($extension) {
        case 'jpg':
            $img = imagecreatefromjpeg($img_src);
            break;
        case 'jpeg':
            $img = imagecreatefromjpeg($img_src);
            break;
        case 'png':
            $img = imagecreatefrompng($img_src);
            break;
        case 'gif':
            $img = imagecreatefromgif($img_src);
            break;
        default:
            $img = imagecreatefromjpeg($img_src);
    }
    putenv('GDFONTPATH=' . realpath('.'));
    $color = imagecolorallocate($img, 250, 0, 0);
    imagettftext(
        $img,
        20,
        0,
        20,
        20,
        $color,
        "arial",
        $watermark
    );
    $path = "img/img".microtime(true).".jpg";
    imagejpeg($img, $path, 100);
    imagedestroy($img);
    echo '<img src="'.$path.'">';
} else {
    echo("Ошибка загрузки файла");
}
?>