<?php

namespace App\Controller;

use App\Service\OneCReader;
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

    public function __construct(){}

    /**
     * @Route("/", name="umc-api.root", methods={"GET"})
     */
    public function showApiRootPage(): Response
    {
        return $this->render('index.html.twig', [
            // this array defines the variables passed to the template,
            // where the key is the variable name and the value is the variable value
            // (Twig recommends using snake_case variable names: 'foo_bar' instead of 'fooBar')
            //'user_first_name' => $userFirstName,
            //'notifications' => $userNotifications,
        ]);
    }

    /**
     * @Route("/widget", name="umc-api.widget", methods={"GET"})
     */
    public function showApiExampleWidget(): Response
    {
        return $this->render('widget/index.html.twig');
    }
}