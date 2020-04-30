<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UserInvestmentsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UserInvestmentsTable Test Case
 */
class UserInvestmentsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\UserInvestmentsTable
     */
    public $UserInvestments;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.UserInvestments',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('UserInvestments') ? [] : ['className' => UserInvestmentsTable::class];
        $this->UserInvestments = TableRegistry::getTableLocator()->get('UserInvestments', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->UserInvestments);

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
