<?php

namespace vgi\Base;

use \Exception;
use \PDO;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use vgi\Extra as ChildExtra;
use vgi\ExtraArchive as ChildExtraArchive;
use vgi\ExtraQuery as ChildExtraQuery;
use vgi\Map\ExtraTableMap;

/**
 * Base class that represents a query for the 'extra' table.
 *
 *
 *
 * @method     ChildExtraQuery orderByExtraId($order = Criteria::ASC) Order by the extra_id column
 * @method     ChildExtraQuery orderByItemId($order = Criteria::ASC) Order by the item_id column
 * @method     ChildExtraQuery orderByText($order = Criteria::ASC) Order by the text column
 *
 * @method     ChildExtraQuery groupByExtraId() Group by the extra_id column
 * @method     ChildExtraQuery groupByItemId() Group by the item_id column
 * @method     ChildExtraQuery groupByText() Group by the text column
 *
 * @method     ChildExtraQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildExtraQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildExtraQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildExtraQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildExtraQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildExtraQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildExtraQuery leftJoinItemIdExtra($relationAlias = null) Adds a LEFT JOIN clause to the query using the ItemIdExtra relation
 * @method     ChildExtraQuery rightJoinItemIdExtra($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ItemIdExtra relation
 * @method     ChildExtraQuery innerJoinItemIdExtra($relationAlias = null) Adds a INNER JOIN clause to the query using the ItemIdExtra relation
 *
 * @method     ChildExtraQuery joinWithItemIdExtra($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the ItemIdExtra relation
 *
 * @method     ChildExtraQuery leftJoinWithItemIdExtra() Adds a LEFT JOIN clause and with to the query using the ItemIdExtra relation
 * @method     ChildExtraQuery rightJoinWithItemIdExtra() Adds a RIGHT JOIN clause and with to the query using the ItemIdExtra relation
 * @method     ChildExtraQuery innerJoinWithItemIdExtra() Adds a INNER JOIN clause and with to the query using the ItemIdExtra relation
 *
 * @method     \vgi\ItemQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildExtra findOne(ConnectionInterface $con = null) Return the first ChildExtra matching the query
 * @method     ChildExtra findOneOrCreate(ConnectionInterface $con = null) Return the first ChildExtra matching the query, or a new ChildExtra object populated from the query conditions when no match is found
 *
 * @method     ChildExtra findOneByExtraId(int $extra_id) Return the first ChildExtra filtered by the extra_id column
 * @method     ChildExtra findOneByItemId(string $item_id) Return the first ChildExtra filtered by the item_id column
 * @method     ChildExtra findOneByText(string $text) Return the first ChildExtra filtered by the text column *

 * @method     ChildExtra requirePk($key, ConnectionInterface $con = null) Return the ChildExtra by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildExtra requireOne(ConnectionInterface $con = null) Return the first ChildExtra matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildExtra requireOneByExtraId(int $extra_id) Return the first ChildExtra filtered by the extra_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildExtra requireOneByItemId(string $item_id) Return the first ChildExtra filtered by the item_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildExtra requireOneByText(string $text) Return the first ChildExtra filtered by the text column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildExtra[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildExtra objects based on current ModelCriteria
 * @method     ChildExtra[]|ObjectCollection findByExtraId(int $extra_id) Return ChildExtra objects filtered by the extra_id column
 * @method     ChildExtra[]|ObjectCollection findByItemId(string $item_id) Return ChildExtra objects filtered by the item_id column
 * @method     ChildExtra[]|ObjectCollection findByText(string $text) Return ChildExtra objects filtered by the text column
 * @method     ChildExtra[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ExtraQuery extends ModelCriteria
{

    // archivable behavior
    protected $archiveOnDelete = true;
protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \vgi\Base\ExtraQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\vgi\\Extra', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildExtraQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildExtraQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildExtraQuery) {
            return $criteria;
        }
        $query = new ChildExtraQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildExtra|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ExtraTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = ExtraTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
            // the object is already in the instance pool
            return $obj;
        }

        return $this->findPkSimple($key, $con);
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildExtra A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT extra_id, item_id, text FROM extra WHERE extra_id = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildExtra $obj */
            $obj = new ChildExtra();
            $obj->hydrate($row);
            ExtraTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildExtra|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildExtraQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ExtraTableMap::COL_EXTRA_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildExtraQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ExtraTableMap::COL_EXTRA_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the extra_id column
     *
     * Example usage:
     * <code>
     * $query->filterByExtraId(1234); // WHERE extra_id = 1234
     * $query->filterByExtraId(array(12, 34)); // WHERE extra_id IN (12, 34)
     * $query->filterByExtraId(array('min' => 12)); // WHERE extra_id > 12
     * </code>
     *
     * @param     mixed $extraId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildExtraQuery The current query, for fluid interface
     */
    public function filterByExtraId($extraId = null, $comparison = null)
    {
        if (is_array($extraId)) {
            $useMinMax = false;
            if (isset($extraId['min'])) {
                $this->addUsingAlias(ExtraTableMap::COL_EXTRA_ID, $extraId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($extraId['max'])) {
                $this->addUsingAlias(ExtraTableMap::COL_EXTRA_ID, $extraId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ExtraTableMap::COL_EXTRA_ID, $extraId, $comparison);
    }

    /**
     * Filter the query on the item_id column
     *
     * Example usage:
     * <code>
     * $query->filterByItemId(1234); // WHERE item_id = 1234
     * $query->filterByItemId(array(12, 34)); // WHERE item_id IN (12, 34)
     * $query->filterByItemId(array('min' => 12)); // WHERE item_id > 12
     * </code>
     *
     * @see       filterByItemIdExtra()
     *
     * @param     mixed $itemId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildExtraQuery The current query, for fluid interface
     */
    public function filterByItemId($itemId = null, $comparison = null)
    {
        if (is_array($itemId)) {
            $useMinMax = false;
            if (isset($itemId['min'])) {
                $this->addUsingAlias(ExtraTableMap::COL_ITEM_ID, $itemId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($itemId['max'])) {
                $this->addUsingAlias(ExtraTableMap::COL_ITEM_ID, $itemId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ExtraTableMap::COL_ITEM_ID, $itemId, $comparison);
    }

    /**
     * Filter the query on the text column
     *
     * Example usage:
     * <code>
     * $query->filterByText('fooValue');   // WHERE text = 'fooValue'
     * $query->filterByText('%fooValue%', Criteria::LIKE); // WHERE text LIKE '%fooValue%'
     * </code>
     *
     * @param     string $text The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildExtraQuery The current query, for fluid interface
     */
    public function filterByText($text = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($text)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ExtraTableMap::COL_TEXT, $text, $comparison);
    }

    /**
     * Filter the query by a related \vgi\Item object
     *
     * @param \vgi\Item|ObjectCollection $item The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildExtraQuery The current query, for fluid interface
     */
    public function filterByItemIdExtra($item, $comparison = null)
    {
        if ($item instanceof \vgi\Item) {
            return $this
                ->addUsingAlias(ExtraTableMap::COL_ITEM_ID, $item->getItemId(), $comparison);
        } elseif ($item instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ExtraTableMap::COL_ITEM_ID, $item->toKeyValue('PrimaryKey', 'ItemId'), $comparison);
        } else {
            throw new PropelException('filterByItemIdExtra() only accepts arguments of type \vgi\Item or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ItemIdExtra relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildExtraQuery The current query, for fluid interface
     */
    public function joinItemIdExtra($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ItemIdExtra');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'ItemIdExtra');
        }

        return $this;
    }

    /**
     * Use the ItemIdExtra relation Item object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \vgi\ItemQuery A secondary query class using the current class as primary query
     */
    public function useItemIdExtraQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinItemIdExtra($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ItemIdExtra', '\vgi\ItemQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildExtra $extra Object to remove from the list of results
     *
     * @return $this|ChildExtraQuery The current query, for fluid interface
     */
    public function prune($extra = null)
    {
        if ($extra) {
            $this->addUsingAlias(ExtraTableMap::COL_EXTRA_ID, $extra->getExtraId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Code to execute before every DELETE statement
     *
     * @param     ConnectionInterface $con The connection object used by the query
     */
    protected function basePreDelete(ConnectionInterface $con)
    {
        // archivable behavior

        if ($this->archiveOnDelete) {
            $this->archive($con);
        } else {
            $this->archiveOnDelete = true;
        }


        return $this->preDelete($con);
    }

    /**
     * Deletes all rows from the extra table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ExtraTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ExtraTableMap::clearInstancePool();
            ExtraTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ExtraTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ExtraTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ExtraTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ExtraTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // archivable behavior

    /**
     * Copy the data of the objects satisfying the query into ChildExtraArchive archive objects.
     * The archived objects are then saved.
     * If any of the objects has already been archived, the archived object
     * is updated and not duplicated.
     * Warning: This termination methods issues 2n+1 queries.
     *
     * @param      ConnectionInterface $con    Connection to use.
     * @param      Boolean $useLittleMemory    Whether or not to use OnDemandFormatter to retrieve objects.
     *               Set to false if the identity map matters.
     *               Set to true (default) to use less memory.
     *
     * @return     int the number of archived objects
     */
    public function archive($con = null, $useLittleMemory = true)
    {
        $criteria = clone $this;
        // prepare the query
        $criteria->setWith(array());
        if ($useLittleMemory) {
            $criteria->setFormatter(ModelCriteria::FORMAT_ON_DEMAND);
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(ExtraTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con, $criteria) {
            $totalArchivedObjects = 0;

            // archive all results one by one
            foreach ($criteria->find($con) as $object) {
                $object->archive($con);
                $totalArchivedObjects++;
            }

            return $totalArchivedObjects;
        });
    }

    /**
     * Enable/disable auto-archiving on delete for the next query.
     *
     * @param boolean True if the query must archive deleted objects, false otherwise.
     */
    public function setArchiveOnDelete($archiveOnDelete)
    {
        $this->archiveOnDelete = $archiveOnDelete;
    }

    /**
     * Delete records matching the current query without archiving them.
     *
     * @param      ConnectionInterface $con    Connection to use.
     *
     * @return integer the number of deleted rows
     */
    public function deleteWithoutArchive($con = null)
    {
        $this->archiveOnDelete = false;

        return $this->delete($con);
    }

    /**
     * Delete all records without archiving them.
     *
     * @param      ConnectionInterface $con    Connection to use.
     *
     * @return integer the number of deleted rows
     */
    public function deleteAllWithoutArchive($con = null)
    {
        $this->archiveOnDelete = false;

        return $this->deleteAll($con);
    }

} // ExtraQuery
