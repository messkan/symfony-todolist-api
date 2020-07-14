<?php


namespace App\Controller;

use App\Document\Task;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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

    /**
     * @return JsonResponse
     * @Route("/addingTask", name="addingTask" , methods={"GET"})
     */
    public function addingTask(DocumentManager $dm){
        try{
            /**
             * @var Task task
             */
            $task = new Task();

            $task->setContent("the first document persisted");

            $dm->persist($task);
            $dm->flush();

            return new JsonResponse(array("done" => "true"));
        }catch (\Exception $err) {
            return new JsonResponse($err);
        }

    }
}