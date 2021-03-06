<?php

// Okcashblockhalf settings

$blockStartingReward = file_get_contents("txt/blockStartingReward.txt");

$blockHalvingSubsidy = file_get_contents("txt/blockHalvingSubsidy.txt");

$blockTargetSpacing = file_get_contents("txt/blockTargetSpacing.txt");

$maxCoins = file_get_contents("txt/maxCoins.txt");

$okstakereward = file_get_contents("txt/okstakereward.txt");


// Okcashblockhalf data

$btcprice = file_get_contents("txt/btcprice.txt");

$okprice = file_get_contents("txt/okprice.txt");

$okrank = file_get_contents("txt/okrank.txt");

$okbtcprice = file_get_contents("txt/okbtcprice.txt");

$difficulty = file_get_contents("txt/difficulty.txt");

$blocks = file_get_contents("txt/blocks.txt");

$coins = file_get_contents("txt/coins.txt");

$blocksRemaining = file_get_contents("txt/blocksRemaining.txt");

$avgBlockTime = file_get_contents("txt/avgBlockTime.txt");

$blocksPerDay = file_get_contents("txt/blocksPerDay.txt");

$blockHalvingEstimation = file_get_contents("txt/blockHalvingEstimation.txt");

$blockString = file_get_contents("txt/blockString.txt");

$blockReward = file_get_contents("txt/blockReward.txt");

$coinsRemaining = file_get_contents("txt/coinsRemaining.txt");

$nextHalvingHeight = file_get_contents("txt/nextHalvingHeight.txt");

$inflationRate = file_get_contents("txt/inflationRate.txt");

$inflationRateNextHalving = file_get_contents("txt/inflationRateNextHalving.txt");

$price = file_get_contents("txt/price.txt");

$mxnprice = file_get_contents("txt/mxnprice.txt");

$eurprice = file_get_contents("txt/eurprice.txt");

$cnyprice = file_get_contents("txt/cnyprice.txt");

$rubprice = file_get_contents("txt/rubprice.txt");

$jpyprice = file_get_contents("txt/jpyprice.txt");

$brlprice = file_get_contents("txt/brlprice.txt");

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Okcash Block Reward Countdown website">
	<meta name="author" content="">
	<meta http-equiv="refresh" content="60">
	<link rel="shortcut icon" href="favicon.png">
	<title>OK $<?=number_format($price, 4);?> / BTC $<?=number_format($btcprice, 4);?> - Okcash Block Reward Countdown</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/flipclock.css">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
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
		<div class="page-header" style="text-align:center;margin-top:-5px">
			<h1>Okcash Block Reward Halving Countdown</h1>
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
		<div style="text-align:center;margin-top:-10px">
            Reward-Drop ETA date: <strong><?=date('d M Y H:i:s', strtotime($blockString, time()))?> UTC</strong><br/>
		</div>
        <h2>What is a block halving event?</h2>
		<p> As part of Okcash's coin issuance, miners/stakers are rewarded a certain amount of Okcash coins whenever a block is produced (approximately every 69 seconds).<br/>
		When Okcash first started, 2000 OK coins per block were given as a reward to PoW miners. After the block number 33,186 PoW evolved to LTSS PoS and halvings have been ocurring at different time schedules taking in consideration 501,257 blocks per year, the block reward halves and will keep on halving until the block 27,589,135 (approximately by year 2070). <br/>
		As of now, the block reward is under the LTSS PoSv2 system at a rate of <b>22%</b> per year [Variable block reward + variable network growth by net staking percentage] and will decrease and evolve to LTSS PoSv3hybrid after next halving with reward of <b>5.8</b> OK coins per block [Semi-static block reward + predictable network growth no matter net staking percentage, achieving Bitcoin predictability under Okcash unique LTSS PoS System.(Energy Friendly)]</p>

		<h2> Why was this done?</h2>
		<p> Okcash was designed as a deflationary currency. Like gold and Bitcoin, the premise is that over time, the issuance of OK coins will decrease and thus become scarcer over time. As Okcash become scarcer and if demand for them increases over time, Okcash can be used as a hedge against inflation as the price, guided by price equilibrium is bound to increase. On the flip side, fiat currencies (like the US dollar), inflate over time as its monetary supply increases, leading to a decrease in purchasing power. This is known as monetary debasement by inflation. A simple example would be to compare housing prices decades ago to now and you'll notice that they've increased over time!</p>

		<h2> Predictable monetary supply</h2>
		<p> Since we know Okcash's issuance over time, people can rely on programmed/controlled supply. This is helpful to understand what the current inflation rate of Okcash is, what the future inflation rate will be at a specific point in time, how many OK coins are in circulation and how many remain left to be mined/staked. </p>
		<a href="https://chainz.cryptoid.info/ok/#@inflation" target="_blank"><img src="../images/okcash-inflation-chart.png" alt="okcash inflation chart" style="display: block; margin-left: auto; margin-right: auto; width:75%"></img></a>

		<h2> Who controls the issuance of Okcash (OK coins)?</h2>
		<p> The network itself controls the issuance of OK coins, derived by consensus through all Okcash participants. Ever since Okcash was first designed, the following consensus rules exist to this day:
		<ul>
			<li> 105,000,000 OK coins to ever be produced</li>
			<li> Target of 69-second block intervals</li>
			<li> Halving event schedule based on 501,257 block/year. (approximately every 1,2,10 years)</li>
			<li> Block reward diminish continually every halving event until block 27,589,135 (approximately by year 2070)</li>
			<li> Last OK coins are expected to be mined/staked approximately by year 2148)</li>
		</ul>
		Any change to these parameters requires all Okcash participants to agree by consensus to approve the change.</p>

        <h2> How to buy Okcash? </h2>
		<p> The community keeps an updated list of exchanges over <a href="https://okcash.co/#exchanges" target"_blank">okcash.co</a> where you can check the best option for you. 
		</p>
		<h2 id="stats">Stats </h2>
		<!-- <div align="right"><a href="bhalf.php" target="_self"><span class="gb">DARK THEME</span></a></div> <br/> <br/> --> 
		<table class="table table-striped">
		    <tr><td><b>CoinCap (worldwide rank):</b></td><td align = "right"><a href="http://coinmarketcap.com/currencies/okcash/" target="_blank"><span class="gg"><?=number_format($okrank)?></span></a></td></tr>
			<tr><td><b>Ongoing Staking/Mining Percentage:</b></td><td align = "right">22 % / (1/3) Net Staking = Expected Net Growth Staking <?=number_format(($okstakereward / 3), 2) . ' % Year';?></td></tr>
			<tr><td><b>Total OK coins in circulation:</b></td><td align = "right"><?=number_format($coins)?></td></tr>
			<tr><td><b>Total OK coins to ever be produced:</b></td><td align = "right"><?=number_format($maxCoins)?></td></tr>
			<tr><td><b>Percentage of total OK coins mined:</b></td><td align = "right"><?=number_format($coins / $maxCoins * 100 / 1, 4)?>%</td></tr>
			<tr><td><b>Total OK coins left to mine:</b></td><td align = "right"><?=number_format($maxCoins - $coins)?></td></tr>
			<tr><td><b>Approximate OK coins left to mine until next blockhalf:</b></td><td align = "right"><?= number_format($coinsRemaining / 3);?></td></tr>
			<tr><td><b>Approximate OK coins generated per day:</b></td><td align = "right"><?=number_format($blocksPerDay * $blockReward);?></td></tr>
			<tr><td><b>Bitcoin price (USD):</b></td><td align = "right">$ <?=number_format($btcprice, 4);?> <img src="../images/flag-usa.png"></td></tr>
			<tr><td><b>OK price (BTC):</b></td><td align = "right">฿ <?=number_format($okbtcprice, 8);?> <img src="../images/bitcoin.png"></td></tr>
			<tr><td><b>OK price (USD):</b></td><td align = "right">$ <?=number_format($price, 4);?> <img src="../images/flag-usa.png"></td></tr>
            <tr><td><b>OK price (EUR):</b></td><td align = "right">€ <?=number_format($eurprice, 4);?> <img src="../images/flag-european-union.png"></td></tr>
			<tr><td><b>OK price (CNY):</b></td><td align = "right">¥ <?=number_format($cnyprice, 4);?> <img src="../images/flag-china.png"></td></tr>
			<tr><td><b>OK price (MXN):</b></td><td align = "right">$ <?=number_format($mxnprice, 4);?> <img src="../images/flag-mexico.png"></td></tr>
			<tr><td><b>OK price (RUB):</b></td><td align = "right">&#x20bd; <?=number_format($rubprice, 4);?> <img src="../images/flag-russia.png"></td></tr>
			<tr><td><b>OK price (JPY):</b></td><td align = "right">¥ <?=number_format($jpyprice, 4);?> <img src="../images/flag-japan.png"></td></tr>
			<tr><td><b>OK price (BRL):</b></td><td align = "right">R$ <?=number_format($brlprice, 4);?> <img src="../images/flag-brazil.png"></td></tr>
			<tr><td><b>OK Market capitalization (USD):</b></td><td align = "right">$<?=number_format($coins * $price, 2);?></td></tr>
			<tr><td><b>Okcash inflation rate per annum:</b></td><td align = "right"><?=number_format($okstakereward / 1, 2);?>% / (1/3) Net Staking</td></tr>
			<tr><td><b>Okcash inflation rate per annum after next block change event:</b></td><td align = "right">11 % / (1/3) Net Staking = Next Net Growth Staking <?=number_format((($okstakereward /2) / 3), 2) . ' % Year';?></td></tr> 
			<tr><td><b>Okcash inflation per day (USD):</b></td><td align = "right">$<?=number_format($blocksPerDay * $blockReward * $price);?></td></tr>
			<tr><td><b>Okcash inflation until next blockhalf event based on current price (USD):</b></td><td align = "right">$<?=number_format(($coinsRemaining / 3) * $price);?></td></tr>
			<tr><td><b>Total blocks:</b></td><td align = "right"><a href="https://chainz.cryptoid.info/ok/" target="_blank"><span class="gg"><?=number_format($blocks);?></a></span></td></tr>
			<tr><td><b>Blocks until mining reward is halved:</b></td><td align = "right"><?=number_format($blocksRemaining);?></td></tr>
			<tr><td><b>Approximate block generation time:</b></td><td align = "right"><?=number_format($blockTargetSpacing, 1);?> seconds</td></tr>
			<tr><td><b>Approximate blocks generated per day:</b></td><td align = "right"><?=$blocksPerDay;?></td></tr>
			<tr><td><b>Difficulty:</b></td><td align = "right"><?=number_format($difficulty);?></td></tr>
		</table> 
		<div style="text-align:center">
		<img src="../images/Okcash-pos-ltss-schedule.png"> 
		</div>
		<br/>
		<div style="text-align:center">
			<img src="../images/okcash.png" width="100px"; height="100px">
			<br/>
			<h2><a href="http://www.bitcoinblockhalf.com" target="_blank"><span class="bb">Bitcoin Block Halving Countdown</span></a></h2>
		</div>
	</div>
</body>
</html>