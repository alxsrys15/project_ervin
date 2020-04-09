<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CaptchasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CaptchasTable Test Case
 */
class CaptchasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CaptchasTable
     */
    public $Captchas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Captchas',
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
        $config = TableRegistry::getTableLocator()->exists('Captchas') ? [] : ['className' => CaptchasTable::class];
        $this->Captchas = TableRegistry::getTableLocator()->get('Captchas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Captchas);

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
