<?php

namespace Grayl\Input\Duplicator\Storage;

use Grayl\Database\Main\DatabasePorter;
use Grayl\Input\Duplicator\Entity\DuplicatorLog;

/**
 * Class DuplicatorDatabaseMapper
 * The interface for finding duplicator logs in the MySQL database and turning them into objects
 *
 * @package Grayl\Input\Duplicator
 */
class DuplicatorDatabaseMapper
{

    /**
     * The name of the database table to query
     *
     * @var string
     */
    private string $table;

    /**
     * A fully configured DatabasePorter
     *
     * @var DatabasePorter
     */
    private DatabasePorter $database_porter;


    /**
     * The class constructor
     *
     * @param string         $table           The name of the database table to query
     * @param DatabasePorter $database_porter A fully configured DatabasePorter
     */
    public function __construct(
        string $table,
        DatabasePorter $database_porter
    ) {

        // Set the database table to query
        $this->table = $table;

        // Set the DatabasePorter
        $this->database_porter = $database_porter;
    }


    /**
     * Returns the number of DuplicatorLogs found in a database matching the one provided
     *
     * @param DuplicatorLog $duplicator_log The DuplicatorLog entity to use for the search
     *
     * @return int
     * @throws \Exception
     */
    public function countMatchingDuplicatorLogs(DuplicatorLog $duplicator_log
    ): int {

        // Get a new SelectDatabaseController
        $request = $this->database_porter->newSelectDatabaseController(
            'default'
        );

        // Build the query
        $request->getQueryController()
            ->select(['*'])
            ->from($this->table)
            ->where(
                'tag',
                '=',
                $duplicator_log->getTag()
            )
            ->andWhere(
                'hash',
                '=',
                $duplicator_log->getHash()
            )
            ->andWhere(
                'ip_address',
                '=',
                $duplicator_log->getIPAddress()
            );

        // Run it and get the result
        $result = $request->runQuery();

        // Return the row count
        return $result->countRows();
    }


    /**
     * Checks the duplicator database for existing records using the current hash
     *
     * @param DuplicatorLog $duplicator_log The DuplicatorLog entity to use for the search
     *
     * @return bool
     * @throws \Exception
     */
    public function isDuplicateLog(DuplicatorLog $duplicator_log): bool
    {

        // Look for a duplicate hash, area, and IP already in the database
        if ($this->countMatchingDuplicatorLogs($duplicator_log) > 0) {
            // Duplicate log found
            return true;
        }

        // No duplicate found
        return false;
    }


    /**
     * Inserts a populated DuplicatorLog entry into the database
     *
     * @param DuplicatorLog $duplicator_log A populated DuplicatorLog object to save to the database
     *
     * @return int
     * @throws \Exception
     */
    public function saveDuplicatorLog(DuplicatorLog $duplicator_log): int
    {

        // If this is a duplicate
        if ($this->isDuplicateLog($duplicator_log)) {
            // Throw an exception
            throw new \Exception('Duplicate submission found.');
            // Otherwise log the search
        } else {
            // Insert the log
            return $this->insertDuplicatorLog($duplicator_log);
        }
    }


    /**
     * Inserts a populated DuplicatorLog entry into the database
     *
     * @param DuplicatorLog $duplicator_log A populated DuplicatorLog object to save to the database
     *
     * @return int
     * @throws \Exception
     */
    private function insertDuplicatorLog(DuplicatorLog $duplicator_log): int
    {

        // Get a new InsertDatabaseController
        $request = $this->database_porter->newInsertDatabaseController(
            'default'
        );

        // Build the query
        $request->getQueryController()
            ->insert(
                [
                    'created'    => $duplicator_log->getCreated()
                        ->getDateAsString(),
                    'tag'        => $duplicator_log->getTag(),
                    'hash'       => $duplicator_log->getHash(),
                    'ip_address' => $duplicator_log->getIPAddress(),
                ]
            )
            ->into($this->table);

        // Run it and get the result
        $result = $request->runQuery();

        // Return the ID of the inserted data
        return $result->getReferenceID();
    }

}