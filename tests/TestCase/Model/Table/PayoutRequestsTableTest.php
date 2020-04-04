<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PayoutRequestsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PayoutRequestsTable Test Case
 */
class PayoutRequestsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PayoutRequestsTable
     */
    public $PayoutRequests;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.PayoutRequests',
        'app.Users',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('PayoutRequests') ? [] : ['className' => PayoutRequestsTable::class];
        $this->PayoutRequests = TableRegistry::getTableLocator()->get('PayoutRequests', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PayoutRequests);

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

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
