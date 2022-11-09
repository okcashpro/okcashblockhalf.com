<?php

// Okcashblockhalf settings
// OK constants

$blockStartingReward = 3.95;

$fp = fopen('txt/blockStartingReward.txt', 'w') or die("can't open file");
fwrite($fp, $blockStartingReward);
fclose($fp);

$blockHalvingSubsidy = 4531314;

$fp = fopen('txt/blockHalvingSubsidy.txt', 'w') or die("can't open file");
fwrite($fp, $blockHalvingSubsidy);
fclose($fp);

$blockTargetSpacing = 72.7;

$fp = fopen('txt/blockTargetSpacing.txt', 'w') or die("can't open file");
fwrite($fp, $blockTargetSpacing);
fclose($fp);

$maxCoins = 105000000;

$fp = fopen('txt/maxCoins.txt', 'w') or die("can't open file");
fwrite($fp, $maxCoins);
fclose($fp);

$okstakereward = 22;

$fp = fopen('txt/okstakereward.txt', 'w') or die("can't open file");
fwrite($fp, $okstakereward);
fclose($fp);


// coincap -co data

$urlok2 = "http://chainz.cryptoid.info/ok/api.dws?q=addresses";
$json2 = json_decode(file_get_contents($urlok2), true);
$totady = $json2["known"];
$nonady = $json2["nonzero"];

$urlok22 = "http://chainz.cryptoid.info/ok/api.dws?q=ticker.btc";
$okbtcprice = json_decode(file_get_contents($urlok22), true);

$urlok221 = "http://chainz.cryptoid.info/ok/api.dws?q=ticker.usd";
$okprice = json_decode(file_get_contents($urlok221), true);

$urlok222 = "https://btc.cryptoid.info/btc/api.dws?q=ticker.usd";
$btcprice = json_decode(file_get_contents($urlok222), true);

$fp = fopen('txt/totady.txt', 'w') or die("can't open file");
fwrite($fp, $totady);
fclose($fp);

$fp = fopen('txt/nonady.txt', 'w') or die("can't open file");
fwrite($fp, $nonady);
fclose($fp);

$fp = fopen('txt/btcprice.txt', 'w') or die("can't open file");
fwrite($fp, $btcprice);
fclose($fp);

$fp = fopen('txt/okprice.txt', 'w') or die("can't open file");
fwrite($fp, $okprice);
fclose($fp);

$fp = fopen('txt/okbtcprice.txt', 'w') or die("can't open file");
fwrite($fp, $okbtcprice);
fclose($fp);

$urlok4 = "https://api.coincap.io/v2/assets/okcash";
$json4 = json_decode(file_get_contents($urlok4), true);
$okrank = $json4["data"]["rank"];
$marketcap = $json4["data"]["marketCapUsd"];
// $okprice = $json4["data"]["priceUsd"];

$fp = fopen('txt/okrank.txt', 'w') or die("can't open file");
fwrite($fp, $okrank);
fclose($fp);



//$fp = fopen('stats/marketcap.txt', 'w') or die("can't open file");
//fwrite($fp, $marketcap);
//fclose($fp);

// Okcashblockhalf data 

// $btcdata = file_get_contents('https://api.coinmarketcap.com/v1/ticker/bitcoin/');
// $btcusdprice = json_decode($btcdata, true);
// $btcprice = (float)$btcusdprice["0"]["price_usd"];

// $fp = fopen('txt/btcprice.txt', 'w') or die("can't open file");
// fwrite($fp, $btcprice);
// fclose($fp);

// $okcdata = file_get_contents('https://api.coinmarketcap.com/v1/ticker/okcash/');
// $okcprice = json_decode($okcdata, true);
// $okprice = (float)$okcprice["0"]["price_usd"];
// $okrank = (float)$okcprice["0"]["rank"];
// $okbtcprice = (float)$okcprice["0"]["price_btc"];

// $fp = fopen('txt/okprice.txt', 'w') or die("can't open file");
// fwrite($fp, $okprice);
// fclose($fp);

// $fp = fopen('txt/okrank.txt', 'w') or die("can't open file");
// fwrite($fp, $okrank);
// fclose($fp);

// $fp = fopen('txt/okbtcprice.txt', 'w') or die("can't open file");
// fwrite($fp, $okbtcprice);
// fclose($fp);

$difficulty = json_decode(file_get_contents("http://chainz.cryptoid.info/ok/api.dws?q=getdifficulty"), true);

$fp = fopen('txt/difficulty.txt', 'w') or die("can't open file");
fwrite($fp, $difficulty);
fclose($fp);

$blocks = json_decode(file_get_contents("http://chainz.cryptoid.info/ok/api.dws?q=getblockcount"), true);

$fp = fopen('txt/blocks.txt', 'w') or die("can't open file");
fwrite($fp, $blocks);
fclose($fp);

$coins = json_decode(file_get_contents("http://chainz.cryptoid.info/ok/api.dws?q=circulating"), true);

$fp = fopen('txt/coins.txt', 'w') or die("can't open file");
fwrite($fp, $coins);
fclose($fp);

$blocksRemaining = CalculateRemainingBlocks($blocks, $blockHalvingSubsidy);

$fp = fopen('txt/blocksRemaining.txt', 'w') or die("can't open file");
fwrite($fp, $blocksRemaining);
fclose($fp);


$avgBlockTime = $blockTargetSpacing;

$fp = fopen('txt/avgBlockTime.txt', 'w') or die("can't open file");
fwrite($fp, $avgBlockTime);
fclose($fp);



$blocksPerDay = (86400 / $avgBlockTime);

$fp = fopen('txt/blocksPerDay.txt', 'w') or die("can't open file");
fwrite($fp, $blocksPerDay);
fclose($fp);

$blockHalvingEstimation = $blocksRemaining / $blocksPerDay * 24 * 60 * 60;

$fp = fopen('txt/blockHalvingEstimation.txt', 'w') or die("can't open file");
fwrite($fp, $blockHalvingEstimation);
fclose($fp);

$blockString = '+' . (int)$blockHalvingEstimation . ' second';

$fp = fopen('txt/blockString.txt', 'w') or die("can't open file");
fwrite($fp, $blockString);
fclose($fp);

$blockReward = 3.95;

$fp = fopen('txt/blockReward.txt', 'w') or die("can't open file");
fwrite($fp, $blockReward);
fclose($fp);

$coinsRemaining = $blocksRemaining * $blockReward;

$fp = fopen('txt/coinsRemaining.txt', 'w') or die("can't open file");
fwrite($fp, $coinsRemaining);
fclose($fp);

$nextHalvingHeight = $blocks + $blocksRemaining;

$fp = fopen('txt/nextHalvingHeight.txt', 'w') or die("can't open file");
fwrite($fp, $nextHalvingHeight);
fclose($fp);

$inflationRate = CalculateInflationRate($coins, $blockReward, $blocksPerDay);

$fp = fopen('txt/inflationRate.txt', 'w') or die("can't open file");
fwrite($fp, $inflationRate);
fclose($fp);

$inflationRateNextHalving = CalculateInflationRate(CalculateTotalCoins($blockStartingReward, $nextHalvingHeight, $blockHalvingSubsidy), 
	CalculateRewardPerBlock($blockStartingReward, $nextHalvingHeight, $blockHalvingSubsidy), $blocksPerDay);
	
$fp = fopen('txt/inflationRateNextHalving.txt', 'w') or die("can't open file");
fwrite($fp, $inflationRateNextHalving);
fclose($fp);

$price = $okprice;

$fp = fopen('txt/price.txt', 'w') or die("can't open file");
fwrite($fp, $price);
fclose($fp);


// Currency convertions

$mxndata = file_get_contents('https://api.coingecko.com/api/v3/simple/price?ids=okcash&vs_currencies=eur%2Ccny%2Cmxn%2Crub%2Cjpy%2Cbrl');
$mprice = json_decode($mxndata, true);
$mxnprice = (float)$mprice["okcash"]["mxn"];
$eurprice = (float)$mprice["okcash"]["eur"];
$cnyprice = (float)$mprice["okcash"]["cny"];
$rubprice = (float)$mprice["okcash"]["rub"];
$jpyprice = (float)$mprice["okcash"]["jpy"];
$brlprice = (float)$mprice["okcash"]["brl"];


// $mxnprice = ($price * $ratemxprice);

$fp = fopen('txt/mxnprice.txt', 'w') or die("can't open file");
fwrite($fp, $mxnprice);
fclose($fp);

// $eurprice = ($price * $rateeuprice);

$fp = fopen('txt/eurprice.txt', 'w') or die("can't open file");
fwrite($fp, $eurprice);
fclose($fp);

// $cnyprice = ($price * $ratecnprice);

$fp = fopen('txt/cnyprice.txt', 'w') or die("can't open file");
fwrite($fp, $cnyprice);
fclose($fp);

// $rubprice = ($price * $rateruprice);

$fp = fopen('txt/rubprice.txt', 'w') or die("can't open file");
fwrite($fp, $rubprice);
fclose($fp);

// $jpyprice = ($price * $ratejpprice);

$fp = fopen('txt/jpyprice.txt', 'w') or die("can't open file");
fwrite($fp, $jpyprice);
fclose($fp);

// $brlprice = ($price * $ratebrprice);

$fp = fopen('txt/brlprice.txt', 'w') or die("can't open file");
fwrite($fp, $brlprice);
fclose($fp);


// Functions

function GetHalvings($blocks, $subsidy) {
	return (int)($blocks / $subsidy);
}

function CalculateRemainingBlocks($blocks, $subsidy) {
	$halvings = GetHalvings($blocks, $subsidy);
	if ($halvings == 0) {
		return $subsidy - $blocks;
	} else {
		$halvings += 1;
		return $halvings * $subsidy - $blocks;
	}
}

function CalculateRewardPerBlock($blockReward, $blocks, $subsidy) {
	$halvings = GetHalvings($blocks, $subsidy);
	$blockReward >>= $halvings;
	return $blockReward;
}

function CalculateTotalCoins($blockReward, $blocks, $subsidy) {
	$halvings = GetHalvings($blocks, $subsidy);
	if ($halvings == 0) {
		return $blocks * $blockReward;
	} else {
		$coins = 0;
		for ($i = 0; $i < $halvings; $i++) {
			$coins += $blockReward * $subsidy;
			$blocks -= $subsidy;
			$blockReward = $blockReward / 2; 
		}
		$coins += $blockReward * $blocks;
		return $coins;
	}
}

function CalculateInflationRate($totalCoins, $blockReward, $blocksPerDay) {
	return pow((($totalCoins + $blockReward) / $totalCoins ), (365 * $blocksPerDay)) - 1;
}

function GetFileContents($filename) {
	$file = fopen($filename, "r") or die("Unable to open file!");
	$result = fread($file,filesize($filename));
	fclose($file);
	return $result;
}

?>