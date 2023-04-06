import { useTransition } from 'stimulus-use';

export function useFadeTransition(
	controller,
	element, 
	showInTheBeginning = true,
) {
	return useBaseTransition(controller, element, 'fade', showInTheBeginning);
}

export function useSwapTransition(
	controller,
	element, 
	showInTheBeginning = true,
) {
	return useBaseTransition(controller, element, 'swap', showInTheBeginning);
}

// >>> helpers >>>

export function useBaseTransition(controller, element, cssPrefix, showInTheBeginning) {
	const [ enter, leave, toggleTransition ] = useTransition(controller, {
		element: element,
		enterActive: `${cssPrefix}-enter-active`,
		enterFrom: `${cssPrefix}-enter-from`,
		enterTo: `${cssPrefix}-enter-to`,
		leaveActive: `${cssPrefix}-leave-active`,
		leaveFrom: `${cssPrefix}-leave-from`,
		leaveTo: `${cssPrefix}-leave-to`,
		hiddenClass: 'd-none',
		transitioned: showInTheBeginning,
	});
	return { enter, leave, toggleTransition };
}