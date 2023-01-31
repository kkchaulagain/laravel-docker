<?php

namespace App\Library\Response;

class AiResponse
{
    private $response;

    private $output, $model;

    private $usage;

    public function __construct($response)
    {
        $this->response = $response;
        $this->parse();
    }

    public function parse()
    {
        $choices = $this->response->choices;
        $this->output = $choices[0]->text;
        $this->usage = $this->response->usage;
        $this->model = $this->response->model;
    }

    public function getOutput()
    {
        return $this->output;
    }

    public function getUsage()
    {
        return $this->usage;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function isFinished()
    {
        $choices = $this->response->choices;
        if ($choices[0]->finishReason == 'stop') {
            return true;
        }
        return false;
    }
}
