<?php
/**
 * All Purifiable plugin tests
 */
class AllPurifiableTest extends CakeTestCase {

/**
 * Suite define the tests for this suite
 *
 * @return void
 */
    public static function suite() {
        $suite = new CakeTestSuite('All Purifiable test');

        $path = CakePlugin::path('Purifiable') . 'Test' . DS . 'Case' . DS;
        $suite->addTestDirectoryRecursive($path);

        return $suite;
    }

}
