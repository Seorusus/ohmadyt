(function ($) {
	var currentLayerID, minValue = 0, maxValue = 0;
	Drupal.behaviors.divilonTempMap = {
		attach: function (context, settings) {
			$('body').once(function () {
				//currentLayerID = (settings.temperature) ? Object.keys(settings.temperature)[0] : false;
				currentLayerID = false;
				var themeElements = {
					selectLayer: '.select-layer ul',
					tableMap: '.table-map',
					mapLegend: '.legend'
				}
				$(themeElements['selectLayer']).html(Drupal.theme('selectLayer', settings.temperature));
				$('body').on('click', '.select-layer li', function (e) {
					currentLayerID = e.currentTarget.dataset.id;
					renderMap();
				});
				$('svg').contextmenu(function (e) {
					e.preventDefault();
					if (currentLayerID) {
						saveAsPng({ left: e.pageX, top: e.pageY });
					}
				});
				$('body').on('click', '.svg-map', function (e) {
					$('.context-menu-map').remove();
				});
				var href;
				if (currentLayerID === false) return;
				renderMap();
				function renderMap() {
					minValue = 0, maxValue = 0;
					var localitems = settings.temperature[currentLayerID].legend;
					for (var key in localitems) {
						var val = parseFloat(localitems[key].to);
						if (val > maxValue) {
							maxValue = val;
						}
						if (val < minValue) {
							minValue = val;
						}
					}
					for (var hook in themeElements) {
						$(themeElements[hook]).html(Drupal.theme(hook, settings.temperature));
					}
					renderSVG();
				}
				function renderSVG() {
					var svg = $('.svg-map');
					values = settings.temperature[currentLayerID].values;
					$('[data-id^="field"]', svg).attr('style', 'fill: #cecece');
					for (var key in values) {
						if (key != 'field_cr1') {
							$('[data-id="' + key + '"]', svg).attr('style', 'fill: ' + getColorForCnt(parseFloat(values[key].value)));
						}
					}
				}
				function saveAsPng(c) {
					html2canvas(document.querySelector("#divilon-map"), {
						onclone: function(document) {
							document.querySelector('.print-btn').remove();
							document.querySelector('.select-layer').remove();
							document.querySelector('#divilon-map').style.padding = '40px';
							
						}
					}).then(canvas => {
						var data = canvas.toDataURL();
						href = data;
						$('.context-menu-map').remove();
						$('<div />', {
							css: {
								left: c.left,
								top: c.top
							},
							class: 'context-menu-map',
							html: $('<a />', {
								download: settings.temperature[currentLayerID].label + ".png",
								href: href,
								html: Drupal.t('Save as PNG')
							})
						}).appendTo($('body'));
					});
				}
			});
		}
	}
	function getColorForCnt(cnt) {
		if (cnt === null) return '#d7d7d7';
		var legend = Drupal.settings.temperature[currentLayerID].legend;
		var color = false;
		for (var key in legend) {
			if (color === false && cnt >= parseFloat(legend[key].from) && cnt <= parseFloat(legend[key].to)) {
				color = legend[key].color;
			}
		}
		return color ? color : '#d7d7d7';
	}
	Drupal.theme.prototype.selectLayer = function (items) {
		var output = [];
		var sortable = [];
		for (var key in items) {
			sortable.push([key, items[key].created]);
		}
		sortable.sort(function (a, b) {
			if (a[1] == b[1]) {
				return 0;
			}
			return a[1] < b[1] ? -1 : 1;
		});
		for (var i in sortable) {
			var key = +sortable[i][0];
			output.push($('<li />', {
				html: items[key].label + (items[key].units !== null ? ' (' + items[key].units + ')' : ''),
				class: 'btn ' + ((key == currentLayerID) ? 'btn-primary' : 'btn-default'),
				'data-id': key
			}));
		}
		return output;
	}
	Drupal.theme.prototype.tableMap = function (items) {
		item = items[currentLayerID];
		if (Drupal.settings.admin_menu) {
			$('.links').html($('<a />', {
				href: 'node/' + currentLayerID + '/edit',
				html: '<i class="glyphicon glyphicon-edit" />&nbsp;' + Drupal.t('Edit'),
				class: 'btn btn-warning'
			}));
		}
		var title = $('<h3 />', {
			html: item.label
		});
		var body = $('<div />', {
			html: item.body,
			class: 'body-description'
		});
		var output = [title, body];
		// console.log(item.values);
		for (var key in item.values) {
			if (item.values[key].value === null) continue;
			var value = item.int === true ? parseInt(item.values[key].value) : item.values[key].value
			output.push(
				$('<div />', {
					class: 'row',
					html: [
						$('<div />', {
							class: 'col-xs-5 region',
							html: item.values[key].label
						}),
						$('<div />', {
							class: 'col-xs-5',
							html: $('<div />', {
								class: 'value-line',
								html: $('<div />', {
									style: 'width:0%; background-color: ' + getColorForCnt(item.values[key].value) + ' !important',
									class: 'value',
									'data-width': item.values[key].value / maxValue * 100
								})
							})
						}),
						$('<div />', {
							class: 'col-xs-2 region-value',
							html: value
						})
					]
				})
			)
		}
		setTimeout(expandWidth, 1000);
		return output;
	}
	function expandWidth() {
		$('.value-line div').each(function () {
			$(this).css('width', $(this).data('width') + '%');
		})
	}
	Drupal.theme.prototype.mapLegend = function (items) {
		items = items[currentLayerID].legend;
		var int = Drupal.settings.temperature[currentLayerID].int;;// items[currentLayerID].int;
		var output = [];
		for (var key in items) {
			var from = int ? parseInt(items[key].from) : items[key].from;
			var to = int ? parseInt(items[key].to) : items[key].to;

			var row = $('<div />', {
				class: 'legend-item',
				html: [
					$('<div />', {
						class: 'legend-round',
						style: 'background:' + items[key].color + ' !important'
					}),
					$('<div />', {
						class: 'legend-label',
						html: [from, to].join(' - ')
					})
				]
			});
			output.push(row);
		}
		return output;
	}
})(jQuery);