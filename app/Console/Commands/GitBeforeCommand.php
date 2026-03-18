<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

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

        $tasks = [
            [
                'name' => 'tests',
                'description' => 'Running PHPUnit tests',
                'critical' => true,
                'callback' => fn () => $this->call('test', ['--compact']),
            ],
            [
                'name' => 'lint',
                'description' => 'Running ESLint',
                'critical' => true,
                'callback' => fn () => $this->runExternalCommand(['bun', 'run', 'lint']),
            ],
            [
                'name' => 'pint',
                'description' => 'Running Laravel Pint',
                'critical' => true,
                'callback' => fn () => $this->runExternalCommand(['./vendor/bin/pint', '--repair']),
            ],
            [
                'name' => 'phpstan',
                'description' => 'Running PHPStan analysis on `app` directory',
                'critical' => true,
                'callback' => fn () => $this->runExternalCommand(['./vendor/bin/phpstan', 'analyse', 'app', '--memory-limit=512M']),
            ],
            [
                'name' => 'prettier',
                'description' => 'Running Prettier formatter check',
                'critical' => true,
                'callback' => fn () => $this->runExternalCommand(['bunx', 'prettier', '--check', './resources/']),
            ],
        ];

        $failed = [];

        foreach ($tasks as $task) {
            $this->line("\n{$task['description']}...");

            try {
                $result = $task['callback']();

                if ($result === 0) {
                    $this->info("✓ {$task['description']} passed!");
                } else {
                    $this->error("✗ {$task['description']} failed with code {$result}!");
                    $failed[] = $task['name'];
                }
            } catch (\Throwable $e) {
                $this->error("✗ {$task['description']} failed: {$e->getMessage()}");
                $failed[] = $task['name'];
            }
        }

        if (! empty($failed)) {
            $this->error("\n❌ Pre-commit checks failed! Please fix the issues above before committing.");
            $this->error('Failed checks: '.implode(', ', $failed));

            return 1;
        }

        $this->info("\n✅ All pre-commit checks passed! You can now commit your changes.");

        return 0;
    }

    private function runExternalCommand(array $args): int
    {
        $process = Process::fromShellCommandline(implode(' ', array_map(fn ($a) => escapeshellarg($a), $args)));
        $process->setTimeout(120);
        $process->run();

        $this->line($process->getOutput());

        return $process->isSuccessful() ? 0 : 1;
    }
}
