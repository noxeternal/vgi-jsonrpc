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
use vgi\ItemArchive as ChildItemArchive;
use vgi\ItemArchiveQuery as ChildItemArchiveQuery;
use vgi\Map\ItemArchiveTableMap;

/**
 * Base class that represents a query for the 'item_archive' table.
 *
 *
 *
 * @method     ChildItemArchiveQuery orderByItemId($order = Criteria::ASC) Order by the item_id column
 * @method     ChildItemArchiveQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildItemArchiveQuery orderByLink($order = Criteria::ASC) Order by the link column
 * @method     ChildItemArchiveQuery orderByImageUrl($order = Criteria::ASC) Order by the image_url column
 * @method     ChildItemArchiveQuery orderByConsole($order = Criteria::ASC) Order by the console column
 * @method     ChildItemArchiveQuery orderByCategory($order = Criteria::ASC) Order by the category column
 * @method     ChildItemArchiveQuery orderByState($order = Criteria::ASC) Order by the state column
 * @method     ChildItemArchiveQuery orderByBox($order = Criteria::ASC) Order by the box column
 * @method     ChildItemArchiveQuery orderByManual($order = Criteria::ASC) Order by the manual column
 * @method     ChildItemArchiveQuery orderByStyle($order = Criteria::ASC) Order by the style column
 * @method     ChildItemArchiveQuery orderByArchivedAt($order = Criteria::ASC) Order by the archived_at column
 *
 * @method     ChildItemArchiveQuery groupByItemId() Group by the item_id column
 * @method     ChildItemArchiveQuery groupByName() Group by the name column
 * @method     ChildItemArchiveQuery groupByLink() Group by the link column
 * @method     ChildItemArchiveQuery groupByImageUrl() Group by the image_url column
 * @method     ChildItemArchiveQuery groupByConsole() Group by the console column
 * @method     ChildItemArchiveQuery groupByCategory() Group by the category column
 * @method     ChildItemArchiveQuery groupByState() Group by the state column
 * @method     ChildItemArchiveQuery groupByBox() Group by the box column
 * @method     ChildItemArchiveQuery groupByManual() Group by the manual column
 * @method     ChildItemArchiveQuery groupByStyle() Group by the style column
 * @method     ChildItemArchiveQuery groupByArchivedAt() Group by the archived_at column
 *
 * @method     ChildItemArchiveQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildItemArchiveQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildItemArchiveQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildItemArchiveQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildItemArchiveQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildItemArchiveQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildItemArchive findOne(ConnectionInterface $con = null) Return the first ChildItemArchive matching the query
 * @method     ChildItemArchive findOneOrCreate(ConnectionInterface $con = null) Return the first ChildItemArchive matching the query, or a new ChildItemArchive object populated from the query conditions when no match is found
 *
 * @method     ChildItemArchive findOneByItemId(string $item_id) Return the first ChildItemArchive filtered by the item_id column
 * @method     ChildItemArchive findOneByName(string $name) Return the first ChildItemArchive filtered by the name column
 * @method     ChildItemArchive findOneByLink(string $link) Return the first ChildItemArchive filtered by the link column
 * @method     ChildItemArchive findOneByImageUrl(string $image_url) Return the first ChildItemArchive filtered by the image_url column
 * @method     ChildItemArchive findOneByConsole(string $console) Return the first ChildItemArchive filtered by the console column
 * @method     ChildItemArchive findOneByCategory(string $category) Return the first ChildItemArchive filtered by the category column
 * @method     ChildItemArchive findOneByState(string $state) Return the first ChildItemArchive filtered by the state column
 * @method     ChildItemArchive findOneByBox(boolean $box) Return the first ChildItemArchive filtered by the box column
 * @method     ChildItemArchive findOneByManual(boolean $manual) Return the first ChildItemArchive filtered by the manual column
 * @method     ChildItemArchive findOneByStyle(string $style) Return the first ChildItemArchive filtered by the style column
 * @method     ChildItemArchive findOneByArchivedAt(string $archived_at) Return the first ChildItemArchive filtered by the archived_at column *

 * @method     ChildItemArchive requirePk($key, ConnectionInterface $con = null) Return the ChildItemArchive by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItemArchive requireOne(ConnectionInterface $con = null) Return the first ChildItemArchive matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildItemArchive requireOneByItemId(string $item_id) Return the first ChildItemArchive filtered by the item_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItemArchive requireOneByName(string $name) Return the first ChildItemArchive filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItemArchive requireOneByLink(string $link) Return the first ChildItemArchive filtered by the link column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItemArchive requireOneByImageUrl(string $image_url) Return the first ChildItemArchive filtered by the image_url column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItemArchive requireOneByConsole(string $console) Return the first ChildItemArchive filtered by the console column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItemArchive requireOneByCategory(string $category) Return the first ChildItemArchive filtered by the category column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItemArchive requireOneByState(string $state) Return the first ChildItemArchive filtered by the state column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItemArchive requireOneByBox(boolean $box) Return the first ChildItemArchive filtered by the box column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItemArchive requireOneByManual(boolean $manual) Return the first ChildItemArchive filtered by the manual column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItemArchive requireOneByStyle(string $style) Return the first ChildItemArchive filtered by the style column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItemArchive requireOneByArchivedAt(string $archived_at) Return the first ChildItemArchive filtered by the archived_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildItemArchive[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildItemArchive objects based on current ModelCriteria
 * @method     ChildItemArchive[]|ObjectCollection findByItemId(string $item_id) Return ChildItemArchive objects filtered by the item_id column
 * @method     ChildItemArchive[]|ObjectCollection findByName(string $name) Return ChildItemArchive objects filtered by the name column
 * @method     ChildItemArchive[]|ObjectCollection findByLink(string $link) Return ChildItemArchive objects filtered by the link column
 * @method     ChildItemArchive[]|ObjectCollection findByImageUrl(string $image_url) Return ChildItemArchive objects filtered by the image_url column
 * @method     ChildItemArchive[]|ObjectCollection findByConsole(string $console) Return ChildItemArchive objects filtered by the console column
 * @method     ChildItemArchive[]|ObjectCollection findByCategory(string $category) Return ChildItemArchive objects filtered by the category column
 * @method     ChildItemArchive[]|ObjectCollection findByState(string $state) Return ChildItemArchive objects filtered by the state column
 * @method     ChildItemArchive[]|ObjectCollection findByBox(boolean $box) Return ChildItemArchive objects filtered by the box column
 * @method     ChildItemArchive[]|ObjectCollection findByManual(boolean $manual) Return ChildItemArchive objects filtered by the manual column
 * @method     ChildItemArchive[]|ObjectCollection findByStyle(string $style) Return ChildItemArchive objects filtered by the style column
 * @method     ChildItemArchive[]|ObjectCollection findByArchivedAt(string $archived_at) Return ChildItemArchive objects filtered by the archived_at column
 * @method     ChildItemArchive[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ItemArchiveQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \vgi\Base\ItemArchiveQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\vgi\\ItemArchive', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildItemArchiveQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildItemArchiveQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildItemArchiveQuery) {
            return $criteria;
        }
        $query = new ChildItemArchiveQuery();
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
     * @return ChildItemArchive|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ItemArchiveTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = ItemArchiveTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildItemArchive A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT item_id, name, link, image_url, console, category, state, box, manual, style, archived_at FROM item_archive WHERE item_id = :p0';
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
            /** @var ChildItemArchive $obj */
            $obj = new ChildItemArchive();
            $obj->hydrate($row);
            ItemArchiveTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildItemArchive|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildItemArchiveQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ItemArchiveTableMap::COL_ITEM_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildItemArchiveQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ItemArchiveTableMap::COL_ITEM_ID, $keys, Criteria::IN);
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
     * @return $this|ChildItemArchiveQuery The current query, for fluid interface
     */
    public function filterByItemId($itemId = null, $comparison = null)
    {
        if (is_array($itemId)) {
            $useMinMax = false;
            if (isset($itemId['min'])) {
                $this->addUsingAlias(ItemArchiveTableMap::COL_ITEM_ID, $itemId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($itemId['max'])) {
                $this->addUsingAlias(ItemArchiveTableMap::COL_ITEM_ID, $itemId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemArchiveTableMap::COL_ITEM_ID, $itemId, $comparison);
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%', Criteria::LIKE); // WHERE name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemArchiveQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemArchiveTableMap::COL_NAME, $name, $comparison);
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
     * @return $this|ChildItemArchiveQuery The current query, for fluid interface
     */
    public function filterByLink($link = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($link)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemArchiveTableMap::COL_LINK, $link, $comparison);
    }

    /**
     * Filter the query on the image_url column
     *
     * Example usage:
     * <code>
     * $query->filterByImageUrl('fooValue');   // WHERE image_url = 'fooValue'
     * $query->filterByImageUrl('%fooValue%', Criteria::LIKE); // WHERE image_url LIKE '%fooValue%'
     * </code>
     *
     * @param     string $imageUrl The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemArchiveQuery The current query, for fluid interface
     */
    public function filterByImageUrl($imageUrl = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($imageUrl)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemArchiveTableMap::COL_IMAGE_URL, $imageUrl, $comparison);
    }

    /**
     * Filter the query on the console column
     *
     * Example usage:
     * <code>
     * $query->filterByConsole('fooValue');   // WHERE console = 'fooValue'
     * $query->filterByConsole('%fooValue%', Criteria::LIKE); // WHERE console LIKE '%fooValue%'
     * </code>
     *
     * @param     string $console The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemArchiveQuery The current query, for fluid interface
     */
    public function filterByConsole($console = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($console)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemArchiveTableMap::COL_CONSOLE, $console, $comparison);
    }

    /**
     * Filter the query on the category column
     *
     * Example usage:
     * <code>
     * $query->filterByCategory('fooValue');   // WHERE category = 'fooValue'
     * $query->filterByCategory('%fooValue%', Criteria::LIKE); // WHERE category LIKE '%fooValue%'
     * </code>
     *
     * @param     string $category The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemArchiveQuery The current query, for fluid interface
     */
    public function filterByCategory($category = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($category)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemArchiveTableMap::COL_CATEGORY, $category, $comparison);
    }

    /**
     * Filter the query on the state column
     *
     * Example usage:
     * <code>
     * $query->filterByState('fooValue');   // WHERE state = 'fooValue'
     * $query->filterByState('%fooValue%', Criteria::LIKE); // WHERE state LIKE '%fooValue%'
     * </code>
     *
     * @param     string $state The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemArchiveQuery The current query, for fluid interface
     */
    public function filterByState($state = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($state)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemArchiveTableMap::COL_STATE, $state, $comparison);
    }

    /**
     * Filter the query on the box column
     *
     * Example usage:
     * <code>
     * $query->filterByBox(true); // WHERE box = true
     * $query->filterByBox('yes'); // WHERE box = true
     * </code>
     *
     * @param     boolean|string $box The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemArchiveQuery The current query, for fluid interface
     */
    public function filterByBox($box = null, $comparison = null)
    {
        if (is_string($box)) {
            $box = in_array(strtolower($box), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(ItemArchiveTableMap::COL_BOX, $box, $comparison);
    }

    /**
     * Filter the query on the manual column
     *
     * Example usage:
     * <code>
     * $query->filterByManual(true); // WHERE manual = true
     * $query->filterByManual('yes'); // WHERE manual = true
     * </code>
     *
     * @param     boolean|string $manual The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemArchiveQuery The current query, for fluid interface
     */
    public function filterByManual($manual = null, $comparison = null)
    {
        if (is_string($manual)) {
            $manual = in_array(strtolower($manual), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(ItemArchiveTableMap::COL_MANUAL, $manual, $comparison);
    }

    /**
     * Filter the query on the style column
     *
     * Example usage:
     * <code>
     * $query->filterByStyle('fooValue');   // WHERE style = 'fooValue'
     * $query->filterByStyle('%fooValue%', Criteria::LIKE); // WHERE style LIKE '%fooValue%'
     * </code>
     *
     * @param     string $style The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildItemArchiveQuery The current query, for fluid interface
     */
    public function filterByStyle($style = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($style)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemArchiveTableMap::COL_STYLE, $style, $comparison);
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
     * @return $this|ChildItemArchiveQuery The current query, for fluid interface
     */
    public function filterByArchivedAt($archivedAt = null, $comparison = null)
    {
        if (is_array($archivedAt)) {
            $useMinMax = false;
            if (isset($archivedAt['min'])) {
                $this->addUsingAlias(ItemArchiveTableMap::COL_ARCHIVED_AT, $archivedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($archivedAt['max'])) {
                $this->addUsingAlias(ItemArchiveTableMap::COL_ARCHIVED_AT, $archivedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemArchiveTableMap::COL_ARCHIVED_AT, $archivedAt, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildItemArchive $itemArchive Object to remove from the list of results
     *
     * @return $this|ChildItemArchiveQuery The current query, for fluid interface
     */
    public function prune($itemArchive = null)
    {
        if ($itemArchive) {
            $this->addUsingAlias(ItemArchiveTableMap::COL_ITEM_ID, $itemArchive->getItemId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the item_archive table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ItemArchiveTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ItemArchiveTableMap::clearInstancePool();
            ItemArchiveTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ItemArchiveTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ItemArchiveTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ItemArchiveTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ItemArchiveTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ItemArchiveQuery
