<?php
namespace App\Controller;

use App\Service\SiteService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class SiteController{
    private SiteService $siteService;

    public function __construct(SiteService $siteService)
    {
        $this->siteService = $siteService;
    }

    /**
     * @Route("/user/add", name="user.add", methods={"POST"})
     */
    public function addUser(): JsonResponse
    {
        $response = $this->siteService->addUser();
        return JsonResponse::fromJsonString($response);
    }

    /**
     * @Route("/user/update", name="user.update", methods={"POST"})
     */
    public function updateUser(): JsonResponse
    {
        $response = $this->siteService->updateUser();
        return JsonResponse::fromJsonString($response);
    }

    /**
     * @Route("/user/recover_password", name="user.recover_password", methods={"POST"})
     */
    public function recoverUserPassword(): JsonResponse
    {
        $response = $this->siteService->recoverUserPassword();
        return JsonResponse::fromJsonString($response);
    }
}