<div class="container">
	<div class="row">
		<h1>Exchange Rates - <a href="<?php echo $this->url->getUrl('administrator\ExchangeRates', 'updateRates'); ?>"><small>Update Rates</small></a></h1>
	</div>
	<div class ="row">
		<table class="table">
			<?php foreach ($rates as $rate) { ?>
				<tr>
					<td><?php echo $rate->currency; ?></td>
					<td><?php echo $rate->value; ?></td>
				</tr>
			<?php } ?>
		</table>
	</div>
</div>
