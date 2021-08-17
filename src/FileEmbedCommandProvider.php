<?php

declare(strict_types=1);

namespace Noem\Composer;

use Composer\Plugin\Capability\CommandProvider;

class FileEmbedCommandProvider implements CommandProvider
{

    public function getCommands()
    {
        return [
            new FileEmbedCommand(getcwd()),
        ];
    }
}
