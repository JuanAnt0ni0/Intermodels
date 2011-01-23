<?php
/**
 * Neo Library
 *
 * @category   Neo
 * @package    Doctrine
 * @subpackage Paginator
 * @copyright  Copyright (c) 2010 Neozeratul
 * @license    http://www.opensource.org/licenses/bsd-license.php       New BSD License
 */

/**
 * @see Zend_Paginator_Adapter_Interface
 */
require_once 'Zend/Paginator/Adapter/Interface.php';




/**
 * Doctrine's adapter for Zend_Paginator.
 * It takes Doctrine_Query object or Dql query in constructor.
 *
 * @package Doctrine
 * @subpackage Paginator
 */
class Neo_Doctrine_Paginator_Adapter implements Zend_Paginator_Adapter_Interface
{
        /**
         * Doctrine's selection for paginator.
         *
         * @var Doctrine_Query
         */
        private $_query;
        /**
         * Doctrine's selection for count of items.
         *
         * @var Doctrine_Query
         */
        private $_countQuery = null;
        /**
         * Hydration mode for doctrine select query.
         *
         * @var integer
         */
        private $_hydrationMode = null;

        /**
         * Constructs Neo_Doctrine_Paginator_Adapter
         *
         * @param Doctrine_Query_Abstract|string $query
         * @param integer $hydratationMode Use constaints Doctrine_Core::HYDRATE_*.
         * @param array[string]=>mixed $options Options may be:
         *              'countQuery'-custom query for count counting. Dql or Doctrine_Query instance.
         */
        public function __construct($query, $hydrationMode = null, $options = array())
        {
                if ( is_string($query) ) {
                        $newQuery = new Doctrine_Query();
                        $newQuery->parseDqlQuery($query);
                        $query = $newQuery;
                }
                else if ( ! ($query instanceof Doctrine_Query_Abstract) ) {
                        require_once 'Neo/Doctrine/Paginator/Adapter/Exception.php';
                        throw new Neo_Doctrine_Paginator_Adapter_Exception("Given query is not instance of Doctrine_Query");
                }
                $this->_query = $query;
                $this->_hydrationMode = (is_null($hydrationMode)) ? Doctrine_Core::HYDRATE_RECORD : $hydrationMode ;

                //options
                if ( !empty($options['countQuery']) ) {
                        if ( is_string($options['countQuery']) ) {
                                $countQuery = new Doctrine_Query();
                                $countQuery->parseDqlQuery($options['countQuery']);
                                $options['countQuery'] = $countQuery;
                        }
                        else if ( ! ($options['countQuery'] instanceof Doctrine_Query) ) {
                                require_once 'Neo/Doctrine/Paginator/Adapter/Exception.php';
                                throw new Neo_Doctrine_Paginator_Adapter_Exception("Given count-query is not instance of Doctrine_Query");
                        }
                        $this->_countQuery = $options['countQuery'];
                        $this->_countQuery->select('count(*) as count');
                }
        }

        /**
         * Returns query for count of items.
         *
         * @return Doctrine_Query
         */
        protected function getCountQuery()
        {
                if ( $this->_countQuery == null ) {
                        $this->_countQuery = clone $this->_query;

                        $partsToBeRemoved = array('offset','limit','orderby');
                        foreach( $partsToBeRemoved as $part ) {
                                $this->_countQuery->removeDqlQueryPart($part);
                                $this->_countQuery->removeSqlQueryPart($part);
                        }
                }
                return $this->_countQuery;
        }

        /**
         * Implementation of method from Zend_Paginator_Adapter_Interface.
         *
         * @return integer
         */
        public function count()
        {
//                $result = $this->getCountQuery()->execute(array(), Doctrine_Core::HYDRATE_ARRAY);
                $result = $this->getCountQuery()->count();
                return $result;
        }

        /**
         * Implementation of method from Zend_Paginator_Adapter_Interface.
         *
         * @param integer $offset
         * @param integer $itemsPerPage
         * @return array[numeric|whatever]=>array|Doctrine_Record
         */
        public function getItems($offset, $itemsPerPage)
        {
                $this->_query->limit($itemsPerPage);
                $this->_query->offset($offset);
                $result = $this->_query->execute(array(), $this->_hydrationMode);
                return $result;
        }
}