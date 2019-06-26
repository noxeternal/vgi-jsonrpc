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
use vgi\Value as ChildValue;
use vgi\ValueQuery as ChildValueQuery;
use vgi\Map\ValueTableMap;

/**
 * Base class that represents a query for the 'value' table.
 *
 *
 *
 * @method     ChildValueQuery orderByValId($order = Criteria::ASC) Order by the val_id column
 * @method     ChildValueQuery orderByItemId($order = Criteria::ASC) Order by the item_id column
 * @method     ChildValueQuery orderByAmount($order = Criteria::ASC) Order by the amount column
 * @method     ChildValueQuery orderByLastCheck($order = Criteria::ASC) Order by the last_check column
 *
 * @method     ChildValueQuery groupByValId() Group by the val_id column
 * @method     ChildValueQuery groupByItemId() Group by the item_id column
 * @method     ChildValueQuery groupByAmount() Group by the amount column
 * @method     ChildValueQuery groupByLastCheck() Group by the last_check column
 *
 * @method     ChildValueQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildValueQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildValueQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildValueQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildValueQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildValueQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildValueQuery leftJoin_ItemId($relationAlias = null) Adds a LEFT JOIN clause to the query using the _ItemId relation
 * @method     ChildValueQuery rightJoin_ItemId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the _ItemId relation
 * @method     ChildValueQuery innerJoin_ItemId($relationAlias = null) Adds a INNER JOIN clause to the query using the _ItemId relation
 *
 * @method     ChildValueQuery joinWith_ItemId($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the _ItemId relation
 *
 * @method     ChildValueQuery leftJoinWith_ItemId() Adds a LEFT JOIN clause and with to the query using the _ItemId relation
 * @method     ChildValueQuery rightJoinWith_ItemId() Adds a RIGHT JOIN clause and with to the query using the _ItemId relation
 * @method     ChildValueQuery innerJoinWith_ItemId() Adds a INNER JOIN clause and with to the query using the _ItemId relation
 *
 * @method     \vgi\ItemQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildValue findOne(ConnectionInterface $con = null) Return the first ChildValue matching the query
 * @method     ChildValue findOneOrCreate(ConnectionInterface $con = null) Return the first ChildValue matching the query, or a new ChildValue object populated from the query conditions when no match is found
 *
 * @method     ChildValue findOneByValId(int $val_id) Return the first ChildValue filtered by the val_id column
 * @method     ChildValue findOneByItemId(string $item_id) Return the first ChildValue filtered by the item_id column
 * @method     ChildValue findOneByAmount(string $amount) Return the first ChildValue filtered by the amount column
 * @method     ChildValue findOneByLastCheck(string $last_check) Return the first ChildValue filtered by the last_check column *

 * @method     ChildValue requirePk($key, ConnectionInterface $con = null) Return the ChildValue by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildValue requireOne(ConnectionInterface $con = null) Return the first ChildValue matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildValue requireOneByValId(int $val_id) Return the first ChildValue filtered by the val_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildValue requireOneByItemId(string $item_id) Return the first ChildValue filtered by the item_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildValue requireOneByAmount(string $amount) Return the first ChildValue filtered by the amount column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildValue requireOneByLastCheck(string $last_check) Return the first ChildValue filtered by the last_check column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildValue[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildValue objects based on current ModelCriteria
 * @method     ChildValue[]|ObjectCollection findByValId(int $val_id) Return ChildValue objects filtered by the val_id column
 * @method     ChildValue[]|ObjectCollection findByItemId(string $item_id) Return ChildValue objects filtered by the item_id column
 * @method     ChildValue[]|ObjectCollection findByAmount(string $amount) Return ChildValue objects filtered by the amount column
 * @method     ChildValue[]|ObjectCollection findByLastCheck(string $last_check) Return ChildValue objects filtered by the last_check column
 * @method     ChildValue[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ValueQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \vgi\Base\ValueQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\vgi\\Value', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildValueQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildValueQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildValueQuery) {
            return $criteria;
        }
        $query = new ChildValueQuery();
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
     * @return ChildValue|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ValueTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = ValueTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildValue A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT val_id, item_id, amount, last_check FROM value WHERE val_id = :p0';
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
            /** @var ChildValue $obj */
            $obj = new ChildValue();
            $obj->hydrate($row);
            ValueTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildValue|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildValueQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ValueTableMap::COL_VAL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildValueQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ValueTableMap::COL_VAL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the val_id column
     *
     * Example usage:
     * <code>
     * $query->filterByValId(1234); // WHERE val_id = 1234
     * $query->filterByValId(array(12, 34)); // WHERE val_id IN (12, 34)
     * $query->filterByValId(array('min' => 12)); // WHERE val_id > 12
     * </code>
     *
     * @param     mixed $valId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildValueQuery The current query, for fluid interface
     */
    public function filterByValId($valId = null, $comparison = null)
    {
        if (is_array($valId)) {
            $useMinMax = false;
            if (isset($valId['min'])) {
                $this->addUsingAlias(ValueTableMap::COL_VAL_ID, $valId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($valId['max'])) {
                $this->addUsingAlias(ValueTableMap::COL_VAL_ID, $valId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ValueTableMap::COL_VAL_ID, $valId, $comparison);
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
     * @see       filterBy_ItemId()
     *
     * @param     mixed $itemId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildValueQuery The current query, for fluid interface
     */
    public function filterByItemId($itemId = null, $comparison = null)
    {
        if (is_array($itemId)) {
            $useMinMax = false;
            if (isset($itemId['min'])) {
                $this->addUsingAlias(ValueTableMap::COL_ITEM_ID, $itemId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($itemId['max'])) {
                $this->addUsingAlias(ValueTableMap::COL_ITEM_ID, $itemId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ValueTableMap::COL_ITEM_ID, $itemId, $comparison);
    }

    /**
     * Filter the query on the amount column
     *
     * Example usage:
     * <code>
     * $query->filterByAmount(1234); // WHERE amount = 1234
     * $query->filterByAmount(array(12, 34)); // WHERE amount IN (12, 34)
     * $query->filterByAmount(array('min' => 12)); // WHERE amount > 12
     * </code>
     *
     * @param     mixed $amount The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildValueQuery The current query, for fluid interface
     */
    public function filterByAmount($amount = null, $comparison = null)
    {
        if (is_array($amount)) {
            $useMinMax = false;
            if (isset($amount['min'])) {
                $this->addUsingAlias(ValueTableMap::COL_AMOUNT, $amount['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($amount['max'])) {
                $this->addUsingAlias(ValueTableMap::COL_AMOUNT, $amount['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ValueTableMap::COL_AMOUNT, $amount, $comparison);
    }

    /**
     * Filter the query on the last_check column
     *
     * Example usage:
     * <code>
     * $query->filterByLastCheck('2011-03-14'); // WHERE last_check = '2011-03-14'
     * $query->filterByLastCheck('now'); // WHERE last_check = '2011-03-14'
     * $query->filterByLastCheck(array('max' => 'yesterday')); // WHERE last_check > '2011-03-13'
     * </code>
     *
     * @param     mixed $lastCheck The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildValueQuery The current query, for fluid interface
     */
    public function filterByLastCheck($lastCheck = null, $comparison = null)
    {
        if (is_array($lastCheck)) {
            $useMinMax = false;
            if (isset($lastCheck['min'])) {
                $this->addUsingAlias(ValueTableMap::COL_LAST_CHECK, $lastCheck['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($lastCheck['max'])) {
                $this->addUsingAlias(ValueTableMap::COL_LAST_CHECK, $lastCheck['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ValueTableMap::COL_LAST_CHECK, $lastCheck, $comparison);
    }

    /**
     * Filter the query by a related \vgi\Item object
     *
     * @param \vgi\Item|ObjectCollection $item The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildValueQuery The current query, for fluid interface
     */
    public function filterBy_ItemId($item, $comparison = null)
    {
        if ($item instanceof \vgi\Item) {
            return $this
                ->addUsingAlias(ValueTableMap::COL_ITEM_ID, $item->getItemId(), $comparison);
        } elseif ($item instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ValueTableMap::COL_ITEM_ID, $item->toKeyValue('PrimaryKey', 'ItemId'), $comparison);
        } else {
            throw new PropelException('filterBy_ItemId() only accepts arguments of type \vgi\Item or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the _ItemId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildValueQuery The current query, for fluid interface
     */
    public function join_ItemId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('_ItemId');

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
            $this->addJoinObject($join, '_ItemId');
        }

        return $this;
    }

    /**
     * Use the _ItemId relation Item object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \vgi\ItemQuery A secondary query class using the current class as primary query
     */
    public function use_ItemIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->join_ItemId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : '_ItemId', '\vgi\ItemQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildValue $value Object to remove from the list of results
     *
     * @return $this|ChildValueQuery The current query, for fluid interface
     */
    public function prune($value = null)
    {
        if ($value) {
            $this->addUsingAlias(ValueTableMap::COL_VAL_ID, $value->getValId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the value table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ValueTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ValueTableMap::clearInstancePool();
            ValueTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ValueTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ValueTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ValueTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ValueTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ValueQuery
