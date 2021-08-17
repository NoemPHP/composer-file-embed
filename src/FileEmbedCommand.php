<?php

declare(strict_types=1);

namespace Noem\Composer;

use Composer\Command\BaseCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class FileEmbedCommand extends BaseCommand
{

    public function __construct(private string $baseDir)
    {
        parent::__construct('embed-files');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Executing');
        $output->writeln($this->baseDir);
        /**
         * @var SplFileInfo[]
         */
        $finder = (new Finder())
            ->in($this->baseDir.'/**')
            ->exclude('vendor')
            ->files()
            ->name('*.md')
            ->contains('/\[embedmd]:# \(/');

        foreach ($finder as $file) {
            $output->writeln('Processing '.$file->getPathname());

            $matches = [];
            preg_match_all(
                '/\[embedmd]:# \((?<definition>[^\n`]*?)\)\n(?<existing>```.*?```)?/ms',
                $file->getContents(),
                $matches
            );
            if (empty($matches) || empty($matches[0])) {
                continue;
            }
            $definitions = [];
            foreach ($matches[0] as $i => $fullMatch) {
                $definitions[] = new Definition(
                    $fullMatch,
                    $matches['definition'][$i] ?? '',
                    $matches['existing'][$i] ?? ''
                );
            }
            (new FileProcessor())->process($file->getPathname(), $file->getPathname(), ...$definitions);
        }
    }
}
