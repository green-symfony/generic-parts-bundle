import { Controller } from '@hotwired/stimulus';
import { useHotkeys, useDebounce } from 'stimulus-use';
import parseMoney from 'parse-money';

/*
	Usage:
		symfony form:
			NumberType::class
			'grouping'	=> true,

		<input
			type="number" {# NUMBER TYPE! #}
			data-controller='<controller-name>'
			data-<controller-name>-locale-value=app.request.locale
			
			data-<controller-name>-change-speed-value=<>
		>
*/
/* stimulusFetch: 'lazy' */
export default class extends Controller {

	static values = {
		'locale':					String,
		'changeSpeed':				{ type: Number, default: 700 },
	};

	static debounces = [
		'normalize',
	];

	connect() {
		useDebounce(this, {
			wait: this.changeSpeedValue,
		});
		this.normalizeCallback = this.normalize.bind(this);
		this.element.addEventListener('input', this.normalizeCallback);
	}
	
	disconnect() {
		this.element.removeEventListener('input', this.normalizeCallback);
	}

	normalize(event) {
		const $el = event.target;
		const money = parseMoney($el.value + ' ' + this.localeValue);
		$el.value = money.amount.toLocaleString(this.localeValue);
	}
}
