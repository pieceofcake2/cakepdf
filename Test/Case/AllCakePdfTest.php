<?php

use PHPUnit\Framework\TestSuite;

class AllCakePdfTest extends TestSuite
{
    /**
     * Suite define the tests for this suite
     *
     * @return CakeTestSuite
     */
    public static function suite(): CakeTestSuite
    {
        $suite = new CakeTestSuite('All CakePdf tests');

        $path = CakePlugin::path('CakePdf') . 'Test' . DS . 'Case' . DS;
        $suite->addTestDirectoryRecursive($path);

        return $suite;
    }
}
