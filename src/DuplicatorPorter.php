<?php

   namespace Grayl\Input\Duplicator;

   use Grayl\Database\Main\DatabasePorter;
   use Grayl\Date\DatePorter;
   use Grayl\Input\Duplicator\Controller\DuplicatorController;
   use Grayl\Input\Duplicator\Entity\DuplicatorLog;
   use Grayl\Input\Duplicator\Service\DuplicatorService;
   use Grayl\Input\Duplicator\Storage\DuplicatorDatabaseMapper;
   use Grayl\Mixin\Common\Traits\StaticTrait;

   /**
    * Front-end for the Duplicator package
    *
    * @package Grayl\Input\Duplicator
    */
   class DuplicatorPorter
   {

      // Use the static instance trait
      use StaticTrait;

      /**
       * Creates a new DuplicatorController
       *
       * @param string  $tag  The general tag for the log
       * @param ?string $hash The unique hash string for the individual log (if blank, a new one is created)
       *
       * @return DuplicatorController
       * @throws \Exception
       */
      public function newDuplicatorController ( string $tag,
                                                ?string $hash ): DuplicatorController
      {

         // Grab the service
         $service = new DuplicatorService();

         // We need to create a hash if we weren't passed one
         if ( empty( $hash ) ) {
            // Create a hash
            $hash = $service->generateHash( 20 );
         }

         // Create a new DuplicatorLog
         $duplicator_log = new DuplicatorLog( DatePorter::getInstance()
                                                        ->newDateController( null ),
                                              $tag,
                                              $hash,
                                              $_SERVER[ 'REMOTE_ADDR' ] );

         // Return a new DuplicatorController
         return new DuplicatorController( $duplicator_log,
                                          $service,
                                          new DuplicatorDatabaseMapper( 'input_duplicator',
                                                                        DatabasePorter::getInstance() ) );
      }

   }