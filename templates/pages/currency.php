<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h1>Change Currency</h1>
		</div>
		<?php foreach ($currencies as $continent => $currency_list) { ?>
			<div class="col-md-12">
				<h3><?php echo htmlspecialchars(${'text_continent_'.strtolower($continent)}); ?></h3>
				<ul>
					<?php foreach ($currency_list as $currency => $country) { ?>
						<li><a href="<?php echo $this->url->getUrl('Root', 'index', [], ['set_country' => $country]); ?>"><?php echo htmlspecialchars(${'text_currency_'.strtolower($currency)}.' ('.$currency.')'); ?></a></li>
					<?php } ?>
				</ul>
			</div>
		<?php } ?>
	</div>
</div>
