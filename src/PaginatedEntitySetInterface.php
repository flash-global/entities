<?php
    
    namespace Fei\Entity;


    /**
     * Interface PaginatedEntitySetInterface
     *
     * @package Fei\Entity
     */
    interface PaginatedEntitySetInterface
    {
        /**
         * @return int
         */
        public function getCurrentPage();

        /**
         * @return int
         */
        public function getTotal();

        /**
         * @return int
         */
        public function getPerPage();
    }
