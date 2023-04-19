import { Controller } from '@hotwired/stimulus';
import Swal from 'sweetalert2/src/sweetalert2.js';
import { gsUseFadeTransition } from '@green-symfony/generic-parts-stimulus/public/functions';

/*
Usage:
	
*/

/* stimulusFetch: 'lazy' */
export default class extends Controller {

	static values = {
		'delay':					{ type: Number, default: 3000 },
	};

	connect() {
		
		gsUseFadeTransition(this, this.element);
		
		setTimeout(() => this.leave().then(() => { this.element.remove(); }), this.delayValue);
		/*
		Swal.fire({
			toast: true,
			position: 'top-end',
			showConfirmButton: false,
			timer: 3000,
			timerProgressBar: true,
			didOpen: (toast) => {
				toast.addEventListener('mouseenter', Swal.stopTimer)
				toast.addEventListener('mouseleave', Swal.resumeTimer)
			}
		});
		*/
	}
}
