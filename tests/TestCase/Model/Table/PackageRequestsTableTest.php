<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PackageRequestsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PackageRequestsTable Test Case
 */
class PackageRequestsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PackageRequestsTable
     */
    public $PackageRequests;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.PackageRequests',
        'app.Packages',
        'app.Users',
        'app.UserPackages',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('PackageRequests') ? [] : ['className' => PackageRequestsTable::class];
        $this->PackageRequests = TableRegistry::getTableLocator()->get('PackageRequests', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PackageRequests);

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
