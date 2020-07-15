<?php


namespace App\Service;




use App\Document\Task;
use App\Manager\TaskManager;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
class TaskService
{
    /**
     * @var  TaskManager $taskManager
     */
   private $taskManager;

    /**
     * @var Serializer $serializer
     */
    private $serializer;

    /**
     * TaskService constructor.
     * @param TaskManager $taskManager
     */
    public function __construct(TaskManager $taskManager)
    {
        $this->taskManager = $taskManager;
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $this->serializer = new Serializer($normalizers, $encoders);
    }

    /**
     * @param $data
     * @return string
     * @throws \Doctrine\ODM\MongoDB\MongoDBException
     */
    public function create($data){
       $task = $this->serializer->deserialize($data , Task::class , 'json');

       $created = $this->taskManager->create($task);

        if (isset($created['error']) === true) {
            return $this->serializer->serialize(["error" => true, 'message' => $created['message']] , 'json');
        } else {
            return $this->serializer->serialize(["error" => false, 'created' => $created] , 'json');
        }
    }

    /**
     * @param $id
     */
    public function update($id){
     return   $this->taskManager->updateCompleteField($id);
    }

    /**
     * @return object[]
     */
    public function findAll(){
         $tasks = $this->taskManager->findAll();
        return $this->serializer->serialize($tasks, 'json' , [AbstractNormalizer::IGNORED_ATTRIBUTES => ['creationDate']] );
    }

    /**
     * @param $id
     * @return array|bool
     */
    public function remove($id){
        $deleted = $this->taskManager->remove($id);
        if (isset($deleted['error']) === true) {
            return ["error" => true, 'message' => $deleted['message']];
        } else {
            return ["error" => false, 'deleted' => true];
        }
    }

    /**
     * @return mixed
     */
    public function removeCompleted(){
       $deleted = $this->taskManager->removeCompleted();
        if (isset($deleted['error']) === true) {
            return ["error" => true, 'message' => $deleted['message']];
        } else {
            return ["error" => false, 'deleted' => true];
        }
    }

    /**
     * @param $id
     * @return array|bool[]
     *
     */
    public function updateCompleteField($id){
        $updated = $this->taskManager->updateCompleteField($id);
        if (isset($deleted['error']) === true) {
            return ["error" => true, 'message' => $updated['message']];
        } else {
            return ["error" => false, 'updated' => true];
        }

    }


}