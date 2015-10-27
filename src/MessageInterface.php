<?php

namespace Kostersson\GithubSecurityChecker;

interface MessageInterface
{
    /**
     * @param string $message
     *
     * @return mixed
     */
    public function sendAlertMessage($message);
}
