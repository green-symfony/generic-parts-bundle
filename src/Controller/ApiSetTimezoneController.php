<?php

namespace GS\GenericParts\Controller;

use GS\GenericParts\Service\{
	DataTimeValidator
};
use GS\GenericParts\Exception\{
	GSPOSTRequestDoesnotContainParameter,
	GSCarbonInvalidTimezone,
	GSSerializerParseException
};
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{
    JsonResponse,
    Response,
    Request
};
use Symfony\Component\Routing\Annotation\Route;
use Carbon\Carbon;
use Symfony\Component\Serializer\{
	SerializerInterface,
	Serializer
};

class ApiSetTimezoneController extends GSAbstractController
{
	public function __construct(
		$tzSessionName,
	) {
		parent::__construct(
			$tzSessionName,
		);
	}
	
	#[Route('/api/set/timezone')]
    public function index(
        Request $request,
        SerializerInterface $serializer,
    ): JsonResponse {
		try {
			$data = $serializer->decode($request->getContent(), 'json');
		} catch (\Exception $e) {
			throw new GSSerializerParseException;
		}

		if (!isset($data['tz'])) {
			throw new GSPOSTRequestDoesnotContainParameter(
				params: ['tz'],
			);
		}
		$tz = $data['tz'];

		if (!DataTimeValidator::isCarbonTimezone($tz)) {
			throw new GSCarbonInvalidTimezone(
				params: ['tz' => $tz],
			);
		}

		$request->getSession()->set($this->tzSessionName, $tz);
		return new JsonResponse();
	}
}
