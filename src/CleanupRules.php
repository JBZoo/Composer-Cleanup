<?php

namespace JBZoo\ComposerCleanup;

/**
 * Class CleanupRules
 * @package JBZoo\ComposerCleanup
 */
class CleanupRules
{
    public static function getRules()
    {
        // Default patterns for common files
        $removeList = implode(' ', array(
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
            '.travis.yml',
            '.scrutinizer.yml',
            'phpunit.xml*',
            'phpunit.php',
            'test',
            'tests',
            'Tests',
            'travis',
            '.codeclimate.yml',
            '.gitignore',
            'demo.php',
            'test.php',
        ));

        return array(
            // JBZoo pack
            'jbzoo/data'        => array($removeList),
            'jbzoo/sqlbuilder'  => array($removeList),
            'jbzoo/simpletypes' => array($removeList),

            // Others
            'symfony/yaml'      => array($removeList),
        );
    }

}
