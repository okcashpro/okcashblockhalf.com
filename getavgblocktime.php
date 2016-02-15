<?php
$data = json_decode(file_get_contents("https://blockchain.info/stats?format=json"), true);
$timeBetweenBlocks = $data['minutes_between_blocks'];
$fh = fopen("timebetweenblocks.txt", 'w') or die("can't open file");
fwrite($fh, $timeBetweenBlocks);
fclose($fh);
?>
