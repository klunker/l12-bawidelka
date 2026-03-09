<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GitBeforeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:git-before';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run tests, lint, pint, phpstan, and formatter before git commit';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Running pre-commit quality checks...');

        $commands = [
            'tests' => [
                'command' => ['./vendor/bin/phpunit', '--compact'],
                'description' => 'Running PHPUnit tests',
                'critical' => true,
            ],
            'lint' => [
                'command' => ['./vendor/bin/eslint', '.'],
                'description' => 'Running ESLint',
                'critical' => true,
            ],
            'pint' => [
                'command' => ['./vendor/bin/pint'],
                'description' => 'Running Laravel Pint',
                'critical' => true,
            ],
            'phpstan' => [
                'command' => ['./vendor/bin/phpstan', 'analyse'],
                'description' => 'Running PHPStan analysis',
                'critical' => true,
            ],
            'prettier' => [
                'command' => ['npx', 'prettier', '--check', '.'],
                'description' => 'Running Prettier formatter check',
                'critical' => true,
            ],
        ];

        $failed = [];

        foreach ($commands as $name => $config) {
            $this->line("\n{$config['description']}...");

            $process = new \Symfony\Component\Process\Process($config['command']);
            $process->run(function ($type, $buffer) {
                if ($type === \Symfony\Component\Process\Process::ERR) {
                    $this->error($buffer);
                } else {
                    $this->line($buffer);
                }
            });

            if (!$process->isSuccessful()) {
                $this->error("✗ {$config['description']} failed!");
                $failed[] = $name;
            } else {
                $this->info("✓ {$config['description']} passed!");
            }
        }

        if (!empty($failed)) {
            $this->error("\n❌ Pre-commit checks failed! Please fix the issues above before committing.");
            $this->error("Failed checks: " . implode(', ', $failed));
            return 1;
        }

        $this->info("\n✅ All pre-commit checks passed! You can now commit your changes.");
        return 0;
    }
}
