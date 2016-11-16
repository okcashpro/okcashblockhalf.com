<?php
$data = file_get_contents('https://api.cryptonator.com/api/ticker/ok-usd');
$price = json_decode($data, true);
$btcPrice = (float)$price["ticker"]["price"];
$file = "price.txt";
$fh = fopen($file, 'w') or die("can't open file");
fwrite($fh, $btcPrice);
fclose($fh);
?>