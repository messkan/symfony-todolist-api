<?php


namespace App\Controller;


use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Document\Task;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TaskController
 * @package App\Controller
 * @Route("/task" , name="taskController")
 */
class TaskController extends AbstractController
{
   /**
    * @return JsonResponse
    * @Route("/new", name="newTask" , methods={"POST"})
    */
   public function newTask(Request $request, DocumentManager $dm ){

       try {

         $data = json_decode($request->getContent());
           /**
            * @var Task $task
            */
          $task = new Task();


           $task->setContent($data->content);
           $task->setComplete(0);
           $dm->persist($task);
           $dm->flush();

           return new JsonResponse($task, Response::HTTP_OK);

       }catch(\Throwable $exception){
           return new JsonResponse($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
       }

   }

    /**
     * @return JsonResponse
     * @Route("/{id}", name="editTask" , methods={"PUT"})
     */
    public function editTask(String $id, DocumentManager $dm){
          try{
              $taskRepo = $dm->getRepository(Task::class);
              /**
               * @var Task $task
               */
              $task = $taskRepo->find($id);
              if(!$task)
                  throw new \Exception('task not found');
              $task->setComplete(!$task->isComplete());
              $dm->persist($task);
              $dm->flush();
              return new JsonResponse($task, Response::HTTP_OK);
          }catch (\Throwable $th){
              return new JsonResponse($th->getMessage() , Response::HTTP_INTERNAL_SERVER_ERROR);
          }
    }

    /**
     * @return JsonResponse
     * @Route("/delete/{id}", name="" , methods={"DELETE"})
     */
    public function deleteTask(String $id, DocumentManager $dm ){
          try{
              $taskRepo = $dm->getRepository(Task::class);
              /**
               * @var Task $task
               */
              $task = $taskRepo->find($id);
              if(!$task)
                  throw new \Exception('task not found');
              $dm->remove($task);
              $dm->flush();
              return new JsonResponse(array('deleted' => 'deleted'), Response::HTTP_OK);
          }catch(\Throwable $th){
              return new JsonResponse($th->getMessage() , Response::HTTP_INTERNAL_SERVER_ERROR);
          }
    }

    /**
     * @return JsonResponse
     * @Route("/" , name="tasks" , methods={"GET"})
     */
    public function getTasks(DocumentManager $dm) {
        try{
            $taskRepo = $dm->getRepository(Task::class);
            /**
             * @var Task $task
             */
            $tasks = $taskRepo->findAll();
            return new JsonResponse($tasks, Response::HTTP_OK);
        }catch(\Throwable $th){
            return new JsonResponse($th->getMessage() , Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @return JsonResponse
     * @Route("/clear" , name="clearCompleted" , methods={"DELETE"})
     */
    public function deleteCompleted(DocumentManager $dm){
        try {
            $tasksCollection = $dm->getDocumentCollection(Task::class);
            $tasksCollection->deleteMany(array('complete' => true));
            return new JsonResponse(array('deleted'), Response::HTTP_OK);

        }catch (\Throwable $th)
        {
            return new JsonResponse($th->getMessage() , Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}