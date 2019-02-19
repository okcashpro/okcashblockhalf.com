<?php
require_once 'easyokcash.php';

$okcash = new Okcash('TestNumberOne01','PasswordTest0101','localhost','6969');

try {
	$info = $okcash->getinfo();
} catch (Exception $e) {
	echo nl2br($e->getMessage()).'<br />'."\n"; 
	die();
}

// Okcash settings
$blockStartingReward = 4.5;
$blockHalvingSubsidy = 2025028;
$blockTargetSpacing = 1.12;
$maxCoins = 105000000;

$btcdata = file_get_contents('https://api.coinmarketcap.com/v1/ticker/bitcoin/');
$btcusdprice = json_decode($btcdata, true);
$btcprice = (float)$btcusdprice["0"]["price_usd"];

$okcdata = file_get_contents('https://api.coinmarketcap.com/v1/ticker/okcash/');
$okcprice = json_decode($okcdata, true);
$okprice = (float)$okcprice["0"]["price_usd"];
$okrank = (float)$okcprice["0"]["rank"];
$okbtcprice = (float)$okcprice["0"]["price_btc"];

$mxndata = file_get_contents('http://api.fixer.io/latest?base=USD');
$mprice = json_decode($mxndata, true);
$ratemxprice = (float)$mprice["rates"]["MXN"];
$rateeuprice = (float)$mprice["rates"]["EUR"];
$ratecnprice = (float)$mprice["rates"]["CNY"];
$rateruprice = (float)$mprice["rates"]["RUB"];
$ratejpprice = (float)$mprice["rates"]["JPY"];
$ratebrprice = (float)$mprice["rates"]["BRL"];


$difficulty = json_decode(file_get_contents("http://chainz.cryptoid.info/ok/api.dws?q=getdifficulty"), true);
$blocks = json_decode(file_get_contents("http://chainz.cryptoid.info/ok/api.dws?q=getblockcount"), true);
$coins = json_decode(file_get_contents("http://chainz.cryptoid.info/ok/api.dws?q=circulating"), true);
$blocksRemaining = CalculateRemainingBlocks($blocks, $blockHalvingSubsidy);

$avgBlockTime = GetFileContents("timebetweenblocks.txt");
if (empty($avgBlockTime)) {
	$avgBlockTime = $blockTargetSpacing;
}

$okstakereward = 5;
$blocksPerDay = (60 / $avgBlockTime) * 24;
$blockHalvingEstimation = $blocksRemaining / $blocksPerDay * 24 * 60 * 60;
$blockString = '+' . (int)$blockHalvingEstimation . ' second';
$blockReward = CalculateRewardPerBlock($blockStartingReward, $blocks, $blockHalvingSubsidy);
$coinsRemaining = $blocksRemaining * $blockReward;
$nextHalvingHeight = $blocks + $blocksRemaining;
$inflationRate = CalculateInflationRate($coins, $blockReward, $blocksPerDay);
$inflationRateNextHalving = CalculateInflationRate(CalculateTotalCoins($blockStartingReward, $nextHalvingHeight, $blockHalvingSubsidy), 
	CalculateRewardPerBlock($blockStartingReward, $nextHalvingHeight, $blockHalvingSubsidy), $blocksPerDay);
$price = $okprice;

$mxnprice = ($price * $ratemxprice);
$eurprice = ($price * $rateeuprice);
$cnyprice = ($price * $ratecnprice);
$rubprice = ($price * $rateruprice);
$jpyprice = ($price * $ratejpprice);
$brlprice = ($price * $ratebrprice);

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

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Okcash Block Reward Halving Countdown website">
	<meta name="author" content="">
	<meta http-equiv="refresh" content="300">
	<link rel="shortcut icon" href="favicon.png">
	<title>OK $ <?=number_format($price, 4);?> BTC $ <?=number_format($btcprice, 4);?> - Okcash Block Reward Halving Countdown</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/flipclock.css">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script src="js/flipclock.js"></script>	
</head>
<body>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-87608748-1', 'auto');
  ga('send', 'pageview');

</script>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.8";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
	<div class="container">
		<div class="page-header" style="text-align:center">
			<h3>Okcash Block Reward Halving Countdown</h3>
		</div>
		<div class="flip-counter clock" style="display: flex; align-items: center; justify-content: center;"></div>
		<script type="text/javascript">
			var clock;

			$(document).ready(function() {
				clock = $('.clock').FlipClock(<?=$blockHalvingEstimation?>, {
					clockFace: 'DailyCounter',
					countdown: true
				});
			});
		</script>
		<div style="text-align:center">
			Reward-Drop ETA date: <strong><?=date('d M Y H:i:s', strtotime($blockString, time()))?></strong><br/><br/>
			<p>The Next Okcash block staking/mining reward halves on block number <?=number_format($blockHalvingSubsidy)?>.<br/> The yearly coin percentage reward will decrease from 5% to 2.5% yearly over the staked coins. 
			<br/><br/>
		</div>
		<div align="right"><div class="fb-like" data-href="https://www.facebook.com/OKCashCrypto/" data-layout="standard" data-action="like" data-size="small" data-show-faces="false" data-share="true"></div></div> <br/><br/>
		<table class="table table-striped">
		    <tr><td><b>Coin Market cap (worldwide rank):</b></td><td align = "right"><a href="http://coinmarketcap.com/currencies/okcash/" target="_blank"><?=number_format($okrank)?></a></td></tr>
			<tr><td><b>Actual Staking/Mining Percentage:</b></td><td align = "right"><?=number_format($okstakereward, 2) . ' % / Year';?></td></tr>
			<tr><td><b>Total OK coins in circulation:</b></td><td align = "right"><?=number_format($coins)?></td></tr>
			<tr><td><b>Total OK coins to ever be produced:</b></td><td align = "right"><?=number_format($maxCoins)?></td></tr>
			<tr><td><b>Percentage of total OK coins mined:</b></td><td align = "right"><?=number_format($coins / $maxCoins * 100 / 1, 4)?>%</td></tr>
			<tr><td><b>Total OK coins left to mine:</b></td><td align = "right"><?=number_format($maxCoins - $coins)?></td></tr>
			<tr><td><b>Total OK coins left to mine until next blockhalf:</b></td><td align = "right"><?= number_format($coinsRemaining);?></td></tr>
			<tr><td><b>Approximate OK coins generated per day:</b></td><td align = "right"><?=number_format($blocksPerDay * $blockReward);?></td></tr>
			<tr><td><b>Bitcoin price (USD):</b></td><td align = "right">$ <?=number_format($btcprice, 4);?> <img src="../images/flag-usa.png"></td></tr>
			<tr><td><b>OK price (BTC):</b></td><td align = "right">฿ <?=number_format($okbtcprice, 8);?> <img src="../images/bitcoin.png"></td></tr>
			<tr><td><b>OK price (USD):</b></td><td align = "right">$ <?=number_format($price, 4);?> <img src="../images/flag-usa.png"></td></tr>
			<tr><td><b>Market capitalization (USD):</b></td><td align = "right">$<?=number_format($coins * $price, 2);?></td></tr>
			<tr><td><b>Okcash inflation rate per annum:</b></td><td align = "right"><?=number_format($okstakereward / 1, 2);?>%</td></tr>
			<tr><td><b>Okcash inflation rate per annum at next block halving event:</b></td><td align = "right"><?=number_format($okstakereward / 2 / 1, 2);?>%</td></tr> 
			<tr><td><b>Okcash inflation per day (USD):</b></td><td align = "right">$<?=number_format($blocksPerDay * $blockReward * $price);?></td></tr>
			<tr><td><b>Okcash inflation until next blockhalf event based on current price (USD):</b></td><td align = "right">$<?=number_format($coinsRemaining * $price);?></td></tr>
			<tr><td><b>Total blocks:</b></td><td align = "right"><a href="https://chainz.cryptoid.info/ok/" target="_blank"><?=number_format($blocks);?></a></td></tr>
			<tr><td><b>Blocks until mining reward is halved:</b></td><td align = "right"><?=number_format($blocksRemaining);?></td></tr>
			<tr><td><b>Approximate block generation time:</b></td><td align = "right">72 seconds</td></tr>
			<tr><td><b>Approximate blocks generated per day:</b></td><td align = "right"><?=$blocksPerDay;?></td></tr>
			<tr><td><b>Difficulty:</b></td><td align = "right"><?=number_format($difficulty);?></td></tr>
		</table>
		<div style="text-align:center">
			<img src="../images/okcash.png" width="100px"; height="100px">
			<br/>
			<h2><a href="http://www.bitcoinblockhalf.com" target="_blank">Bitcoin Block Halving Countdown</a></h2>
		</div>
	</div>
</body>
</html>