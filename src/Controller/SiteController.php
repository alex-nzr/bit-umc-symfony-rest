<?php
namespace App\Controller;

use App\Service\SiteService;
use Symfony\Component\Routing\Annotation\Route;

class SiteController{
    private SiteService $siteService;

    public function __construct(SiteService $siteService)
    {
        $this->siteService = $siteService;
    }
    //"user.add", //or "user.update", or "user.recoverPassword"
}