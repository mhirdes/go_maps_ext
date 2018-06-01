/**
 *  add listener to load map
 */
jQuery(document).ready(function ($) {
    var $links = $('.js-gme-show'),
        $preview = $('.js-gme-preview'),
        $mapContainer = $('.js-gme-container'),
        useCookies = $preview.data('cookie'),
        hideMap = true;

	if(useCookies) {
		if($.cookie('tx_gomapsext_show_map')) {
			showMap();
			hideMap = false;
		}
	}

	if(hideMap) {
		$mapContainer.hide();

		$links.click(function (e) {
			e.preventDefault();
			showMap();
			if(useCookies) {
				$.cookie('tx_gomapsext_show_map', 1, {path:'/'});
			}
		});
	}

	function showMap() {
		if(typeof google === "undefined") {
			$('body').append($('<script>').attr('src', $links.data('library') + '&callback=GoMapsExtLoaded'));
			$mapContainer.show();
		}
		$preview.remove();
	}

});

/**
 * global google maps api callback
 */
function GoMapsExtLoaded() {
	jQuery('.js-map').each(function(key, el) {
		jQuery(el).data('gomapsextcontroller').initialize();
	});
}