<?php

namespace App\Services;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Client;
use Config;


class TravisCIService {
    function __construct(Client $guzzle) {
        if ( Config::get('travis.enterprise_uri') )
            $base_uri = Config::get('travis.enterprise_uri');
        else if( Config::get('travis.privacy') == 'private' )
            $base_uri = 'https://api.travis-ci.com';
        else 
            $base_uri = 'https://api.travis-ci.org';

        $this->config = [
                "base_uri" => $base_uri,
                "headers" => [
                "Authorization" => 'token ' . Config::get('travis.api_token'),
                "Travis-API-Version" => Config::get('travis.api_version'),
            ]
        ];

        $this->guzzle = $guzzle;
    }

    /**
     * GetUser
     *
     * @return Collection
     */
    public function getUser() {
        $request = new Request('GET', '/user');
        $response = $this->guzzle->send($request, $this->config);

        return json_decode($response->getBody());
    }

    /**
     * GetRepo
     *
     * @return Collection
     */
    public function getRepo($repo_name) {
        $request = new Request('GET', '/repo/' . $repo_name);
        $response = $this->guzzle->send($request, $this->config);

        return json_decode($response->getBody());
    }

    /**
     * GetRepoBuilds
     *
     * @return Collection
     */
    public function getRepoBuilds($repo_name) {
        $request = new Request('GET', '/repo/' . $repo_name . '/builds');
        $response = $this->guzzle->send($request, $this->config);

        return json_decode($response->getBody());
    }

    /**
     * GetRepoBuildsPullRequests
     *
     * @return Collection
     */
    public function getRepoBuildsPullRequests($repo_name) {
        $repos = $this->getRepoBuilds($repo_name);

        $repo_builds = collect($repos->builds)->filter(function($build) {
            return $build->event_type == 'pull_request';
        })->toArray();

        $repos->builds = $repo_builds;

        return $repos;
    }

    /**
     * GetJob
     *
     * @return Collection
     */
    public function getJob($job_id) {
        $request = new Request('GET', '/job/' . $job_id);
        $response = $this->guzzle->send($request, $this->config);

        return json_decode($response->getBody());
    }

    /**
     * GetJobLog
     *
     * @return Collection
     */
    public function getJobLog($job_id) {
        $request = new Request('GET', '/job/' . $job_id);
        $response = $this->guzzle->send($request, $this->config);

        $job_log = json_decode($response->getBody());

        $matches = [];

        preg_match('/Tests run: \\d{1,2}, Failures: \\d{1,2}, Errors: \\d{1,2}/', $job_log->content, $matches);

        return $job_log;
    }
}