<div class="container">
	<div class="row">
		<h1>Exchange Rates Updated</h1>
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
