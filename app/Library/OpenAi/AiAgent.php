<?php

namespace App\Library\OpenAi;

use App\Library\Response\AiResponse;
use OpenAI;

class AiAgent
{

    protected $service;

    protected $prompt;
    protected $configuration;

    private $output;
    private $model;
    private $usage;

    private $responses;



    public function __construct()
    {
        $key = config('services.openai.key');
        $this->service = OpenAI::client($key);
    }


    public function talk()
    {
        $input = array_merge($this->configuration, ['prompt' => $this->prompt]);
        $response = $this->service->completions()->create($input);
        return new AiResponse($response);
    }

    public function ask($input)
    {
        $this->prompt = $input['prompt'];
        unset($input['prompt']);
        $this->configuration = $input;
        $isFinished = false;
        $output = '';
        do {
            $response = $this->talk();
            $this->responses[] = $response;
            $isFinished = $response->isFinished();
            // $response = $response->getOutput();
            $output .= $response->getOutput();
            if (count($this->responses) > 5) {
                break;
            }
            if (!$isFinished) {
                // dd($this->prompt);
                // dd($response);
                $this->prompt .= $response->getOutput();
                // dd($this->prompt);
            }
        } while (!$isFinished);
        $this->output = $output;
        return $this;
        // dd($output);
        // $this->getUsage();
    }

    public function getOutput()
    {
        return $this->output;
    }


    public function getJson()
    {
        $output = $this->getOutput();
        //trim 
        $output = trim($output);
      
        return json_decode($output, true);
    }
    public function getResponses()
    {
        return $this->responses;
    }

    public function getModel()
    {
        return $this->configuration['model'];
    }

    public function getUsage()
    {
        $promptTokens = 0;
        $completionTokens = 0;
        $totalTokens = 0;
        foreach ($this->responses as $response) {
            $usage = $response->getUsage();
            $promptTokens += $usage->promptTokens;
            $completionTokens += $usage->completionTokens;
            $totalTokens += $usage->totalTokens;
        }
        return [
            'promptTokens' => $promptTokens,
            'completionTokens' => $completionTokens,
            'totalTokens' => $totalTokens,
            'iterations' => count($this->responses),
        ];
    }
}
