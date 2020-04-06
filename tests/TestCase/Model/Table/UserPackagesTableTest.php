<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UserPackagesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UserPackagesTable Test Case
 */
class UserPackagesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\UserPackagesTable
     */
    public $UserPackages;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.UserPackages',
        'app.Users',
        'app.Packages',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('UserPackages') ? [] : ['className' => UserPackagesTable::class];
        $this->UserPackages = TableRegistry::getTableLocator()->get('UserPackages', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->UserPackages);

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
