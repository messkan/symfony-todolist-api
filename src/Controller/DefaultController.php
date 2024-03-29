<?php


namespace App\Controller;

use App\Document\Task;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
/**
 * Class DefaultController
 * @package App\Controller
 * @Route("/api", name="default" )
 */
class DefaultController extends  AbstractController
{
    /**
     * @return JsonResponse
     * @Route("/" , name="index" , methods={"GET"})
     */
    public function index(Request $request){

        return  new JsonResponse(array('test' => "works"));
    }

}