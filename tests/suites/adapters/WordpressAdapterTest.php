<?php
/**
 * @package    CMSScanner
 * @copyright  Copyright (C) 2014 CMS-Garden.org
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link       http://www.cms-garden.org
 */

namespace Cmsgarden\Cmsscanner\Tests\Adapters;

use Cmsgarden\Cmsscanner\Detector\Adapter\WordpressAdapter;
use Symfony\Component\Finder\Finder;

/**
 * Class WordpressAdapterTest
 * @package Cmsgarden\Cmsscanner\Tests\Adapters
 *
 * @since   1.0.0
 */
class WordpressAdapterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var WordpressAdapter
     */
    public $object;

    public function setUp()
    {
        $this->object = new WordpressAdapter();
    }

    public function testCorrectNameIsReturned()
    {
        $this->assertEquals('WordPress', $this->object->getName());
    }

    public function testSystemsAreDetected()
    {
        $finder = new Finder();
        $finder->files()->in(CMSSCANNER_MOCKFILES_PATH)
            ->name('dummy.php')
            ->name('version.php');

        $finder = $this->object->appendDetectionCriteria($finder);

        $results = array();
        $falseCount = 0;

        foreach ($finder as $file) {
            $system = $this->object->detectSystem($file);

            if ($system == false) {
                $falseCount++;
                continue;
            }

            $system->version = $this->object->detectVersion($system->getPath());

            // Append successful result to array
            $results[$system->version] = $system;
        }

        $this->assertCount(5, $results);
        $this->assertEquals(11, $falseCount);
        $this->assertArrayHasKey('', $results);
        $this->assertArrayHasKey('2.2.1', $results);
        $this->assertArrayHasKey('2.9', $results);
        $this->assertArrayHasKey('3.7.5', $results);
        $this->assertArrayHasKey('4.0', $results);
        $this->assertInstanceOf('Cmsgarden\Cmsscanner\Detector\System', current($results));
    }
}
