<?php

namespace App\Controller;

use App\Service\OneCReader;
use App\Utils\Utils;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/umc-api")
 */
class OneCController extends AbstractController
{
    private OneCReader $reader;

    public function __construct(OneCReader $reader)
    {
        $this->reader = $reader;
    }

    /**
     * @Route("/clinics/list", name="clinics.list", methods={"POST"})
     */
    public function getClinicsList(): JsonResponse
    {
        $response = $this->reader->getClinicsList();
        return JsonResponse::fromJsonString($response);
    }

    /**
     * @Route("/employees/list", name="employees.list", methods={"POST"})
     */
    public function getEmployeesList(Request $request): JsonResponse
    {
        $response = $this->reader->getEmployeesList(Utils::getRequestParams($request));
        return JsonResponse::fromJsonString($response);
    }

    /**
     * @Route("/nomenclature/list", name="nomenclature.list", methods={"POST"})
     */
    public function getNomenclatureList(Request $request): JsonResponse
    {
        $response = $this->reader->getNomenclatureList(Utils::getRequestParams($request));
        return JsonResponse::fromJsonString($response);
    }

    /**
     * @Route("/schedule", name="schedule.get", methods={"POST"})
     */
    public function getSchedule(): JsonResponse
    {
        $response = $this->reader->getSchedule();
        return JsonResponse::fromJsonString($response);
    }

    /**
     * @Route("/clients/list", name="clients.list", methods={"POST"})
     */
    public function getClientsList(Request $request): JsonResponse
    {
        $response = $this->reader->getClientsList(Utils::getRequestParams($request));
        return JsonResponse::fromJsonString($response);
    }
}
