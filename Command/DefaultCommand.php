<?php

namespace VideoGamesRecords\DwhBundle\Command;

use Doctrine\DBAL\Logging\DebugStack;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DefaultCommand extends Command
{
    protected static $defaultName = 'vgr-dwh:default';

    private $sglLoggerEnabled = false;
    private $stack;

    protected function init(InputInterface $input)
    {
        if ($input->getOption('debug')) {
            $this->sglLoggerEnabled = true;
            // Start setup logger
            $doctrine = $this->getContainer()->get('doctrine');
            $doctrineConnection = $doctrine->getConnection();
            $this->stack = new DebugStack();
            $doctrineConnection->getConfiguration()->setSQLLogger($this->stack);
            // End setup logger
        }
    }

    protected function end(OutputInterface $output)
    {
        if ($this->sglLoggerEnabled) {
            $output->writeln(sprintf('%s queries', count($this->stack->queries)));
        }
    }
}
