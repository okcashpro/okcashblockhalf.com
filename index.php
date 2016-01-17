<?php
require_once 'jsonRPCClient.php';

$bitcoin = new jsonRPCClient('http://user:pw@127.0.0.1:8332/');

try {
	$info = $bitcoin->getinfo();
} catch (Exception $e) {
	echo nl2br($e->getMessage()).'<br />'."\n"; 
	die();
}

// Bitcoin settings
$blockStartingReward = 50;
$blockHalvingSubsidy = 210000;
$blockTargetSpacing = 10;
$maxCoins = 21000000;

$blocks = $info['blocks'];
$coins = CalculateTotalCoins($blockStartingReward, $blocks, $blockHalvingSubsidy);
$blocksRemaining = CalculateRemainingBlocks($blocks, $blockHalvingSubsidy);
$blocksPerDay = (60 / $blockTargetSpacing) * 24;
$blockHalvingEstimation = $blocksRemaining / $blocksPerDay * 24 * 60 * 60;
$blockString = '+' . $blockHalvingEstimation . ' second';
$blockReward = CalculateRewardPerBlock($blockStartingReward, $blocks, $blockHalvingSubsidy);
$coinsRemaining = $blocksRemaining * $blockReward;
$nextHalvingHeight = $blocks + $blocksRemaining;
$inflationRate = CalculateInflationRate($coins, $blockReward, $blocksPerDay);
$inflationRateNextHalving = CalculateInflationRate(CalculateTotalCoins($blockStartingReward, $nextHalvingHeight, $blockHalvingSubsidy), 
	CalculateRewardPerBlock($blockStartingReward, $nextHalvingHeight, $blockHalvingSubsidy), $blocksPerDay);
$price = 225; // change to dynamic way of getting price

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
	return pow((($totalCoins + $blockReward) / $totalCoins), (365 * $blocksPerDay)) - 1;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Bitcoin Block Reward Halving Countdown website">
	<meta name="author" content="">
	<link rel="shortcut icon" href="favicon.png">
	<title>Bitcoin Block Reward Halving Countdown</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/flipclock.css">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script src="js/flipclock.js"></script>	
</head>
<body>
	<div class="container">
		<div class="page-header" style="text-align:center">
			<h3>Bitcoin Block Reward Halving Countdown</h3>
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
			Reward-Drop ETA date: <strong><?=date('m-d-Y H:i:s', strtotime($blockString, time()))?></strong><br/><br/>
			<p>The Bitcoin block mining reward halves every <?=number_format($blockHalvingSubsidy)?> blocks, the coin reward will decrease from <?=$blockReward?> to <?=$blockReward / 2 ?> coins. 
			<br/><br/>
		</div>
		<table class="table table-striped">
			<tr><td><b>Total Bitcoins in circulation:</b></td><td align = "right"><?=number_format($coins)?></td></tr>
			<tr><td><b>Total Bitcoins to be produced:</b></td><td align = "right"><?=number_format($maxcoins)?></td></tr>
			<tr><td><b>Percentage of total Bitcoins mined:</b></td><td align = "right"><?=number_format($coins / $maxCoins * 100 / 1, 4)?>%</td></tr>
			<tr><td><b>Total Bitcoins left to mine until next blockhalf:</b></td><td align = "right"><?= number_format($coinsRemaining);?></td></tr>
			<tr><td><b>Bitcoin price (USD):</b></td><td align = "right">$<?=number_format($price, 2);?></td></tr>
			<tr><td><b>Market capitilsation (USD):</b></td><td align = "right">$<?=number_format($coins * $price, 2);?></td></tr>
			<tr><td><b>Approximate Bitcoins generated per day:</b></td><td align = "right"><?=number_format($blocksPerDay * $blockReward);?></td></tr>	
			<tr><td><b>Bitcoin inflation rate per annum:</b></td><td align = "right"><?=number_format($inflationRate * 100 / 1, 2);?>%</td></tr>
			<tr><td><b>Bitcoin inflation rate per annum at next block halving event:</b></td><td align = "right"><?=number_format($inflationRateNextHalving * 100 / 1, 2);?>%</td></tr>
			<tr><td><b>Bitcoin inflation per day (USD):</b></td><td align = "right">$<?=number_format($blocksPerDay * $blockReward * $price);?></td></tr>
			<tr><td><b>Bitcoin inflation until next blockhalf event: (USD):</b></td><td align = "right">$<?=number_format($coinsRemaining * $price);?></td></tr>
			<tr><td><b>Total blocks:</b></td><td align = "right"><?=number_format($blocks);?></td></tr>
			<tr><td><b>Blocks until mining reward is halved:</b></td><td align = "right"><?=number_format($blocksRemaining);?></td></tr>
			<tr><td><b>Approximate block generation time:</b></td><td align = "right"><?=$blockTargetSpacing?> minutes</td></tr>
			<tr><td><b>Approximate blocks generated per day:</b></td><td align = "right"><?=$blocksPerDay;?></td></tr>
			<tr><td><b>Difficulty:</b></td><td align = "right"><?=number_format($info['difficulty']);?></td></tr>
			<tr><td><b>Hash rate:</b></td><td align = "right"><?=number_format($bitcoin->getnetworkhashps() / 1000 / 1000 / 1000 / 1000 / 1000 / 1000) . 'Exahashes/s';?></td></tr>
		</table>
		<div style="text-align:center">
			<img src="../images/bitcoin.png" width="100px"; height="100px">
			<br/>
			<h2><a href="http://www.litecoinblockhalf.com">Litecoin Block Halving Countdown</a></h2>
		</div>
	</div>
</body>
</html>