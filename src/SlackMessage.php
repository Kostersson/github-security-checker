<?php

namespace Kostersson\GithubSecurityChecker;

use ThreadMeUp\Slack\Client;

class SlackMessage implements MessageInterface
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function sendAlertMessage($message)
    {
        // TODO: Implement sendAlertMessage() method.
    }
}
