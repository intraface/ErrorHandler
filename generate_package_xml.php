<?php
/**
 * package.xml generation script
 *
 * @category ErrorHandling
 * @package  ErrorHandler
 * @author   Lars Olesen <lars@legestue.net>
 * @license  BSD license
 * @version  @package-version@
 */

$version = '0.2.1';
$notes = '* initial release as a PEAR package';
$stability = 'alpha';

require_once 'PEAR/PackageFileManager2.php';
PEAR::setErrorHandling(PEAR_ERROR_DIE);
$pfm = new PEAR_PackageFileManager2();
$pfm->setOptions(
    array(
        'baseinstalldir'    => 'ErrorHandler',
        'filelistgenerator' => 'file',
        'packagedirectory'  => dirname(__FILE__),
        'packagefile'       => 'package.xml',
        'ignore'            => array(
            'generate_package_xml.php',
            'package.xml',
            '*.tgz'
            ),
        'exceptions'        => array(),
        'simpleoutput'      => true,
    )
);

$pfm->setPackage('ErrorHandler');
$pfm->setSummary('Custom error handler to use with php5');
$pfm->setDescription('A custom error handler which improves on PHPs own error handler.');
$pfm->setUri('http://localhost/');
$pfm->setLicense('BSD license', 'http://www.opensource.org/licenses/bsd-license.php');

$pfm->addMaintainer('lead', 'lsolesen', 'Lars Olesen', 'lars@legestue.net');
$pfm->addMaintainer('lead', 'sune', 'Sune Jensen', 'sj@sunet.dk');

$pfm->setPackageType('php');

$pfm->setAPIVersion($version);
$pfm->setReleaseVersion($version);
$pfm->setAPIStability($stability);
$pfm->setReleaseStability($stability);
$pfm->setNotes($notes);
$pfm->addRelease();

$pfm->addGlobalReplacement('package-info', '@package-version@', 'version');

$pfm->clearDeps();
$pfm->setPhpDep('5.1.0');
$pfm->setPearinstallerDep('1.5.0');

$pfm->generateContents();

if (isset($_GET['make']) || (isset($_SERVER['argv']) && @$_SERVER['argv'][1] == 'make')) {
    if ($pfm->writePackageFile()) {
        exit('package written');
    }
} else {
    $pfm->debugPackageFile();
}
?>