<?php

namespace GS\GenericParts\Controller;

use function Symfony\Component\String\u;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{
	Response,
	JsonResponse
};
use Symfony\Component\Routing\Annotation\Route;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Request;

class ApiUtcDtController extends AbstractController
{
	public function __construct(
		private $tzSessionName,
	) {}
	
    #[Route('/api/utc/dt', name: 'gs_generic_parts.api.utc_dt')]
    public function index(
		Request $request,
	): JsonResponse {
		$carbon = Carbon::now();
		$carbon = $carbon->forUser(
			locale:	$request->getLocale(),
			tz:		$request->getSession()->get($this->tzSessionName),
		);
		
		$dt		= (string) u($carbon->isoFormat('dddd, MMMM D, YYYY h:mm:ss A') . ' ['.$carbon->tz.']')->title(true);
		
		return $this->json(
			$dt,
		);
    }
}
