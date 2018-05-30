/**
 *  add listener to load map
 */
jQuery(document).ready(function ($) {
    var $links = $('.js-gme-show'),
        $preview = $('.js-gme-preview'),
        $mapContainer = $('.js-gme-container');

    $mapContainer.hide();

	$links.click(function (e) {
        e.preventDefault();
	    if(typeof google === "undefined") {
		    $('body').append($('<script>').attr('src', $links.data('library') + '&callback=GoMapsExtLoaded'));
		    $mapContainer.show();
	    }
		$preview.remove();
    });
});

/**
 * global google maps api callback
 */
function GoMapsExtLoaded() {
	jQuery('.js-map').each(function(key, el) {
		jQuery(el).data('gomapsextcontroller').initialize();
	});
}