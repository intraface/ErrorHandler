<?php
class EmailErrorLoggerTestCase extends UnitTestCase {
function TestEmailAddressFirstConstructorParameter() {
$log =& new EmailErrorLogger;
$this->assertErrorPattern(‘/missing.*1/i’);
}
function TestMail() {
$log =& new EmailErrorLogger(‘jsweat_php@yahoo.com’);
$log->mail(‘test message’);
}
}