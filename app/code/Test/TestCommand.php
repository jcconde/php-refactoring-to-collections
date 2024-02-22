<?php

/**
 * @copyright Copyright © 2024 Semain. All rights reserved.
 * @author    Juan Carlos Conde <juancarlosc@onetree.com>
 */

declare(strict_types=1);

namespace Semajo\Project\Test;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 */
class TestCommand extends Command
{
    public const COMMAND_NAME = 'test:command';

    /**
     * Configure the star command
     * @see Command
     */
    protected function configure(): void
    {
        $this->setName(self::COMMAND_NAME);
        $this->setDescription('Test Command');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Execute test command...');
        return Command::SUCCESS;
    }
}
