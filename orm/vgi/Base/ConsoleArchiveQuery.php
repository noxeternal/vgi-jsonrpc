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
use vgi\ConsoleArchive as ChildConsoleArchive;
use vgi\ConsoleArchiveQuery as ChildConsoleArchiveQuery;
use vgi\Map\ConsoleArchiveTableMap;

/**
 * Base class that represents a query for the 'console_archive' table.
 *
 *
 *
 * @method     ChildConsoleArchiveQuery orderByText($order = Criteria::ASC) Order by the text column
 * @method     ChildConsoleArchiveQuery orderByLink($order = Criteria::ASC) Order by the link column
 * @method     ChildConsoleArchiveQuery orderByOrderBy($order = Criteria::ASC) Order by the order_by column
 * @method     ChildConsoleArchiveQuery orderByArchivedAt($order = Criteria::ASC) Order by the archived_at column
 *
 * @method     ChildConsoleArchiveQuery groupByText() Group by the text column
 * @method     ChildConsoleArchiveQuery groupByLink() Group by the link column
 * @method     ChildConsoleArchiveQuery groupByOrderBy() Group by the order_by column
 * @method     ChildConsoleArchiveQuery groupByArchivedAt() Group by the archived_at column
 *
 * @method     ChildConsoleArchiveQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildConsoleArchiveQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildConsoleArchiveQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildConsoleArchiveQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildConsoleArchiveQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildConsoleArchiveQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildConsoleArchive findOne(ConnectionInterface $con = null) Return the first ChildConsoleArchive matching the query
 * @method     ChildConsoleArchive findOneOrCreate(ConnectionInterface $con = null) Return the first ChildConsoleArchive matching the query, or a new ChildConsoleArchive object populated from the query conditions when no match is found
 *
 * @method     ChildConsoleArchive findOneByText(string $text) Return the first ChildConsoleArchive filtered by the text column
 * @method     ChildConsoleArchive findOneByLink(string $link) Return the first ChildConsoleArchive filtered by the link column
 * @method     ChildConsoleArchive findOneByOrderBy(int $order_by) Return the first ChildConsoleArchive filtered by the order_by column
 * @method     ChildConsoleArchive findOneByArchivedAt(string $archived_at) Return the first ChildConsoleArchive filtered by the archived_at column *

 * @method     ChildConsoleArchive requirePk($key, ConnectionInterface $con = null) Return the ChildConsoleArchive by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildConsoleArchive requireOne(ConnectionInterface $con = null) Return the first ChildConsoleArchive matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildConsoleArchive requireOneByText(string $text) Return the first ChildConsoleArchive filtered by the text column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildConsoleArchive requireOneByLink(string $link) Return the first ChildConsoleArchive filtered by the link column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildConsoleArchive requireOneByOrderBy(int $order_by) Return the first ChildConsoleArchive filtered by the order_by column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildConsoleArchive requireOneByArchivedAt(string $archived_at) Return the first ChildConsoleArchive filtered by the archived_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildConsoleArchive[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildConsoleArchive objects based on current ModelCriteria
 * @method     ChildConsoleArchive[]|ObjectCollection findByText(string $text) Return ChildConsoleArchive objects filtered by the text column
 * @method     ChildConsoleArchive[]|ObjectCollection findByLink(string $link) Return ChildConsoleArchive objects filtered by the link column
 * @method     ChildConsoleArchive[]|ObjectCollection findByOrderBy(int $order_by) Return ChildConsoleArchive objects filtered by the order_by column
 * @method     ChildConsoleArchive[]|ObjectCollection findByArchivedAt(string $archived_at) Return ChildConsoleArchive objects filtered by the archived_at column
 * @method     ChildConsoleArchive[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ConsoleArchiveQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \vgi\Base\ConsoleArchiveQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\vgi\\ConsoleArchive', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildConsoleArchiveQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildConsoleArchiveQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildConsoleArchiveQuery) {
            return $criteria;
        }
        $query = new ChildConsoleArchiveQuery();
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
     * @return ChildConsoleArchive|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ConsoleArchiveTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = ConsoleArchiveTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildConsoleArchive A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT text, link, order_by, archived_at FROM console_archive WHERE text = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_STR);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildConsoleArchive $obj */
            $obj = new ChildConsoleArchive();
            $obj->hydrate($row);
            ConsoleArchiveTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildConsoleArchive|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildConsoleArchiveQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ConsoleArchiveTableMap::COL_TEXT, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildConsoleArchiveQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ConsoleArchiveTableMap::COL_TEXT, $keys, Criteria::IN);
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
     * @return $this|ChildConsoleArchiveQuery The current query, for fluid interface
     */
    public function filterByText($text = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($text)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ConsoleArchiveTableMap::COL_TEXT, $text, $comparison);
    }

    /**
     * Filter the query on the link column
     *
     * Example usage:
     * <code>
     * $query->filterByLink('fooValue');   // WHERE link = 'fooValue'
     * $query->filterByLink('%fooValue%', Criteria::LIKE); // WHERE link LIKE '%fooValue%'
     * </code>
     *
     * @param     string $link The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildConsoleArchiveQuery The current query, for fluid interface
     */
    public function filterByLink($link = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($link)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ConsoleArchiveTableMap::COL_LINK, $link, $comparison);
    }

    /**
     * Filter the query on the order_by column
     *
     * Example usage:
     * <code>
     * $query->filterByOrderBy(1234); // WHERE order_by = 1234
     * $query->filterByOrderBy(array(12, 34)); // WHERE order_by IN (12, 34)
     * $query->filterByOrderBy(array('min' => 12)); // WHERE order_by > 12
     * </code>
     *
     * @param     mixed $orderBy The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildConsoleArchiveQuery The current query, for fluid interface
     */
    public function filterByOrderBy($orderBy = null, $comparison = null)
    {
        if (is_array($orderBy)) {
            $useMinMax = false;
            if (isset($orderBy['min'])) {
                $this->addUsingAlias(ConsoleArchiveTableMap::COL_ORDER_BY, $orderBy['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($orderBy['max'])) {
                $this->addUsingAlias(ConsoleArchiveTableMap::COL_ORDER_BY, $orderBy['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ConsoleArchiveTableMap::COL_ORDER_BY, $orderBy, $comparison);
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
     * @return $this|ChildConsoleArchiveQuery The current query, for fluid interface
     */
    public function filterByArchivedAt($archivedAt = null, $comparison = null)
    {
        if (is_array($archivedAt)) {
            $useMinMax = false;
            if (isset($archivedAt['min'])) {
                $this->addUsingAlias(ConsoleArchiveTableMap::COL_ARCHIVED_AT, $archivedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($archivedAt['max'])) {
                $this->addUsingAlias(ConsoleArchiveTableMap::COL_ARCHIVED_AT, $archivedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ConsoleArchiveTableMap::COL_ARCHIVED_AT, $archivedAt, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildConsoleArchive $consoleArchive Object to remove from the list of results
     *
     * @return $this|ChildConsoleArchiveQuery The current query, for fluid interface
     */
    public function prune($consoleArchive = null)
    {
        if ($consoleArchive) {
            $this->addUsingAlias(ConsoleArchiveTableMap::COL_TEXT, $consoleArchive->getText(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the console_archive table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ConsoleArchiveTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ConsoleArchiveTableMap::clearInstancePool();
            ConsoleArchiveTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ConsoleArchiveTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ConsoleArchiveTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ConsoleArchiveTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ConsoleArchiveTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ConsoleArchiveQuery
