<?php

declare(strict_types=1);

namespace ArmorCMS\Shared\ConsoleCommand;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

final class SetupUploadDirectories extends Command
{
    private Filesystem $filesystem;

    public function __construct(
        private string $userAvatarDirectory,
        private readonly array $thumbnailSizes
    ) {
        parent::__construct('armorcms:setup-upload-directories');
        $this->filesystem = new Filesystem();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (false === $this->filesystem->exists($this->userAvatarDirectory)) {
            $this->filesystem->mkdir($this->userAvatarDirectory);
        }

        foreach ($this->thumbnailSizes as $thumbnailName => $thumbnailSize) {
            $thumbnailDirectory = sprintf('%s/%s', $this->userAvatarDirectory, $thumbnailName);
            if (false === $this->filesystem->exists($thumbnailDirectory)) {
                $this->filesystem->mkdir($thumbnailDirectory);
            }
        }

        return Command::SUCCESS;
    }
}