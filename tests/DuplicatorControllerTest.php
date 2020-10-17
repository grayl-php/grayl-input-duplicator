<?php

namespace Grayl\Test\Input;

use Grayl\Gateway\PDO\PDOPorter;
use Grayl\Input\Duplicator\Controller\DuplicatorController;
use Grayl\Input\Duplicator\DuplicatorPorter;
use Grayl\Input\Duplicator\Service\DuplicatorService;
use PHPUnit\Framework\TestCase;

/**
 * Test class for the Duplicator package
 *
 * @package Grayl\Input\Duplicator
 */
class DuplicatorControllerTest extends
    TestCase
{

    /**
     * Test setup for sandbox environment
     */
    public static function setUpBeforeClass(): void
    {

        // Change the PDO API environment to sandbox mode
        PDOPorter::getInstance()
            ->setEnvironment('sandbox');
    }


    /**
     * Tests the creation of a DuplicatorController object
     *
     * @return DuplicatorController
     * @throws \Exception
     */
    public function testCreateDuplicatorController(): DuplicatorController
    {

        // Set a unique tag
        $tag = "test_" . $this->generateRandomID();

        // Create a DuplicatorController
        $duplicator = DuplicatorPorter::getInstance()
            ->newDuplicatorController(
                $tag,
                null
            );

        // Check the type of object created
        $this->assertInstanceOf(
            DuplicatorController::class,
            $duplicator
        );

        // Return it
        return $duplicator;
    }


    /**
     * Tests a DuplicatorController that should pass with no duplication
     *
     * @param DuplicatorController $duplicator A DuplicatorController entity to test
     *
     * @depends testCreateDuplicatorController
     * @return DuplicatorController
     * @throws \Exception
     */
    public function testDuplicatorControllerSuccess(
        DuplicatorController $duplicator
    ): DuplicatorController {

        // Make sure the first check passes
        $this->assertFalse($duplicator->isDuplicateLog());

        // Insert the log
        $duplicator->saveDuplicatorLog();

        // Return the controller
        return $duplicator;
    }


    /**
     * Tests a DuplicatorController that should fail with duplication
     *
     * @param DuplicatorController $duplicator A DuplicatorController entity to test
     *
     * @depends testDuplicatorControllerSuccess
     * @throws \Exception
     */
    public function testDuplicatorControllerFailure(
        DuplicatorController $duplicator
    ): void {

        // Tell the tester we expect an exception to be thrown
        $this->expectException(\Exception::class);

        // Make sure the first check fails
        $this->assertTrue($duplicator->isDuplicateLog());

        // Insert the log, throwing an exception from duplication
        $duplicator->saveDuplicatorLog();
    }


    /**
     * Creates a random ID for tracking this unique test in the database
     */
    private function generateRandomID(): string
    {

        // Grab a new instance of the service
        $service = new DuplicatorService();

        // Return a random 6 character string
        return $service->generateHash(10);
    }

}
