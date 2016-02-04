<?php
$price = file_get_contents('https://api.bitcoinaverage.com/ticker/global/USD/last');
$file = "price.txt";
$fh = fopen($file, 'w') or die("can't open file");
fwrite($fh, $price);
fclose($fh);
?>
