import { Controller } from '@hotwired/stimulus';
import { useIntersection, useThrottle, useDebounce } from 'stimulus-use';
import axios from 'axios';

/* stimulusFetch: 'lazy' */
export default class extends Controller {
	static values = {
		intervalMs:		{type: Number, default: 1000},
		attrString:		{type: String, default: ''},
	};
	
	/*
		first call in interval
	*/
    static throttles = [
		'triggerView',
	];
	
	timer			= null;
	
	connect() {
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
		this.timer			= setInterval(this.triggerView.bind(this), 0);		
	}
	
	disappear(entry) {
		this.clearInterval();
	}
	
	disconnect() {
		this.clearInterval();
	}
	
	async triggerView() {
		const dt = await axios.get('/gs/generic-parts/api/utc/dt');
		//this.element.innerHTML = '<span style="font-family: albertus;" class="fs-4">'+dt.data+'</span>';
		this.element.innerHTML = '<span '+this.attrStringValue+'>'+dt.data+'</span>';
	}
	
	clearInterval() {
		if (this.timer === null) return;

		clearInterval(this.timer);
		this.timer = null;
	}
}
