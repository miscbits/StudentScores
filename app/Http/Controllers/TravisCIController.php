<?php

namespace App\Http\Controllers;

use App\Services\TravisCIService;
use Illuminate\Http\Request;

class TravisCIController extends Controller
{
    public function __construct(TravisCIService $service) {
        $this->service = $service;
    }

    public function builds($repo_name)
    {
        return $this->service->getRepoBuilds($repo_name);
    }

    public function pullRequests($repo_name) {
        return $this->service->getRepoBuildsPullRequests($repo_name);
    }

    public function repository($repo_name)
    {
        return $this->service->getRepo($repo_name);
    }

    public function job($job_id) {
        return $this->service->getJob($job_id);
    }

    public function jobLog($job_id) {
        return $this->service->getJobLog($job_id);
    }

}
