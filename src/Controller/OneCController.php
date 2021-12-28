<?php

namespace App\Controller;

use App\Service\OneCReader;
use App\Service\OneCWriter;
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
    private OneCWriter $writer;

    public function __construct(OneCReader $reader, OneCWriter $writer)
    {
        $this->reader = $reader;
        $this->writer = $writer;
    }

    /**
     * @Route("/clinic/list", name="clinic.list", methods={"POST"})
     */
    public function getClinicsList(): JsonResponse
    {
        $response = $this->reader->getClinicsList();
        return JsonResponse::fromJsonString($response);
    }

    /**
     * @Route("/employee/list", name="employee.list", methods={"POST"})
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
     * @Route("/schedule/get", name="schedule.get", methods={"POST"})
     */
    public function getSchedule(): JsonResponse
    {
        $response = $this->reader->getSchedule();
        return JsonResponse::fromJsonString($response);
    }

    /**
     * @Route("/order/list", name="order.list", methods={"POST"})
     */
    public function getOrdersList(Request $request): JsonResponse
    {
        $response = $this->reader->getOrdersList(Utils::getRequestParams($request));
        return JsonResponse::fromJsonString($response);
    }

    /**
     * @Route("/order/add", name="order.add", methods={"POST"})
     */
    public function addOrder(Request $request): JsonResponse
    {
        $response = $this->writer->addOrder(Utils::getRequestParams($request));
        return JsonResponse::fromJsonString($response);
    }

    /**
     * @Route("/order/delete", name="order.delete", methods={"POST"})
     */
    public function deleteOrder(Request $request): JsonResponse
    {
        $response = $this->writer->deleteOrder(Utils::getRequestParams($request));
        return JsonResponse::fromJsonString($response);
    }

    /**
     * @Route("/client/list", name="client.list", methods={"POST"})
     */
    public function getClientsList(Request $request): JsonResponse
    {
        $response = $this->reader->getClientsList(Utils::getRequestParams($request));
        return JsonResponse::fromJsonString($response);
    }

    /**
     * @Route("/client/update", name="client.update", methods={"POST"})
     */
    public function updateClient(Request $request): JsonResponse
    {
        $response = $this->writer->updateClient(Utils::getRequestParams($request));
        return JsonResponse::fromJsonString($response);
    }
}
