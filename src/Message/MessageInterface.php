<?php

namespace Kostersson\GithubSecurityChecker\Message;

interface MessageInterface
{
    /**
     * @param string $message
     *
     * @return mixed
     */
    public function sendAlertMessage($message);
}
