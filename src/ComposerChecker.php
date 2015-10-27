<?php

namespace Kostersson\GithubSecurityChecker;

use Github\Client;
use SensioLabs\Security\SecurityChecker;

class ComposerChecker
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
     * @var AlertHandler
     */
    private $alertHandler;

    /**
     * @param array        $githubSettings
     * @param Client       $client
     * @param AlertHandler $alertHandler
     */
    public function __construct(array $githubSettings, Client $client, AlertHandler $alertHandler)
    {
        $this->githubSettings = $githubSettings;
        $this->client = $client;
        $this->alertHandler = $alertHandler;
    }

    /**
     * @param array $repository
     */
    public function check(array $repository)
    {
        if ($this->client->api('repo')->contents()->exists($this->githubSettings['organization'], $repository['name'], 'composer.lock')) {
            $this->checkComposerLock($this->githubSettings['organization'], $repository);
        }
    }

    /**
     * @param $organization
     * @param array $repository
     */
    private function checkComposerLock($organization, array $repository)
    {
        $temp_file = tempnam(sys_get_temp_dir(), 'sec');

        $handle = fopen($temp_file, 'w');
        fwrite($handle, $this->client->api('repo')->contents()->download($organization, $repository['name'], 'composer.lock'));
        fclose($handle);

        $checker = new SecurityChecker();
        $alerts = $checker->check($temp_file);
        $this->alertHandler->handleAlerts($repository, $alerts);
        unlink($temp_file);
    }
}
