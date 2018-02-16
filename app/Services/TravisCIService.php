<?php

namespace App\Services;

use GuzzleHttp\Client;
use Config;

class TravisCIService {
    function __construct(Client $guzzle) {
        $this->guzzle = $guzzle;
    }

    /**
     * GetUser
     *
     * @return Collection
     */
    public function getUser() {

    }

    /**
     * GetRepo
     *
     * @return Collection
     */
    public function getRepo($repo_name) {

    }

    /**
     * GetRepoBuilds
     *
     * @return Collection
     */
    public function getRepoBuilds($repo_name) {

    }

    /**
     * GetRepoBuildsPullRequests
     *
     * @return Collection
     */
    public function getRepoBuildsPullRequests($repo_name) {

    }

    /**
     * GetJob
     *
     * @return Collection
     */
    public function getJob($job_id) {

    }

    /**
     * GetJobLog
     *
     * @return Collection
     */
    public function getJobLog($job_id) {

    }
}