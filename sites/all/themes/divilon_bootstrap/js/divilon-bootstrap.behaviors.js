(function ($) {
	Drupal.behaviors.divilonVisionBehavior = {
		attach: function (context, settings) {
			$('body').once(function () {
				$('body').addClass('js-processed');

				$('body').on('click', '.block-block .block-content .close', function(event) {
					$(event.currentTarget).closest('.block-block').hide();
				});

				$('body').on('click', '.navbar-toggle, .closemenu', function(event) {
					$('body').toggleClass('openmenu');
				});

				$('body').on('click', '.print-btn', function(event) {
					event.preventDefault();
					window.print();
				});

				$('body').on('click', '#navbar .search a', function(event) {
					event.preventDefault();
					$('#search-block').show();
					$('#search-block .form-text').focus();
				});

				if ($('body').hasClass('front')) {
					function showTime() {
						var date = new Date();
						const time = [
							date.getHours(),
							date.getMinutes()
						].map((t) => (String(t).padStart(2, '0'))).join(':');

						$('.timeContainer').html(time);
						setTimeout(showTime, 1000);
					}
					showTime();
				}

				var exposed = $('#views-exposed-form-acts-page .views-exposed-form');
				if(exposed.length) {
					$('.views-exposed-widgets .views-submit-button', exposed).before('<div class="toggle-exposed">' + Drupal.t('Advanced search') + '</div>');
					$('#edit-type-wrapper, #edit-author-wrapper, #edit-number-wrapper, .views-widget-filter-field_date_iso_value, .views-widget-filter-field_date_iso_value_1, #edit-subject-wrapper').wrapAll('<div class="advanced-search"></div>');
					var asform = $('.advanced-search');
					asform.hide();
					$('body').on('click', '.views-exposed-form .toggle-exposed', function(event) {
						$(this).toggleClass('expand');
						asform.toggle();
					});
				}

				var viewExpFilrter = $('#views-exposed-form-home-page');
				if (!!viewExpFilrter.length) {
					$('body').on('click', '#views-exposed-form-home-page .views-exposed-widget label', function () {
						if ($(this).attr("for") !== "edit-type") $(this).parent().toggleClass('expanded');
					});
				}

				var mainSlider = $('.view-display-id-block_1 .view-content');
				mainSlider && mainSlider.length && $('.view-display-id-block_1 .view-content').slick({
					slidesToShow: 3,
					variableWidth: true
				  });

			});
		}
	}
})(jQuery);