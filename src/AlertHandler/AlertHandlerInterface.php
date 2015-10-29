<?php

namespace Kostersson\GithubSecurityChecker\AlertHandler;

interface AlertHandlerInterface
{
    /**
     * @param array $repository
     * @param array $contributors
     * @param array $alerts
     *
     * @return
     */
    public function handleAlerts(array $repository, array $contributors, array $alerts);
}
