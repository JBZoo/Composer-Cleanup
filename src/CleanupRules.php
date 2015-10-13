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
        $docs  = 'README* CHANGELOG* FAQ* CONTRIBUTING* HISTORY* UPGRADING* UPGRADE* package* demo example examples doc docs readme*';
        $tests = '.travis.yml .scrutinizer.yml phpunit.xml* phpunit.php test tests Tests travis';

        return array(
            // JBZoo pack
            'jbzoo/data'        => array($docs, $tests),
            'jbzoo/sqlbuilder'  => array($docs, $tests),
            'jbzoo/simpletypes' => array($docs, $tests),

            // Others
            'symfony/yaml'      => array($docs, $tests),
        );
    }

}
