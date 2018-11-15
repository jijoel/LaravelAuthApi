<?php

namespace Jijoel\AuthApi\Console;

use Illuminate\Console\Command;


class MakeJsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:api-js
        {--all : Publish all javascript files for customization }
        {--components : Publish components for customization }
        {--forms : Publish forms for customization }
        {--middleware : Publish middleware for customization }
        {--layouts : Publish layouts for customization }
        {--mixins : Publish mixins for customization }
        {--pages : Publish pages for customization }
        {--plugins : Publish plugins for customization [default] }
        {--routes : Publish route files for customization [default] }
        {--store : Publish store files for customization [default] }

        {--force : Overwrite existing files by default }
        {--framework=vuetify-api-auth : Use the specified framework }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scaffold front-end resources for api authentication';

    /**
     * The default directories to copy in full
     */
    protected $defaults = [
        'plugins',
        'routes',
        'store',
    ];

    /**
     * The directories and files to copy
     */
    protected $directories = [
        'components',
        'forms',
        'middleware',
        'layouts',
        'mixins',
        'pages',
        'plugins',
        'routes',
        'store',
    ];

    /**
     * Execute the console command.
     *
     * @param  \Laravel\Passport\ClientRepository  $clients
     * @return void
     */
    public function handle()
    {
        $this->createDirectories();
        $this->copyFiles();

        $this->info('Javascript scaffolding for API Authentication generated successfully.');
    }

    /**
     * Create the directories for the files.
     *
     * @return void
     */
    protected function createDirectories()
    {
        foreach($this->directories as $dir)
            $this->createDirectory($dir);
    }

    /**
     * Create a single directory
     *
     * @param  String $dir   directory to create
     *
     * @return null
     */
    protected function createDirectory($dir)
    {
        if (! is_dir($directory = resource_path('js/'.$dir)))
            mkdir($directory, 0755, true);
    }


    /**
     * Copy files to the directories
     *
     * @return null
     */
    protected function copyFiles()
    {
        foreach($this->directories as $dir) {
            $this->createDirectory($dir);

            if (! $this->includeFiles($dir))
                continue;

            $files = $this->getFileList($this->getSrc($dir));
            foreach($files as $file) {
                $this->copyFile($dir, $file);
            }
        }
    }

    /**
     * Return a list of all files in the given directory
     *
     * @param  String $dir  absolute path to desired directory
     * @return Array        list of visible files in the directory
     */
    protected function getFileList($dir)
    {
        $list = scandir($dir);

        return array_where($list, function($a) use ($dir) {
            return ($a[0] !== '.')
                && is_file($dir.'/'.$a);
        });
    }

    /**
     * Return the source path for files,
     * based on given framework
     *
     * @param  string $path [description]
     * @return [type]       [description]
     */
    protected function getSrc($path='')
    {
        $framework = $this->option('framework');

        return base_path("node_modules/$framework/src/$path");
    }

    /**
     * Return the destination path for files
     */
    protected function getDest($path='')
    {
        return resource_path("js/$path");
    }

    /**
     * Should we include files from this directory?
     */
    protected function includeFiles($dir)
    {
        // If they're explicitly called, include them
        if ($this->option($dir) || $this->option('all'))
            return true;

        // If specific directories are called, don't include others
        if (! $this->useDefaultDirectories())
            return false;

        // Include any of the defaults
        return in_array($dir, $this->defaults);
    }

    /**
     * Should we ONLY use default directories?
     * (only do this if no directories have been specified)
     *
     * @return Boolean
     */
    protected function useDefaultDirectories()
    {
        if ($this->option('all'))
            return false;

        $options = $this->options();
        foreach($this->directories as $opt)
            if (isset($options[$opt]) && $options[$opt])
                return false;

        return true;
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
        $src = $this->getSrc("$dir/$file");
        $dest = $this->getDest("$dir/$file");

        if (file_exists($dest) && ! $this->option('force')) {
            if (! $this->confirm("The file [{$file}] already exists. Replace it?")) {
                return;
            }
        }

        $data = file_get_contents($src);
        file_put_contents($dest, $data);
    }

}
