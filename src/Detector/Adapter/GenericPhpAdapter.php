<?php
/**
 * @package    CMSScanner
 * @copyright  Copyright (C) 2014 - 2019 CMS-Garden.org
 * @license    GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link       http://www.cms-garden.org
 */

namespace Cmsgarden\Cmsscanner\Detector\Adapter;

use Cmsgarden\Cmsscanner\Detector\System;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

/**
 * Class GenericPhpAdapter
 * @package Cmsgarden\Cmsscanner\Detector\Adapter
 *
 * @since   1.0.0
 */
class GenericPhpAdapter implements AdapterInterface
{
    /**
     * look for the index.php or index.html with a specific string in it
     *
     * @param   Finder  $finder  finder instance to append the criteria
     *
     * @return Finder
     */
    public function appendDetectionCriteria(Finder $finder)
    {
        $finder->name('*.php');

        return $finder;
    }

    /**
     * verify a search result by making sure that the file has the correct name and $version is in there
     *
     * @param   SplFileInfo  $file  file to examine
     *
     * @return  bool|System
     */
    public function detectSystem(SplFileInfo $file)
	{
		/*
        if ($file->getFilename() != "index.html") {
            return false;
        }
		if (stripos($file->getContents(), '<?php') !== false) {
			echo $file->getFileName() . 'does contain phpcode' . PHP_EOL;

            return false;
        }
		 */
        $path = new \SplFileInfo(dirname($file->getPath()));

        return new System($this->getName(), $path);
    }

    /**
     * determine version number
     *
     * @param   \SplFileInfo  $path  directory where the system is installed
     *
     * @return  null
     */
    public function detectVersion(\SplFileInfo $path)
    {
        return null;
    }

    /**
     * @InheritDoc
     */
    public function detectModules(\SplFileInfo $path)
    {
        // TODO implement this function
        return false;
    }

        /**
     * @return string
     */
    public function getName()
    {
        return 'Generic php';
    }
}
