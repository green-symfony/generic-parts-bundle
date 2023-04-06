<?php

namespace GS\GenericParts\Controller;

use GS\GenericParts\Exception\{
	GSDateTimeBadLocaleOrTimezoneException
};
use function Symfony\Component\String\u;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{
	Response,
	JsonResponse
};
use Symfony\Component\Routing\Annotation\Route;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Request;

class ApiUtcDtController extends GSAbstractController
{
	public function __construct(
		$tzSessionName,
	) {
		parent::__construct(
			$tzSessionName,
		);
	}
	
    #[Route('/api/utc/dt')]
    public function index(
		Request $request,
		$devLogger,
	) {
		$carbon = Carbon::now();
		
		try {
			$carbon = $carbon->forUser(
				locale:	$locale		= $request->getLocale(),
				tz:		$tz			= $request->getSession()->get($this->tzSessionName),
			);
		} catch (\Exception $e) {
			throw new GSDateTimeBadLocaleOrTimezoneException(params: ['locale' => $locale, 'tz' => $tz]);
		}
		
		$tz		= $carbon->tz;
		
		$dt		= (string) u($carbon->isoFormat('dddd, MMMM D, YYYY h:mm:ss A') . ' ['.$tz.']')->title(true);
		
		return $this->json(
			$dt,
			context:	[
				'json_encode_options'		=> \JSON_UNESCAPED_UNICODE | \JSON_UNESCAPED_SLASHES,
			],
		);
    }
}
