<?php

namespace App\Library\OpenAi;

use App\Library\Response\AiResponse;
use OpenAI;

class ProjectManager
{

    public $configuration = [
        'temperature' => 0.7,
        // 'model' => 'code-davinci-002',
        'model' => 'curie:ft-personal-2023-01-30-08-47-37',
        'max_tokens' => 200,
        'top_p' => 1,
        'frequency_penalty' => 0,
        'presence_penalty' => 0,
        'stop' => [
            "@@@", "\n",'@'
        ]
    ];

    private $response;

    protected $service;
    protected $project;

    public function __construct()
    {
        $key = config('services.openai.key');
        $this->service = OpenAI::client($key);
    }

    public function getResponse()
    {
        return $this->response;
    }

    private function getRequirementPrompt()
    {
        if ($this->configuration['model'] == 'code-davinci-002')
            return config('services.prompt.requirement');

        return '';
    }


    private function getSchemaPrompt()
    {
        if ($this->configuration['model'] == 'code-davinci-002')
            return config('services.prompt.schema');

        return '';
    }

    public function _getRequirementPrompt()
    {
        $prompt = '';
        $prompt .= $this->getRequirementPrompt();
        // dd($prompt);
        $prompt .= 'PROJECT: ' . $this->project['name'] . "\n";
        $prompt .= 'DESCRIPTION: ' . $this->project['description'] . " @@@\n";
        return $prompt;
    }


    public function _getSchemaPrompt()
    {
        $prompt = 'PROJECT: ' . $this->project['name'] . "\n";
        $prompt .= 'DESCRIPTION: ' . $this->project['description'] . " @@@\n";
        $prompt .= 'REQUIREMENTS:' . json_encode($this->project['requirement']) . " @@@\n";
        return $prompt;
    }

    public function generateRequirement(array $project)
    {
        $this->project = $project;
        $prompt = $this->_getRequirementPrompt();
        $prompt .= 'REQUIREMENTS:';
        // dd($prompt);
        $input = array_merge($this->configuration, ['prompt' => $prompt]);
        return (new AiAgent())->ask($input);
    }

    public function generateProjectSchema(array $project)
    {
        $this->project = $project;
        $prompt = $this->_getSchemaPrompt();
        $prompt .= 'SCHEMA:';
        $this->configuration['max_tokens'] = 500;
        $input = array_merge($this->configuration, ['prompt' => $prompt]);
        return (new AiAgent())->ask($input);
    }
}
