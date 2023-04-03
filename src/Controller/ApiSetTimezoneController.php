<?php

namespace GS\GenericParts\Controller;

use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{
    JsonResponse,
    Response,
    Request
};
use Symfony\Component\Routing\Annotation\Route;
use Carbon\Carbon;

class ApiSetTimezoneController extends AbstractController
{
	public function __construct(
        private $tzSessionName,
	) {}
	
	#[Route('/api/set/timezone', name: 'gs_generic_parts.api.set_timezone')]
    public function index(
        Request $request,
        SerializerInterface $serializer,
    ): JsonResponse {

        $data = $serializer->decode($request->getContent(), 'json');

        if ($tz = $data['tz']) {
            $request->getSession()->set($this->tzSessionName, $tz);
            return new JsonResponse();
        }

        return new JsonResponse([
            'error' => 'POST request doesn\'t contain "tz" paramenter',
        ], status: Response::HTTP_PRECONDITION_FAILED);
    }
}
