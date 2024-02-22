<?php

/**
 * @copyright Copyright © 2024 Semajo. All rights reserved.
 * @author    Juan Carlos Conde <juancarlosc@onetree.com>
 */

declare(strict_types=1);

namespace Semajo\Project;

use Exception;
use Symfony\Component\Console\Application;

class Console
{
    /**
     * @return void
     * @throws Exception
     */
    public static function run(): void
    {
        $application = new Application("PHP Console Tool", "0.1.0");

        $commandClassNames = self::getCommandClassNames(dirname(__FILE__), __NAMESPACE__);
        foreach ($commandClassNames as $commandClassName) {
            $application->add(new $commandClassName());
        }

        $application->run();
    }

    /**
     * Build an array of PHP class names (including namespaces) for all command classes by recursively running
     * through the subdirectories (of the given directory) and finding all PHP files with a filename ending in
     * "Command.php".
     *
     * @param string $directory
     * @param string $namespace
     * @return array
     */
    private static function getCommandClassNames(string $directory, string $namespace): array
    {
        $commandClassNames = [];
        $directoryHandle = opendir($directory);
        if ($directoryHandle) {
            // Iterate through all files and directories
            while (($filename = readdir($directoryHandle)) !== false) {
                $filepath = $directory . DIRECTORY_SEPARATOR . $filename;
                if (!is_dir($filepath)) {
                    // We found a file. Does its filename end in 'Command.php'?
                    if (str_ends_with($filepath, 'Command.php')) {
                        // Build the class name and store it in the class name array.
                        $pathInfo = pathinfo($filepath);
                        $commandClassNames[] = $namespace . '\\' . $pathInfo['filename'];
                    }
                } elseif ($filename !== '.' && $filename !== '..') {
                    // We found a directory (different from "." and ".."). Recursively get the class names
                    // of the commands found in the new directory and add them to the internal array.
                    $commandClassNames = array_merge(
                        $commandClassNames,
                        self::getCommandClassNames($filepath, $namespace . '\\' . $filename)
                    );
                }
            }
            closedir($directoryHandle);
        }

        return $commandClassNames;
    }
}
