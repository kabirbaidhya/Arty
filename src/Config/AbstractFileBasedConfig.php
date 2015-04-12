<?php namespace Gckabir\Arty\Config;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

abstract class AbstractFileBasedConfig extends Config
{
    protected $filename;

    public function __construct($filename, Filesystem $fs)
    {
        parent::__construct(array());

        $this->fs = $fs;
        $this->filename = $filename;
    }

    protected function getFileContentsSafely()
    {
        if (!$this->filename) {
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
        return $this->fs->get($this->filename);
    }
}
