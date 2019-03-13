<?php

namespace Ben182\LaravelDeployer\Commands;

use Illuminate\Console\Command;

class DeployInfo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deploy:infos {url} {version} {hash} {--bugsnag}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sets deploy relevant information';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $sUrl     = $this->argument('url');
        $sVersion = $this->argument('version');
        $sHash    = $this->argument('hash');

        $this->editEnvKey('APP_VERSION', $sVersion);

        if ($this->option('bugsnag')) {
            config([
                'app.version'         => $sVersion,
                'bugsnag.app_version' => $sVersion,
            ]);

            $this->call('bugsnag:deploy', [
                '--repository' => $sUrl,
                '--revision'   => $sHash,
            ]);
        }

        echo 'Set app version to ' . $sVersion . "\n";
    }

    protected function editEnvKey($sKey, $sValue)
    {
        $sPath = base_path('.env');

        if (! file_exists($sPath)) {
            return false;
        }

        $sFile = file_get_contents($sPath);

        preg_match("/(?<=$sKey=).*/", $sFile, $match);

        if (! isset($match[0])) {
            return false;
        }

        file_put_contents($sPath, str_replace(
            "$sKey=" . $match[0],
            "$sKey=" . $sValue,
            $sFile
        ));

        return true;
    }
}
