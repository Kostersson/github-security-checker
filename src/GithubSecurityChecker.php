<?php

namespace Kostersson\GithubSecurityChecker;

use Github\Client;

class GithubSecurityChecker
{
    /**
     * @var array
     */
    private $githubSettings;

    /**
     * @var Client
     */
    private $client;

    /**
     * @var ComposerChecker
     */
    private $composerChecker;

    /**
     * @param array           $githubSettings
     * @param Client          $client
     * @param ComposerChecker $composerChecker
     */
    public function __construct(array $githubSettings, Client $client, ComposerChecker $composerChecker)
    {
        $this->githubSettings = $githubSettings;
        $this->client = $client;
        $this->composerChecker = $composerChecker;

        $this->authenticate();
    }

    /**
     *
     */
    public function run()
    {
        $repos = $this->client->api('organization')->repositories($this->githubSettings['organization'], 'member');

        /*
         * @var Github\Api\Repo
         */
        foreach ($repos as $repo) {
            $this->composerChecker->check($repo);
        }
    }

    /**
     *
     */
    private function authenticate()
    {
        $this->client->authenticate($this->githubSettings['token'], null, Client::AUTH_HTTP_TOKEN);
    }
}
