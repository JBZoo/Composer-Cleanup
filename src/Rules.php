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
            'README*',
            'CHANGELOG*',
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

            'phpunit.xml*',
            'phpunit.php',

            'test',
            'tests',
            'Tests',

            'travis',

            'demo.php',
            'test.php',
        );

        $system = array(
            '.gitignore',
            '.idea',
            '.git',
        );

        return array(
            // JBZoo pack
            'jbzoo/data'        => array($docs, $tests, $system),
            'jbzoo/sqlbuilder'  => array($docs, $tests, $system),
            'jbzoo/simpletypes' => array($docs, $tests, $system),

            // Others
            'symfony/yaml'      => array($docs, $tests, $system),
        );
    }

}
