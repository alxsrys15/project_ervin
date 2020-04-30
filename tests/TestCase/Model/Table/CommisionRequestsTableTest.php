<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CommisionRequestsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CommisionRequestsTable Test Case
 */
class CommisionRequestsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CommisionRequestsTable
     */
    public $CommisionRequests;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.CommisionRequests',
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
        $config = TableRegistry::getTableLocator()->exists('CommisionRequests') ? [] : ['className' => CommisionRequestsTable::class];
        $this->CommisionRequests = TableRegistry::getTableLocator()->get('CommisionRequests', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CommisionRequests);

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
