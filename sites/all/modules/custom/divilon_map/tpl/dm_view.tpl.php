<div class="row">
	<!-- <div class="col-sm-3 map-sidebar">
		<div class="bb">
			<div class="clearfix">
				<span class="toggle-selection pull-right cy" data-state="false"><?php //print t('Deselect all') ?></span>
			</div>
			<?php //foreach ($vocs as $id => $voc): ?>
				<div class="select-items">
					<ul>
						<li class="select-item title form-item form-type-title">
							<label class="option" for="voc-<?php //print $id; ?>"><?php //print $voc['title']; ?></label>
						</li>
						<?php //foreach ($voc['items'] as $n => $item): ?>
							<li class="select-item filter-item form-item form-type-checkbox collapsed">
								<input type="checkbox" id="item-<?php //print $item['id']; ?>" name="item-<?php //print $item['id']; ?>" value="<?php //print $item['id']; ?>" class="form-checkbox" checked>
								<label class="option" for="item-<?php //print $item['id']; ?>"><?php //print $item['title'] ?></label>
							</li>
						<?php //endforeach; ?>
					</ul>
				</div>
			<?php //endforeach; ?>
		</div>
	</div> -->
	<div class="col-sm-12">
		<div id="divilon_map"></div>
	</div>
</div>