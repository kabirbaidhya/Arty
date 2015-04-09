<?php namespace Gckabir\Arty;

use Composer\Script\Event;
use Composer\Installer\PackageEvent;

class ComposerHook
{

    public static function postPackageInstall(PackageEvent $event)
    {
        ob_flush();
        flush();
        $package = $event->getOperation()->getPackage();
        // do stuff

        echo ' postPackageInstall: '.get_class($package);

        echo ' name = '.$package->getName();
        echo ' target dir = '.$package->getTargetDir();
    }
}
