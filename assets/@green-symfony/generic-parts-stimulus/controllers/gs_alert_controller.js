import { Controller } from '@hotwired/stimulus';
import Swal from 'sweetalert2/src/sweetalert2.js';
import { gsUseFadeTransition } from '@green-symfony/generic-parts/public/functions';

/*
Usage:
	
*/

/* stimulusFetch: 'lazy' */
export default class extends Controller {

	connect() {
		
		gsUseFadeTransition(this, this.element);
		
		this.leave().then(() => { this.element.remove(); });
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
