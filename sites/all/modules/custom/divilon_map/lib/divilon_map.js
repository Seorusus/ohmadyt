(function ($) {
    Drupal.behaviors.divilonMap = {
        attach: function (context, settings) {
            var inputs_selector = '.map-sidebar input[type="checkbox"]';
            var terms_id = _.flatten(_.map(settings.markers, function(el) {
                return el.types;
            }));
            $('body').once(function () {
                var DGMap = new GMaps({
                    div: '#divilon_map',
                    lat: 48.748945343432936,
                    lng: 31.640625,
                    zoom: 6
                });
                function addMarkers() {
                    DGMap.removeMarkers();
                    for (var key in settings.markers) {
                        var marker = settings.markers[key];
                        if (_.intersection(terms_id, marker.types).length > 0 || true) {
                            DGMap.addMarker({
                                lat: marker.coord.lat,
                                lng: marker.coord.lon,
                                title: marker.title,
                                details: {
                                    id: key,
                                    terms: [1, 2, 3]
                                },
                                icon: {
                                    url: marker.icon
                                },
                                click: function (e) {
                                    drawOverlays(settings.markers[e.details.id]);
                                }
                            });   
                        }
                    }
                    //DGMap.fitZoom();
                }
                $('body').on('click', 'span.close', function(e){
                    e.stopPropagation();
                    e.preventDefault();
                    DGMap.removeOverlays();
                })
                function drawOverlays(marker) {
                    DGMap.removeOverlays();
                    DGMap.drawOverlay({
                        lat: marker.coord.lat,
                        lng: marker.coord.lon,
                        content: '<div class="overlay bb"><span class="close">X</span>' + '<h3>' + marker.title + '</h3>' + marker.body + '</div>',
                        verticalAlign: 'top',
                        layer: 'floatPane',
                        verticalOffset: -20
                    });
                    DGMap.setCenter({
                        lat: +marker.coord.lat,
                        lng: +marker.coord.lon
                    })
                }
                addMarkers();
                $(inputs_selector).on('change', filterObjects);
                $('.map-sidebar .title [type="checkbox"]').on('change', switchFilters);

                function switchFilters(e) {
                    var state = ( $(e.currentTarget).prop('checked') );
                    $(e.currentTarget).parent().parent().find('.filter-item input').prop('checked', state);
                }

                function filterObjects() {
                    terms_id = _.map(_.filter($(inputs_selector + ':checked'), function (el) {
                        return $(el).val().indexOf('voc-') === -1
                    }), function (inp) {
                        return $(inp).val();
                    });
                    addMarkers();
                }
                $('body').on('click', '.form-type-title', function(e){
                    var li = $(this).parent().find('li.form-type-checkbox').toggleClass('collapsed');
                });
                $('body').on('click', '.toggle-selection', function(e){
                    var state = $(this).data('state');
                    $(this)
                        .data('state', !state)
                        .html(state ? Drupal.t('Deselect all') : Drupal.t('Select all'));
                    $('.form-type-checkbox input[type="checkbox"]').prop('checked', state);
                    filterObjects();
                });
            });
            // $('body').on('click', '.form-item-addvoc a[href*="delete"]', function(e){if(!confirm(Drupal.t('Delete?'))) {e.preventDefault()} 
        }
    }

    Drupal.theme.prototype.popup = function (item) {
        var html = 'popup window';
        return html;
    }
})(jQuery);