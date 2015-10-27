<?php

namespace Kostersson\GithubSecurityChecker;

class SlackWebhookMessage implements MessageInterface
{
    /**
     * @var string
     */
    private $webhookUrl;

    /**
     * @param array $slackSettings
     */
    public function __construct(array $slackSettings)
    {
        $this->webhookUrl = $slackSettings['webhook'];
    }

    /**
     * @param string $message
     *
     * @return mixed
     */
    public function sendAlertMessage($message)
    {
        $data = 'payload={"text": "'.$message.'"}';

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $this->webhookUrl);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        $result = curl_exec($curl);
        curl_close($curl);

        return $result;
    }
}
