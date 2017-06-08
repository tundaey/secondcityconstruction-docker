<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Test for PMA_getDbLink_test from Util.class.php
 *
 * @package PhpMyAdmin-test
 * @group common.lib-tests
 */

/*
 * Include to test.
 */
require_once 'libraries/core.lib.php';
require_once 'libraries/Util.class.php';
require_once 'libraries/url_generating.lib.php';
require_once 'libraries/php-gettext/gettext.inc';

/**
 * Test for PMA_getDbLink_test from Util.class.php
 *
 * @package PhpMyAdmin-test
 * @group common.lib-tests
 */
class PMA_GetDbLink_Test extends PHPUnit_Framework_TestCase
{
    /**
     * Set up
     *
     * @return void
     */
    function setUp()
    {
        global $cfg;
        include_once 'libraries/vendor_config.php';
        include 'libraries/config.default.php';
        $GLOBALS['server'] = 99;
    }

    /**
     * Test for getDbLink
     *
     * @return void
     *
     * @group medium
     */
    function testGetDbLinkEmpty()
    {
        $GLOBALS['db'] = null;
        $this->assertEmpty(PMA_Util::getDbLink());
    }

    /**
     * Test for getDbLink
     *
     * @return void
     *
     * @group medium
     */
    function testGetDbLinkNull()
    {
        global $cfg;
        $GLOBALS['db'] = 'test_db';
        $database = $GLOBALS['db'];
        $this->assertEquals(
            '<a href="'
            . PMA_Util::getScriptNameForOption(
                $GLOBALS['cfg']['DefaultTabDatabase'], 'database'
            )
            . '?db=' . $database
            . '&amp;server=99&amp;lang=en&amp;token=token" '
            . 'title="Jump to database &quot;'
            . htmlspecialchars($database) . '&quot;.">'
            . htmlspecialchars($database) . '</a>',
            PMA_Util::getDbLink()
        );
    }

    /**
     * Test for getDbLink
     *
     * @return void
     */
    function testGetDbLink()
    {
        global $cfg;
        $database = 'test_database';
        $this->assertEquals(
            '<a href="' . PMA_Util::getScriptNameForOption(
                $GLOBALS['cfg']['DefaultTabDatabase'], 'database'
            )
            . '?db=' . $database
            . '&amp;server=99&amp;lang=en&amp;token=token" title="Jump to database &quot;'
            . htmlspecialchars($database) . '&quot;.">'
            . htmlspecialchars($database) . '</a>',
            PMA_Util::getDbLink($database)
        );
    }

    /**
     * Test for getDbLink
     *
     * @return void
     */
    function testGetDbLinkWithSpecialChars()
    {
        global $cfg;
        $database = 'test&data\'base';
        $this->assertEquals(
            '<a href="'
            . PMA_Util::getScriptNameForOption(
                $GLOBALS['cfg']['DefaultTabDatabase'], 'database'
            )
            . '?db='
            . htmlspecialchars(urlencode($database))
            . '&amp;server=99&amp;lang=en&amp;token=token" title="Jump to database &quot;'
            . htmlspecialchars($database) . '&quot;.">'
            . htmlspecialchars($database) . '</a>',
            PMA_Util::getDbLink($database)
        );
    }
}
