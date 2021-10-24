<?php

class Post
{

    private $id;
    private $category;
    private $title;
    private $body;
    private $author;
    private $create_at;

    public function __construct($id = null, $category = null, $title = null, $body = null, $author = null, $create_at = null)
    {
        $this->id = $id;
        $this->category = $category;
        $this->title = $title;
        $this->body = $body;
        $this->author = $author;
        $this->create_at = $create_at;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function setCategory($category)
    {
        $this->category = $category;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function setBody($body)
    {
        $this->body = $body;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function setAuthor($author)
    {
        $this->author = $author;
    }

    public function getCreateAt()
    {
        return $this->create_at;
    }

    public function setCreateAt($create_at)
    {
        $this->create_at = $create_at;
    }

    public function toJson()
    {
        return json_encode(array(
            'id' => $this->getId(),
            'category' => $this->getCategory(),
            'title' => $this->getTitle(),
            'body' => $this->getBody(),
            'author' => $this->getAuthor(),
            'create_at' => $this->getCreateAt()
        ));
    }

    public function toAssoc()
    {
        return array(
            'id' => $this->getId(),
            'category' => $this->getCategory(),
            'title' => $this->getTitle(),
            'body' => $this->getBody(),
            'author' => $this->getAuthor(),
            'create_at' => $this->getCreateAt()
        );
    }

}