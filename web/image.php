<?php

header ("Content-type: image/png");
//header('Content-Type: text/html;charset=UTF-8');

//= imagecreate(200,50);

$image  = @imagecreate(110, 20)
or die("Impossible d'initialiser la bibliothèque GD");

?>
<body>

<br/>
test
<?php
/*


$image=imagecreate(200, 50);
var_dump($image);
$orange = imagecolorallocate($image, 255, 128, 0);

$bleu = imagecolorallocate($image, 0, 0, 255);

$bleuclair = imagecolorallocate($image, 156, 227, 254);

$noir = imagecolorallocate($image, 0, 0, 0);

$blanc = imagecolorallocate($image, 255, 255, 255);


imagestring($image, 4, 35, 15, "Salut les Zéros !", $blanc);
*/

//imagepng($image);

?>
</body>
