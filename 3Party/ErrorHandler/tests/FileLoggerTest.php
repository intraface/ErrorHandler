<?php
class FileErrorLoggerTestCase extends UnitTestCase {
var $_fh;
var $_test_file = ‘test.log’;
function setup() {
@unlink($this->_test_file);
$this->_fh = fopen($this->_test_file, ‘w’);
}
function TestRequiresFileHandleToInstantiate() { /* ... */ }
function TestWrite() {
$content = ‘test’.rand(10,100);
$log =& new FileErrorLogger($this->_fh);
The Observer Pattern 163
This copy is registered to Lars Olesen (lars@legestue.net) - Santa Monica, 90402, United States
$log->write($content);
$file_contents = file_get_contents($this->_test_file);
$this->assertWantedPattern(‘/’.$content.’$/’, $file_contents);
}
function TestWriteIsTimeStamped() { /* ... */ }
}
