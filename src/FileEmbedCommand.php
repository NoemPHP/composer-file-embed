<?php

declare(strict_types=1);

namespace Noem\Composer;

use Composer\Command\BaseCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FileEmbedCommand extends BaseCommand
{
    protected function configure()
    {
        $this->setName('embed-files');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Executing');
    }
}
