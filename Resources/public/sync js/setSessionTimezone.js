const tz = Intl.DateTimeFormat().resolvedOptions().timeZone;

function gsGenericPartsUpdateDtUpdateableFrames() {
	const $frames = document.querySelectorAll('turbo-frame[data-dt-updateable]');
	
	$frames.forEach( $el => {
		$el.setAttribute('src', $el.dataset.dtUpdateable);
	});
}

fetch('/gs/generic-parts/api/set/timezone', {
	method: 'POST',
	headers: {
		'Content-Type': 'application/json;charset=utf-8'
	},
	body: JSON.stringify({tz: tz}),
})
	.then( async (result) => {
		const response = await result.json();
		if (result.status != 200) {
			console.error(`status: ${result.status}, error: ${response.error}`);
			return;
		}
		gsGenericPartsUpdateDtUpdateableFrames();
	})
	.catch(error => {
		console.error(error);
	})
;