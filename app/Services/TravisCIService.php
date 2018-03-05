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
    public function getRepo($repo_id) {
        $request = new Request('GET', '/repo/' . $repo_id);
        $response = $this->guzzle->send($request, $this->config);

        return json_decode($response->getBody());
    }

    /**
     * GetRepoBuilds
     *
     * @return Collection
     */
    public function getRepoBuilds($repo_id) {
        $request = new Request('GET', '/repo/' . $repo_id . '/builds');
        $response = $this->guzzle->send($request, $this->config);

        return json_decode($response->getBody());
    }

    /**
     * GetRepoBuildsPullRequests
     *
     * @return Collection
     */
    public function getRepoBuildsPullRequests($repo_id) {
        $repos = $this->getRepoBuilds($repo_id);

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
        $request = new Request('GET', '/job/' . $job_id . '/log');
        $response = $this->guzzle->send($request, $this->config);

        $job_log = json_decode($response->getBody());

        $matches = [];
        $total_tests = 0;
        $tests_passed = 0;
        $offset = 0;

        while(preg_match('/Tests run: (\\d{1,2}), Failures: (\\d{1,2}), Errors: (\\d{1,2})/', $job_log->content, $matches, PREG_OFFSET_CAPTURE, $offset)) {
            $total_tests += (int)$matches[1][0];
            $tests_passed += (int)$matches[1][0] - (int)$matches[2][0] - (int)$matches[3][0];
            $offset = $matches[3][1];
        }

        $job_log->total_tests = $total_tests/2;
        $job_log->tests_passed = $tests_passed/2;
                
        return $job_log;
    }

    /**
     * Get Repos From User
     *
     * @return Collection
     */
    public function getReposFromUser($user_name) {
        $request = new Request('GET', '/owner/' . $user_name . '/repos');
        $response = $this->guzzle->send($request, $this->config);

        return json_decode($response->getBody());
    }


}