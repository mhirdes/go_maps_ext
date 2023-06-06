/**
 *  add listener to load map
 */
document.addEventListener('DOMContentLoaded', () => {
	const links = document.querySelectorAll('.js-gme-show');
	const previews = document.querySelectorAll('.js-gme-preview');
	const mapContainers = document.querySelectorAll('.js-gme-container');
	const useCookies = previews[0] && previews[0].dataset.cookie === '1';

	if (useCookies && getCookie('tx_gomapsext_show_map')) {
		showMap();
	} else {
		mapContainers.forEach(mapContainer => {
			mapContainer.style.display = 'none';
		});

		links.forEach(link => {
			link.addEventListener('click', e => {
				e.preventDefault();
				showMap();
				if (useCookies) {
					setCookie('tx_gomapsext_show_map', 1, '/');
				}
			});
		});
	}

	function showMap() {
		if (typeof google === 'undefined' || typeof google.maps === 'undefined') {
			const script = document.createElement('script');
			script.src = links[0].dataset.library;
			document.body.appendChild(script);
			mapContainers.forEach(mapContainer => {
				mapContainer.style.display = 'block';
			});
		}

		previews.forEach(preview => {
			preview.remove();
		});
	}

	function getCookie(name) {
		const value = `; ${document.cookie}`;
		const parts = value.split(`; ${name}=`);
		if (parts.length === 2) {
			return parts.pop().split(';').shift();
		}
	}

	function setCookie(name, value, path) {
		document.cookie = `${name}=${value}; path=${path}`;
	}
});
