<?php

namespace Kostersson\GithubSecurityChecker\AlertHandler;

use Kostersson\GithubSecurityChecker\Message\MessageInterface;

class AlertHandler implements AlertHandlerInterface
{
    /**
     * @var MessageInterface
     */
    private $messageInterface;

    /**
     * @param MessageInterface $messageInterface
     */
    public function __construct(MessageInterface $messageInterface)
    {
        $this->messageInterface = $messageInterface;
    }

    /**
     * @param array $repository
     * @param array $contributors
     * @param array $alerts
     */
    public function handleAlerts(array $repository, array $contributors, array $alerts)
    {
        if (count($alerts) === 0) {
            return;
        }
        $str = '';
        foreach ($contributors as $contributor) {
            $str .= '<@'.$contributor['login'].'> ';
        }
        $str .= '\nRepository name: '.$repository['name']."\n";
        $str .= "----------------------------------------------\n";
        foreach ($alerts as $project => $alert) {
            $str .= $project.' version: '.$alert['version'];
            foreach ($alert['advisories'] as $file => $advisory) {
                $str .= ' ('.$file.")\n";
                foreach ($advisory as $title => $data) {
                    $str .= $title.': '.$data."\n";
                }
            }
            $str .= "----------------------------------------------\n";
        }
        $str .= "#####################################################\n";
        $this->messageInterface->sendAlertMessage($str);
    }
}
