<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class DefaultController
 * @package App\Controller
 */
class DefaultController extends  AbstractController
{
    /**
     * @return JsonResponse
     */
    public function index(){
        return $this->response(array('test' => "works"));
    }

}