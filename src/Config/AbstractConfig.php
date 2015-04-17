<?php namespace Gckabir\Arty\Config;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

abstract class AbstractConfig
{
    protected $filename;
    protected $config;

    public function __construct($filename, Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
        $this->filename = $filename;
        $this->config = [];
    }

    protected function getFileContentsSafely()
    {
        if (!trim($this->filename)) {
            throw new \RuntimeException("Configuration file isn't set");
        }

        try {
            return $this->getFileContents();
        } catch (FileNotFoundException $e) {
            throw new FileNotFoundException("Configuration file doesn't exist: ".$this->filename);
        }
    }

    protected function getFileContents()
    {
        return $this->filesystem->get($this->filename);
    }

    /**
     * Get the default config
     * @return array
     */
    protected function getDefaultConfig()
    {
        $default = require __DIR__.'/../../misc/default.config.php';

        $script = $_SERVER['SCRIPT_FILENAME'];
        $default['path']   = dirname(realpath($script));

        return array_dot($default);
    }

    /**
     * Get a merged array of default and overriden config
     * @return array
     */
    public function all()
    {
        $defaultConfig = $this->getDefaultConfig();
        $userConfig = array_dot($this->config);

        $config = ($userConfig + $defaultConfig);

        return array_undot($config);
    }
}
