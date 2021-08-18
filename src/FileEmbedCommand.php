<?php

declare(strict_types=1);

namespace Noem\Composer;

use Composer\Command\BaseCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class FileEmbedCommand extends BaseCommand
{

    public function __construct(private string $baseDir)
    {
        parent::__construct('embed-files');
    }

    public static function runStatic()
    {
        (new self(getcwd()))->execute(new ArrayInput([]), new ConsoleOutput());
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
                             '<info>Embedding code snippets in Markdown</>',
                             '<info>===================================</>',
                         ]);
        /**
         * @var SplFileInfo[]
         */
        $finder = (new Finder())
            ->in($this->baseDir)
            ->exclude('vendor')
            ->files()
            ->name('*.md')
            ->contains('/\[embed]:# \(/');

        foreach ($finder as $file) {
            $output->writeln('Processing ' . $file->getPathname());

            $matches = [];
            preg_match_all(
                '/\[embed]:# \((?<definition>[^\n`]*?)\)\n(?<existing>```.*?```)?/ms',
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
            try {
                (new FileProcessor())->process($file->getPathname(), $file->getPathname(), ...$definitions);
            } catch (\Throwable $e) {
                $output->writeln('<error>' . $e->getMessage() . '</error>');
            }
        }
    }
}
