import { Controller } from '@hotwired/stimulus';
import { useIntersection, useThrottle, useDebounce } from 'stimulus-use';
import axios from 'axios';

/* stimulusFetch: 'lazy' */
export default class extends Controller {
	static values = {
		intervalMs:		{type: Number, default: 1000},
	};
	
    static throttles = [
		'triggerView',
	];
	
	callback		= null;
	timer			= null;
	
	connect() {
		debugger;
		useThrottle(this, {
			wait:			this.intervalMsValue,
		});
		useIntersection(this, {
			element:		this.element,
			threshold:		0.0,
			rootMargin:		'20px',
		});
	}

	appear(entry) {
		this.callback		= this.triggerView.bind(this);
		this.timer			= setInterval(this.callback, 0);		
	}
	
	disappear(entry) {
		this.clearInterval();
	}
	
	disconnect() {
		this.clearInterval();
	}
	
	async triggerView() {
		const dt = await axios.get('/gs/generic-parts/api/utc/dt');
		this.element.innerHTML = '<span class="display-6">'+dt.data+'</span>';
	}
	
	clearInterval() {
		if (this.timer === null) return;

		clearInterval(this.timer);
		this.timer = null;
	}
}
