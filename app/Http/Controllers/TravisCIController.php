<?php

namespace App\Http\Controllers;

use App\Services\TravisCIService;
use Illuminate\Http\Request;
use Config;

class TravisCIController extends Controller
{
    public function __construct(TravisCIService $service) {
        $this->service = $service;
    }

    public function repos() {
        return json_encode($this->service->getReposFromUser(Config::get('travis.user')));
    }

    public function builds($repo_name)
    {
        return json_encode($this->service->getRepoBuilds($repo_name));
    }

    public function pullRequests($repo_name) {
        return json_encode($this->service->getRepoBuildsPullRequests($repo_name));
    }

    public function repository($repo_name)
    {
        return json_encode($this->service->getRepo($repo_name));
    }

    public function job($job_id) {
        return json_encode($this->service->getJob($job_id));
    }

    public function jobLog($job_id) {
        return json_encode($this->service->getJobLog($job_id));
    }

}
