<?php

require_once __DIR__ . '/../models/PostModel.php';
require_once __DIR__ . '/../entities/Post.php';
require_once __DIR__ . '/../util/Response.php';

class PostController
{
    private PostModel $post_model;

    public function __construct()
    {
        $this->post_model = new PostModel();
    }

    public function findAll()
    {
        $posts[] = new Post();
        $posts = $this->post_model->findAll();

        if ($posts) {
            return json_encode($posts);
        } else {
            return Response::sendWithCode(400, "no results found");
        }
    }

    public function findById($id)
    {
        $post = $this->post_model->findById($id);

        if ($post->getId()) {
            return $post->toJson();
        } else {
            return Response::sendWithCode(400, "no results found");
        }
    }

    public function findByTitle($title)
    {
        $posts[] = new Post();
        $posts = $this->post_model->findByTitle($title);

        if ($posts) {
            return json_encode($posts);
        } else {
            return Response::sendWithCode(400, "no results found");
        }
    }

    public function create($data)
    {
        $post = new Post();
        $post->setCategory($data->category);
        $post->setTitle($data->title);
        $post->setBody($data->body);
        $post->setAuthor($data->author);

        if ($this->post_model->create($post)) {
            return Response::sendWithCode(201, "new post created");
        } else {
            return Response::sendWithCode(500, "an error");
        }
    }

    public function update($id, $data)
    {
        $post = new Post();
        $post->setId($id);
        $post->setCategory($data->category);
        $post->setTitle($data->title);
        $post->setBody($data->body);
        $post->setAuthor($data->author);

        if ($this->post_model->update($post)) {
            return Response::sendWithCode(200, "post updated");
        } else {
            return Response::sendWithCode(500, "an error");
        }
    }

    public function delete($data)
    {
        $post = new Post();
        $post->setId($data->id);

        if ($this->post_model->delete($post)) {
            return Response::sendWithCode(204, "deleted");
        } else {
            return Response::sendWithCode(500, "an error");
        }
    }

}