<?php

namespace App\Controller;

use App\Service\OneCReader;
use App\Service\TemplateService;
use App\Utils\Utils;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/umc-api")
 */
class TemplateController extends AbstractController{

    private TemplateService $paramsGenerator;

    public function __construct(TemplateService $paramsGenerator)
    {
        $this->paramsGenerator = $paramsGenerator;
    }

    /**
     * @Route("/", name="umc-api.root", methods={"GET"})
     */
    public function showApiRootPage(): Response
    {
        return $this->render('index.html.twig', [
            //'user_first_name' => $userFirstName,
            //'notifications' => $userNotifications,
        ]);
    }

    /**
     * @Route("/widget", name="umc-api.widget", methods={"GET"})
     */
    public function showApiExampleWidget(): Response
    {
        $widgetParams = $this->paramsGenerator->generateWidgetParams();
        return $this->render('widget/index.html.twig', $widgetParams);
    }
}