<?php

namespace App\Queue;

use App\Library\OpenAi\ProjectManager;
use App\Services\Project\BuildService;

class SchemaQueue extends MainQueue
{
    public $BuildID;
    public $connection = [
        'user' => 'guest',
        'password' => 'guest',
        'vhost' => "/",
        'host' => "rabbitmq",
        'port' => "5672"
    ];
    public function __construct($buildNumber = '')
    {
        $this->BuildID = $buildNumber;
    }

    public function handle()
    {
        echo "Building Project. Build Number " . $this->BuildID;
        $build = (new BuildService)->find($this->BuildID);
        if ($build) {
            $data = [
                'name' => $build->name,
                'description' => $build->description,
                'requirement' => $build->requirement
            ];
            $requirement = new ProjectManager();
            $response = $requirement->generateProjectSchema($data);
            $data = [
                'output' => $response->getOutput(),
                'usage' => $response->getUsage(),
                'model' => $response->getModel(),
                'configuration' => $requirement->configuration,
                'json' => $response->getJson()
            ];
            $build->schema = $response->getJson();
            $build->save();
            echo "Build Saved";
        }
        echo "Build Number " . $this->BuildID . " Completed";
    }
}
