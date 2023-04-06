import { Controller } from '@hotwired/stimulus';

/* stimulusFetch: 'lazy' */
export default class extends Controller {
    connect() {
		console.log('green-symfony/generic-parts is working');
	}
}
