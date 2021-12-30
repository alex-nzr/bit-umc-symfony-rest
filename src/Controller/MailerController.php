<?php


namespace App\Controller;

use App\Service\MailerService;
use App\Utils\Utils;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/umc-api")
 */
class MailerController extends AbstractController
{
    public function __construct(){}

    /**
     * @Route("/email/send"), name="email.send", methods={"POST"})
     */
    public function sendEmail(MailerService $mailer, Request $request): Response
    {
        $params = Utils::getRequestParams($request);
        $res = $mailer->sendEmail($params);
        return $this->json($res);
    }
}