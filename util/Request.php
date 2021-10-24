<?php

class Request
{
    public $params;
    public $contentType;

    public function __construct($params = [])
    {
        $this->params = $params;
        $this->contentType = !empty($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
    }

    public function getJSON()
    {
        if (strcasecmp($this->contentType, 'application/json') !== 0) {
            return [];
        }
        $data = json_decode(file_get_contents("php://input"));

        if($data == null){
            throw new JsonException('Could not decode the data.');
        }

        return $data;
    }
}
