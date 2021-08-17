<?php

declare(strict_types=1);

namespace Noem\Composer;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Plugin\Capability\CommandProvider;
use Composer\Plugin\Capable;
use Composer\Plugin\PluginInterface;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\Script\Event;
use Composer\Script\ScriptEvents;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\ConsoleOutput;

class FileEmbedPlugin implements PluginInterface, Capable
{

    public function activate(Composer $composer, IOInterface $io)
    {
    }

    public function getCapabilities(): array
    {
        return [
            CommandProvider::class => FileEmbedCommandProvider::class,
        ];
    }

    public function deactivate(Composer $composer, IOInterface $io)
    {
    }

    public function uninstall(Composer $composer, IOInterface $io)
    {
    }
}
