<?php

namespace Jijoel\AuthApi\Console;

use Illuminate\Console\Command;
use Illuminate\Console\DetectsApplicationNamespace;

class MakeAuthCommand extends Command
{
    use DetectsApplicationNamespace;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:api-auth
        {--force : Overwrite existing files by default}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scaffold back-end api authentication';

    protected $directories = [
        'Http/Controllers/Api/Auth/' => [
            'ForgotPasswordController',
            'LoginController',
            'RegistrationController',
            'ResetPasswordController',
            'SocialAuthenticationController',
        ],
    ];


    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->createDirectories();
        $this->copyFiles();

        $this->info('API Authentication scaffolding generated successfully.');
    }

    /**
     * Create the directories for the files.
     *
     * @return void
     */
    protected function createDirectories()
    {
        foreach($this->directories as $dir => $files) {
            if (! is_dir($directory = app_path($dir)))
                mkdir($directory, 0755, true);
        }
    }

    protected function copyFiles()
    {
        foreach($this->directories as $dir => $files) {
            $this->createDirectory($dir);
            foreach($files as $file) {
                $this->copyFile($dir, $file);
            }
        }
    }

    /**
     * Create each required directory
     *
     * @param  String $dir   directory to create
     *
     * @return null
     */
    protected function createDirectory($dir)
    {
        if (! is_dir($directory = app_path($dir)))
            mkdir($directory, 0755, true);
    }

    /**
     * Copy a file from the stub location to the app location.
     * Set the namespace to the application namespace when copying.
     *
     * @param  String $dir  The file is in this directory
     * @param  String $file The name of the file
     *
     * @return null
     */
    protected function copyFile($dir, $file)
    {
        $src = base_path("vendor/jijoel/laravel-auth-api/stubs/$dir/$file.php");
        $dest = app_path("$dir/$file.php");

        if (file_exists($dest) && ! $this->option('force')) {
            if (! $this->confirm("The file [{$file}] already exists. Do you want to replace it?")) {
                return;
            }
        }

        $data = $this->setAppNamespace($src);
        file_put_contents($dest, $data);
    }

    /**
     * Change the namespace of a stub file
     *
     * @param String $file   full path and file name
     */
    protected function setAppNamespace($file)
    {
        return str_replace(
            'App\\',
            $this->getAppNamespace(),
            file_get_contents($file)
        );
    }

}
