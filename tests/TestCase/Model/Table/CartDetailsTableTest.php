<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CartDetailsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CartDetailsTable Test Case
 */
class CartDetailsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CartDetailsTable
     */
    public $CartDetails;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.CartDetails',
        'app.Carts',
        'app.Products'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('CartDetails') ? [] : ['className' => CartDetailsTable::class];
        $this->CartDetails = TableRegistry::getTableLocator()->get('CartDetails', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CartDetails);

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
