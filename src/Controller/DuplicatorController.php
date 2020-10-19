<?php

   namespace Grayl\Input\Duplicator\Controller;

   use Grayl\Input\Duplicator\Entity\DuplicatorLog;
   use Grayl\Input\Duplicator\Service\DuplicatorService;
   use Grayl\Input\Duplicator\Storage\DuplicatorDatabaseMapper;

   /**
    * Class DuplicatorController
    * The controller for working with duplicators logs from the database
    *
    * @package Grayl\Input\Duplicator
    */
   class DuplicatorController
   {

      /**
       * The DuplicatorLog instance to interact with
       *
       * @var DuplicatorLog
       */
      private DuplicatorLog $duplicator_log;

      /**
       * The DuplicatorService instance to interact with
       *
       * @var DuplicatorService
       */
      private DuplicatorService $duplicator_service;

      /**
       * The DuplicatorDatabaseMapper instance to interact with
       *
       * @var DuplicatorDatabaseMapper
       */
      private DuplicatorDatabaseMapper $database_mapper;


      /**
       * The class constructor
       *
       * @param DuplicatorLog            $duplicator_log     The DuplicatorLog instance to work with
       * @param DuplicatorService        $duplicator_service The DuplicatorService instance to use
       * @param DuplicatorDatabaseMapper $database_mapper    The DuplicatorDatabaseMapper instance to interact with
       */
      public function __construct ( DuplicatorLog $duplicator_log,
                                    DuplicatorService $duplicator_service,
                                    DuplicatorDatabaseMapper $database_mapper )
      {

         // Set the class data
         $this->duplicator_log = $duplicator_log;

         // Set the service entity
         $this->duplicator_service = $duplicator_service;

         // Set the database mapper
         $this->database_mapper = $database_mapper;
      }


      /**
       * Checks the duplicator database for existing records using the current hash
       *
       * @return bool
       * @throws \Exception
       */
      public function isDuplicateLog (): bool
      {

         // Use the service to check for duplicates
         return $this->database_mapper->isDuplicateLog( $this->duplicator_log );
      }


      /**
       * Saves the current DuplicatorLog to the database if it isn't a duplicate
       *
       * @throws \Exception
       */
      public function saveDuplicatorLog (): void
      {

         // Use the service to save this log and perform a check
         $this->database_mapper->saveDuplicatorLog( $this->duplicator_log );
      }

   }