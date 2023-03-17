/**
 *  add listener to load map
 */
document.addEventListener('DOMContentLoaded', () => {
	const links = document.querySelectorAll('.js-gme-show');
	const preview = document.querySelector('.js-gme-preview');
	const mapContainer = document.querySelector('.js-gme-container');
	const useCookies = preview.dataset.cookie === '1';

	if (useCookies && getCookie('tx_gomapsext_show_map')) {
		showMap();
	} else {
		mapContainer.style.display = 'none';

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
			mapContainer.style.display = 'block';
		}

		preview.remove();
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