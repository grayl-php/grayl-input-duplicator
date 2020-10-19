<?php

   namespace Grayl\Input\Duplicator\Entity;

   use Grayl\Date\Controller\DateController;

   /**
    * Class DuplicatorLog
    * The entity for duplicator logs
    *
    * @package Grayl\Input\Duplicator
    */
   class DuplicatorLog
   {

      /**
       * The creation date of the log
       *
       * @var DateController
       */
      private DateController $created;

      /**
       * The general tag for the log
       *
       * @var string
       */
      private string $tag;

      /**
       * The unique hash string for the individual log
       *
       * @var string
       */
      private string $hash;

      /**
       * The IP address for the log
       *
       * @var string
       */
      private string $ip_address;


      /**
       * The class constructor
       *
       * @param DateController $created    The creation date of the log
       * @param string         $tag        The general tag for the log
       * @param string         $hash       The unique hash string for the individual log
       * @param string         $ip_address The IP address for the log
       */
      public function __construct ( DateController $created,
                                    string $tag,
                                    string $hash,
                                    string $ip_address )
      {

         // Set the class data
         $this->setCreated( $created );
         $this->setTag( $tag );
         $this->setHash( $hash );
         $this->setIPAddress( $ip_address );
      }


      /**
       * Gets the creation date
       *
       * @return DateController
       */
      public function getCreated (): DateController
      {

         // Return the DateController object
         return $this->created;
      }


      /**
       * Sets the creation date
       *
       * @param DateController $date The DateController object to set for creation
       */
      public function setCreated ( DateController $date ): void
      {

         // Set the created date
         $this->created = $date;
      }


      /**
       * Gets the tag
       *
       * @return string
       */
      public function getTag (): string
      {

         // Return the tag
         return $this->tag;
      }


      /**
       * Sets the tag
       *
       * @param string $tag The general tag for the log
       */
      public function setTag ( string $tag ): void
      {

         // Set the tag
         $this->tag = $tag;
      }


      /**
       * Gets the unique hash
       *
       * @return string
       */
      public function getHash (): string
      {

         // Return the hash
         return $this->hash;
      }


      /**
       * Sets the unique hash
       *
       * @param string $hash The unique hash string for the individual log
       */
      public function setHash ( string $hash ): void
      {

         // Set the hash
         $this->hash = $hash;
      }


      /**
       * Gets the IP address
       *
       * @return string
       */
      public function getIPAddress (): string
      {

         // Return the IP address
         return $this->ip_address;
      }


      /**
       * Sets the IP address for the log
       *
       * @param string $ip_address The IP address for the log
       */
      public function setIPAddress ( string $ip_address ): void
      {

         // Set the IP address
         $this->ip_address = $ip_address;
      }

   }