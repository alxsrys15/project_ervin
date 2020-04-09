<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CaptchaPayoutsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CaptchaPayoutsTable Test Case
 */
class CaptchaPayoutsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CaptchaPayoutsTable
     */
    public $CaptchaPayouts;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.CaptchaPayouts',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('CaptchaPayouts') ? [] : ['className' => CaptchaPayoutsTable::class];
        $this->CaptchaPayouts = TableRegistry::getTableLocator()->get('CaptchaPayouts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CaptchaPayouts);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
