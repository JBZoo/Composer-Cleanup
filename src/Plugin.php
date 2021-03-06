<?php
/**
 * JBZoo Composer Cleanup Plugin
 *
 * This file is part of the JBZoo CCK package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package   JBZoo\Composer\Cleanup
 * @license   MIT
 * @copyright Copyright (C) JBZoo.com,  All rights reserved.
 * @link      https://github.com/JBZoo/Composer-Cleanup
 * @author    Denis Smetannikov <denis@jbzoo.com>
 */

namespace JBZoo\Composer\Cleanup;

use Composer\Composer;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;
use Composer\Script\ScriptEvents;
use Composer\Script\PackageEvent;
use Composer\Script\CommandEvent;
use Composer\Util\Filesystem;
use Composer\Package\BasePackage;

/**
 * Class Plugin
 * @package JBZoo\Composer\Cleanup
 *
 * @SuppressWarnings(PHPMD.ShortVariable)
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 */
class Plugin implements PluginInterface, EventSubscriberInterface
{
    /**
     * @var  \Composer\Composer $composer
     */
    protected $composer;

    /**
     * @var  \Composer\IO\IOInterface $io
     */
    protected $io;

    /**
     * @var  \Composer\Config $config
     */
    protected $config;

    /**
     * @var  \Composer\Util\Filesystem $filesystem
     */
    protected $filesystem;

    /**
     * @var  array $rules
     */
    protected $rules;

    /**
     * {@inheritDoc}
     */
    public function activate(Composer $composer, IOInterface $io)
    {
        $this->composer   = $composer;
        $this->io         = $io;
        $this->config     = $composer->getConfig();
        $this->filesystem = new Filesystem();
        $this->rules      = Rules::getRules();
    }

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            ScriptEvents::POST_PACKAGE_INSTALL => array(
                array('onPostPackageInstall', 0),
            ),
            ScriptEvents::POST_PACKAGE_UPDATE  => array(
                array('onPostPackageUpdate', 0),
            ),
            ScriptEvents::POST_INSTALL_CMD     => array(
                array('onPostInstallUpdateCmd', 0),
            ),
            ScriptEvents::POST_UPDATE_CMD      => array(
                array('onPostInstallUpdateCmd', 0),
            ),
        );
    }

    /**
     * Function to run after a package has been installed
     */
    public function onPostPackageInstall(PackageEvent $event)
    {
        /** @var \Composer\Package\CompletePackage $package */
        $package = $event->getOperation()->getPackage();

        //$this->io->write('Called: ' . __METHOD__);

        $this->cleanPackage($package);
    }

    /**
     * Function to run after a package has been updated
     */
    public function onPostPackageUpdate(PackageEvent $event)
    {
        /** @var \Composer\Package\CompletePackage $package */
        $package = $event->getOperation()->getTargetPackage();

        //$this->io->write('Called: ' . __METHOD__);

        $this->cleanPackage($package);
    }

    /**
     * Function to run after a package has been updated
     *
     * @param CommandEvent $event
     */
    public function onPostInstallUpdateCmd(CommandEvent $event)
    {
        /** @var \Composer\Repository\WritableRepositoryInterface $repository */
        $repository = $this->composer->getRepositoryManager()->getLocalRepository();

        /** @var \Composer\Package\CompletePackage $package */
        foreach ($repository->getPackages() as $package) {
            if ($package instanceof BasePackage) {
                $this->cleanPackage($package);
            }
        }
    }

    /**
     * Clean a package, based on its rules.
     *
     * @param BasePackage $package The package to clean
     * @return bool True if cleaned
     *
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    protected function cleanPackage(BasePackage $package)
    {
        $vendorDir   = $this->config->get('vendor-dir');
        $targetDir   = $package->getTargetDir();
        $packageName = $package->getPrettyName();
        $packageDir  = $targetDir ? $packageName . '/' . $targetDir : $packageName;

        $rules = isset($this->rules[$packageName]) ? $this->rules[$packageName] : null;
        if (!$rules) {
            $this->io->writeError('Rules not found: ' . $packageName);
            return false;
        }

        $dir = $this->filesystem->normalizePath(realpath($vendorDir . '/' . $packageDir));
        if (!is_dir($dir)) {
            $this->io->writeError('Vendor dir not found: ' . $vendorDir . '/' . $packageDir);
            return false;
        }

        //$this->io->write('Rules: ' . print_r($rules, true));

        foreach ((array)$rules as $part) {
            // Split patterns for single globs (should be max 260 chars)
            $patterns = (array)$part;

            foreach ($patterns as $pattern) {
                try {
                    foreach (glob($dir . '/' . $pattern) as $file) {
                        $this->filesystem->remove($file);
                        //$this->io->write('File removed: ' . $file);
                    }
                } catch (\Exception $e) {
                    $this->io->write("Could not parse $packageDir ($pattern): " . $e->getMessage());
                }
            }
        }

        return true;
    }
}
