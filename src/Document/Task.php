<?php


namespace App\Document;

use DateTime;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
/**
 * @MongoDB\Document
 * @MongoDB\HasLifecycleCallbacks
 */
class Task implements  \JsonSerializable
{
    /**
     * @MongoDB\Id
     */
    protected String $id;

    /**
     * @MongoDB\Field(type="string")
     */
    protected String $content;


    /**
     * @MongoDB\Field(type="date")
     */
    protected DateTime $creationDate;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getContent() : String
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content) : void
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getCreationDate() : \DateTime
    {
        return $this->creationDate;
    }

    /**
     * @param $creationDate
     * @MongoDB\PrePersist
     */
    public function setCreationDate(): void
    {
        $this->creationDate = new DateTime('now');
    }


    public function jsonSerialize()
    {
      return [
          "id" => $this->getId(),
          "content" => $this->getContent(),
          ];
    }


}