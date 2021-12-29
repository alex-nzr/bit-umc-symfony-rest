<?php
namespace App\Service;

class SiteService{

    public function __construct()
    {
    }

    public function addUser():string
    {
        //some processing here
        return json_encode(['success' => true]);
    }

    public function updateUser():string
    {
        //some processing here
        return json_encode(['success' => true]);
    }

    public function recoverUserPassword():string
    {
        //some processing here
        return json_encode(['success' => true]);
    }
}