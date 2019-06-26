<?php

namespace vgi\Base;

use \Exception;
use \PDO;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use vgi\ExtraArchive as ChildExtraArchive;
use vgi\ExtraArchiveQuery as ChildExtraArchiveQuery;
use vgi\Map\ExtraArchiveTableMap;

/**
 * Base class that represents a query for the 'extra_archive' table.
 *
 *
 *
 * @method     ChildExtraArchiveQuery orderByExtraId($order = Criteria::ASC) Order by the extra_id column
 * @method     ChildExtraArchiveQuery orderByItemId($order = Criteria::ASC) Order by the item_id column
 * @method     ChildExtraArchiveQuery orderByText($order = Criteria::ASC) Order by the text column
 * @method     ChildExtraArchiveQuery orderByArchivedAt($order = Criteria::ASC) Order by the archived_at column
 *
 * @method     ChildExtraArchiveQuery groupByExtraId() Group by the extra_id column
 * @method     ChildExtraArchiveQuery groupByItemId() Group by the item_id column
 * @method     ChildExtraArchiveQuery groupByText() Group by the text column
 * @method     ChildExtraArchiveQuery groupByArchivedAt() Group by the archived_at column
 *
 * @method     ChildExtraArchiveQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildExtraArchiveQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildExtraArchiveQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildExtraArchiveQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildExtraArchiveQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildExtraArchiveQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildExtraArchive findOne(ConnectionInterface $con = null) Return the first ChildExtraArchive matching the query
 * @method     ChildExtraArchive findOneOrCreate(ConnectionInterface $con = null) Return the first ChildExtraArchive matching the query, or a new ChildExtraArchive object populated from the query conditions when no match is found
 *
 * @method     ChildExtraArchive findOneByExtraId(int $extra_id) Return the first ChildExtraArchive filtered by the extra_id column
 * @method     ChildExtraArchive findOneByItemId(string $item_id) Return the first ChildExtraArchive filtered by the item_id column
 * @method     ChildExtraArchive findOneByText(string $text) Return the first ChildExtraArchive filtered by the text column
 * @method     ChildExtraArchive findOneByArchivedAt(string $archived_at) Return the first ChildExtraArchive filtered by the archived_at column *

 * @method     ChildExtraArchive requirePk($key, ConnectionInterface $con = null) Return the ChildExtraArchive by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildExtraArchive requireOne(ConnectionInterface $con = null) Return the first ChildExtraArchive matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildExtraArchive requireOneByExtraId(int $extra_id) Return the first ChildExtraArchive filtered by the extra_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildExtraArchive requireOneByItemId(string $item_id) Return the first ChildExtraArchive filtered by the item_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildExtraArchive requireOneByText(string $text) Return the first ChildExtraArchive filtered by the text column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildExtraArchive requireOneByArchivedAt(string $archived_at) Return the first ChildExtraArchive filtered by the archived_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildExtraArchive[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildExtraArchive objects based on current ModelCriteria
 * @method     ChildExtraArchive[]|ObjectCollection findByExtraId(int $extra_id) Return ChildExtraArchive objects filtered by the extra_id column
 * @method     ChildExtraArchive[]|ObjectCollection findByItemId(string $item_id) Return ChildExtraArchive objects filtered by the item_id column
 * @method     ChildExtraArchive[]|ObjectCollection findByText(string $text) Return ChildExtraArchive objects filtered by the text column
 * @method     ChildExtraArchive[]|ObjectCollection findByArchivedAt(string $archived_at) Return ChildExtraArchive objects filtered by the archived_at column
 * @method     ChildExtraArchive[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ExtraArchiveQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \vgi\Base\ExtraArchiveQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\vgi\\ExtraArchive', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildExtraArchiveQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildExtraArchiveQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildExtraArchiveQuery) {
            return $criteria;
        }
        $query = new ChildExtraArchiveQuery();
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
     * @return ChildExtraArchive|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ExtraArchiveTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = ExtraArchiveTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildExtraArchive A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT extra_id, item_id, text, archived_at FROM extra_archive WHERE extra_id = :p0';
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
            /** @var ChildExtraArchive $obj */
            $obj = new ChildExtraArchive();
            $obj->hydrate($row);
            ExtraArchiveTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildExtraArchive|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildExtraArchiveQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ExtraArchiveTableMap::COL_EXTRA_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildExtraArchiveQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ExtraArchiveTableMap::COL_EXTRA_ID, $keys, Criteria::IN);
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
     * @return $this|ChildExtraArchiveQuery The current query, for fluid interface
     */
    public function filterByExtraId($extraId = null, $comparison = null)
    {
        if (is_array($extraId)) {
            $useMinMax = false;
            if (isset($extraId['min'])) {
                $this->addUsingAlias(ExtraArchiveTableMap::COL_EXTRA_ID, $extraId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($extraId['max'])) {
                $this->addUsingAlias(ExtraArchiveTableMap::COL_EXTRA_ID, $extraId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ExtraArchiveTableMap::COL_EXTRA_ID, $extraId, $comparison);
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
     * @param     mixed $itemId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildExtraArchiveQuery The current query, for fluid interface
     */
    public function filterByItemId($itemId = null, $comparison = null)
    {
        if (is_array($itemId)) {
            $useMinMax = false;
            if (isset($itemId['min'])) {
                $this->addUsingAlias(ExtraArchiveTableMap::COL_ITEM_ID, $itemId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($itemId['max'])) {
                $this->addUsingAlias(ExtraArchiveTableMap::COL_ITEM_ID, $itemId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ExtraArchiveTableMap::COL_ITEM_ID, $itemId, $comparison);
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
     * @return $this|ChildExtraArchiveQuery The current query, for fluid interface
     */
    public function filterByText($text = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($text)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ExtraArchiveTableMap::COL_TEXT, $text, $comparison);
    }

    /**
     * Filter the query on the archived_at column
     *
     * Example usage:
     * <code>
     * $query->filterByArchivedAt('2011-03-14'); // WHERE archived_at = '2011-03-14'
     * $query->filterByArchivedAt('now'); // WHERE archived_at = '2011-03-14'
     * $query->filterByArchivedAt(array('max' => 'yesterday')); // WHERE archived_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $archivedAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildExtraArchiveQuery The current query, for fluid interface
     */
    public function filterByArchivedAt($archivedAt = null, $comparison = null)
    {
        if (is_array($archivedAt)) {
            $useMinMax = false;
            if (isset($archivedAt['min'])) {
                $this->addUsingAlias(ExtraArchiveTableMap::COL_ARCHIVED_AT, $archivedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($archivedAt['max'])) {
                $this->addUsingAlias(ExtraArchiveTableMap::COL_ARCHIVED_AT, $archivedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ExtraArchiveTableMap::COL_ARCHIVED_AT, $archivedAt, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildExtraArchive $extraArchive Object to remove from the list of results
     *
     * @return $this|ChildExtraArchiveQuery The current query, for fluid interface
     */
    public function prune($extraArchive = null)
    {
        if ($extraArchive) {
            $this->addUsingAlias(ExtraArchiveTableMap::COL_EXTRA_ID, $extraArchive->getExtraId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the extra_archive table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ExtraArchiveTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ExtraArchiveTableMap::clearInstancePool();
            ExtraArchiveTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ExtraArchiveTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ExtraArchiveTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ExtraArchiveTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ExtraArchiveTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ExtraArchiveQuery
