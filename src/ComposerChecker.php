<?php

namespace Kostersson\GithubSecurityChecker;

use Github\Client;
use Kostersson\GithubSecurityChecker\AlertHandler\AlertHandlerInterface;
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
     * @var SecurityChecker
     */
    private $securityChecker;

    /**
     * @var AlertHandler
     */
    private $alertHandler;

    /**
     * @param array                 $githubSettings
     * @param Client                $client
     * @param SecurityChecker       $securityChecker
     * @param AlertHandlerInterface $alertHandler
     */
    public function __construct(array $githubSettings, Client $client, SecurityChecker $securityChecker, AlertHandlerInterface $alertHandler)
    {
        $this->githubSettings = $githubSettings;
        $this->client = $client;
        $this->securityChecker = $securityChecker;
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
        $tempFile = tempnam(sys_get_temp_dir(), 'sec');

        $handle = fopen($tempFile, 'w');
        fwrite($handle, $this->client->api('repo')->contents()->download($organization, $repository['name'], 'composer.lock'));
        fclose($handle);

        $alerts = $this->securityChecker->check($tempFile);
        $contributors = $this->client->api('repo')->contributors($organization, $repository['name']);
        $this->alertHandler->handleAlerts($repository, $contributors, $alerts);
        unlink($tempFile);
    }
}
