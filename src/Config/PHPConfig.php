<?php namespace Gckabir\Arty\Config;

class PHPConfig extends AbstractFileBasedConfig
{

    public function all()
    {
        $this->config = $this->getFileContentsSafely();

        return parent::all();
    }

    protected function getFileContents()
    {
        return $this->filesystem->getRequire($this->filename);
    }
}
