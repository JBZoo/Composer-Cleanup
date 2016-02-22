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

/**
 * Class Rules
 * @package JBZoo\Composer\Cleanup
 */
class Rules
{
    /**
     * Rule list
     * @return array
     */
    public static function getRules()
    {
        // Default patterns for common files
        $docs = array(
            'LICENSE*',
            'README*',
            'readme*',
            'CHANGELOG*',
            'CHANGES*',
            'FAQ*',
            'CONTRIBUTING*',
            'HISTORY*',
            'UPGRADING*',
            'UPGRADE*',
            'package*',
            'demo',
            'example',
            'examples',
            'doc',
            'docs',
            'readme*',
        );

        $tests = array(
            '.travis.yml',
            '.scrutinizer.yml',
            '.codeclimate.yml',
            '.coveralls.yml',

            'phpunit.*',
            'phpunit-*',

            'test',
            'tests',
            'Tests',
            'example',
            'examples',
            '*.md',

            'travis',

            'demo.php',
            'test.php',
        );

        $system = array(
            '.gitignore',
            '.idea',
            '.git',
            '.gitattributes',
            '.phpstorm.meta.php',
            'composer.json'
        );

        return array(
            // JBZoo pack
            'jbzoo/assets'               => array($docs, $tests, $system),
            'jbzoo/console'              => array($docs, $tests, $system),
            'jbzoo/crosscms'             => array($docs, $tests, $system),
            'jbzoo/data'                 => array($docs, $tests, $system),
            'jbzoo/event'                => array($docs, $tests, $system),
            'jbzoo/html'                 => array($docs, $tests, $system),
            'jbzoo/image'                => array($docs, $tests, $system, ['build']),
            'jbzoo/lang'                 => array($docs, $tests, $system),
            'jbzoo/path'                 => array($docs, $tests, $system),
            'jbzoo/simpletypes'          => array($docs, $tests, $system),
            'jbzoo/sqlbuilder'           => array($docs, $tests, $system),
            'jbzoo/utils'                => array($docs, $tests, $system),

            'jbzoo/jbdump'               => array($docs, $tests, $system, [
                'joomla', 'logs', 'tools', '_template.php', 'favicon.ico', 'htaccess.example',
                'index.php', 'init.php.example', 'styles.less',
            ]),

            // Others
            'symfony/yaml'              => array($docs, $tests, $system),
            'symfony/css-selector'      => array($docs, $tests, $system),
            'symfony/polyfill-mbstring' => array($docs, $tests, $system),
            'symfony/process'           => array($docs, $tests, $system),
            'symfony/console'           => array($docs, $tests, $system),
             
            'oyejorge/less.php'          => array($docs, $tests, $system, ['bin']),
            'abeautifulsite/simpleimage' => array($docs, $tests, $system),
            'pimple/pimple'              => array($docs, $tests, $system, ['ext', 'src\\Pimple\\Tests']),

            // System
            'jbzoo/composer-cleanup'     => array($docs, $tests, $system),
        );
    }
}
