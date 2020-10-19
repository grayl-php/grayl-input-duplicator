<?php

   namespace Grayl\Input\Duplicator\Service;

   /**
    * Class DuplicatorService
    * The service for working with duplicators
    *
    * @package Grayl\Input\Duplicator
    */
   class DuplicatorService
   {

      /**
       * Generates a unique duplicator hash
       *
       * @param int $length The length of the hash
       *
       * @return string
       */
      public function generateHash ( int $length ): string
      {

         // Generate a random string
         $hash = openssl_random_pseudo_bytes( $length );

         // Convert the binary data into hexadecimal representation and return it
         $hash = strtoupper( bin2hex( $hash ) );

         // Trim to length and return
         return substr( $hash,
                        0,
                        $length );
      }

   }