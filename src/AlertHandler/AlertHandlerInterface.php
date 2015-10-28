<?php

namespace Kostersson\GithubSecurityChecker\AlertHandler;

interface AlertHandlerInterface
{
    /**
     * @param array $repository
     * @param array $alerts
     */
    public function handleAlerts(array $repository, array $alerts);
}
