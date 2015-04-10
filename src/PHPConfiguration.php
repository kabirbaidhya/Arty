<?php namespace Gckabir\Arty;

use Illuminate\Filesystem\Filesystem;

class PHPConfiguration extends Configuration
{
    protected $filename;

    public function __construct($filename)
    {
        $this->filename = $filename;

        parent::__construct(array());
    }

    public function all()
    {
        $fs = new Filesystem();

        $this->config = $fs->getRequire($this->filename);

        return parent::all();
    }
}
