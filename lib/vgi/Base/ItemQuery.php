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
use vgi\Item as ChildItem;
use vgi\ItemArchive as ChildItemArchive;
use vgi\ItemQuery as ChildItemQuery;
use vgi\Map\ItemTableMap;

/**
 * Base class that represents a query for the 'item' table.
 *
 *
 *
 * @method     ChildItemQuery orderByItemId($order = Criteria::ASC) Order by the item_id column
 * @method     ChildItemQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildItemQuery orderByLink($order = Criteria::ASC) Order by the link column
 * @method     ChildItemQuery orderByImageUrl($order = Criteria::ASC) Order by the image_url column
 * @method     ChildItemQuery orderByConsole($order = Criteria::ASC) Order by the console column
 * @method     ChildItemQuery orderByCategory($order = Criteria::ASC) Order by the category column
 * @method     ChildItemQuery orderByState($order = Criteria::ASC) Order by the state column
 * @method     ChildItemQuery orderByBox($order = Criteria::ASC) Order by the box column
 * @method     ChildItemQuery orderByManual($order = Criteria::ASC) Order by the manual column
 * @method     ChildItemQuery orderByStyle($order = Criteria::ASC) Order by the style column
 *
 * @method     ChildItemQuery groupByItemId() Group by the item_id column
 * @method     ChildItemQuery groupByName() Group by the name column
 * @method     ChildItemQuery groupByLink() Group by the link column
 * @method     ChildItemQuery groupByImageUrl() Group by the image_url column
 * @method     ChildItemQuery groupByConsole() Group by the console column
 * @method     ChildItemQuery groupByCategory() Group by the category column
 * @method     ChildItemQuery groupByState() Group by the state column
 * @method     ChildItemQuery groupByBox() Group by the box column
 * @method     ChildItemQuery groupByManual() Group by the manual column
 * @method     ChildItemQuery groupByStyle() Group by the style column
 *
 * @method     ChildItemQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildItemQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildItemQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildItemQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildItemQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildItemQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildItemQuery leftJoin_Console($relationAlias = null) Adds a LEFT JOIN clause to the query using the _Console relation
 * @method     ChildItemQuery rightJoin_Console($relationAlias = null) Adds a RIGHT JOIN clause to the query using the _Console relation
 * @method     ChildItemQuery innerJoin_Console($relationAlias = null) Adds a INNER JOIN clause to the query using the _Console relation
 *
 * @method     ChildItemQuery joinWith_Console($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the _Console relation
 *
 * @method     ChildItemQuery leftJoinWith_Console() Adds a LEFT JOIN clause and with to the query using the _Console relation
 * @method     ChildItemQuery rightJoinWith_Console() Adds a RIGHT JOIN clause and with to the query using the _Console relation
 * @method     ChildItemQuery innerJoinWith_Console() Adds a INNER JOIN clause and with to the query using the _Console relation
 *
 * @method     ChildItemQuery leftJoin_Category($relationAlias = null) Adds a LEFT JOIN clause to the query using the _Category relation
 * @method     ChildItemQuery rightJoin_Category($relationAlias = null) Adds a RIGHT JOIN clause to the query using the _Category relation
 * @method     ChildItemQuery innerJoin_Category($relationAlias = null) Adds a INNER JOIN clause to the query using the _Category relation
 *
 * @method     ChildItemQuery joinWith_Category($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the _Category relation
 *
 * @method     ChildItemQuery leftJoinWith_Category() Adds a LEFT JOIN clause and with to the query using the _Category relation
 * @method     ChildItemQuery rightJoinWith_Category() Adds a RIGHT JOIN clause and with to the query using the _Category relation
 * @method     ChildItemQuery innerJoinWith_Category() Adds a INNER JOIN clause and with to the query using the _Category relation
 *
 * @method     ChildItemQuery leftJoin_State($relationAlias = null) Adds a LEFT JOIN clause to the query using the _State relation
 * @method     ChildItemQuery rightJoin_State($relationAlias = null) Adds a RIGHT JOIN clause to the query using the _State relation
 * @method     ChildItemQuery innerJoin_State($relationAlias = null) Adds a INNER JOIN clause to the query using the _State relation
 *
 * @method     ChildItemQuery joinWith_State($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the _State relation
 *
 * @method     ChildItemQuery leftJoinWith_State() Adds a LEFT JOIN clause and with to the query using the _State relation
 * @method     ChildItemQuery rightJoinWith_State() Adds a RIGHT JOIN clause and with to the query using the _State relation
 * @method     ChildItemQuery innerJoinWith_State() Adds a INNER JOIN clause and with to the query using the _State relation
 *
 * @method     ChildItemQuery leftJoin_Style($relationAlias = null) Adds a LEFT JOIN clause to the query using the _Style relation
 * @method     ChildItemQuery rightJoin_Style($relationAlias = null) Adds a RIGHT JOIN clause to the query using the _Style relation
 * @method     ChildItemQuery innerJoin_Style($relationAlias = null) Adds a INNER JOIN clause to the query using the _Style relation
 *
 * @method     ChildItemQuery joinWith_Style($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the _Style relation
 *
 * @method     ChildItemQuery leftJoinWith_Style() Adds a LEFT JOIN clause and with to the query using the _Style relation
 * @method     ChildItemQuery rightJoinWith_Style() Adds a RIGHT JOIN clause and with to the query using the _Style relation
 * @method     ChildItemQuery innerJoinWith_Style() Adds a INNER JOIN clause and with to the query using the _Style relation
 *
 * @method     ChildItemQuery leftJoinExtra($relationAlias = null) Adds a LEFT JOIN clause to the query using the Extra relation
 * @method     ChildItemQuery rightJoinExtra($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Extra relation
 * @method     ChildItemQuery innerJoinExtra($relationAlias = null) Adds a INNER JOIN clause to the query using the Extra relation
 *
 * @method     ChildItemQuery joinWithExtra($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Extra relation
 *
 * @method     ChildItemQuery leftJoinWithExtra() Adds a LEFT JOIN clause and with to the query using the Extra relation
 * @method     ChildItemQuery rightJoinWithExtra() Adds a RIGHT JOIN clause and with to the query using the Extra relation
 * @method     ChildItemQuery innerJoinWithExtra() Adds a INNER JOIN clause and with to the query using the Extra relation
 *
 * @method     ChildItemQuery leftJoinPriceList($relationAlias = null) Adds a LEFT JOIN clause to the query using the PriceList relation
 * @method     ChildItemQuery rightJoinPriceList($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PriceList relation
 * @method     ChildItemQuery innerJoinPriceList($relationAlias = null) Adds a INNER JOIN clause to the query using the PriceList relation
 *
 * @method     ChildItemQuery joinWithPriceList($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the PriceList relation
 *
 * @method     ChildItemQuery leftJoinWithPriceList() Adds a LEFT JOIN clause and with to the query using the PriceList relation
 * @method     ChildItemQuery rightJoinWithPriceList() Adds a RIGHT JOIN clause and with to the query using the PriceList relation
 * @method     ChildItemQuery innerJoinWithPriceList() Adds a INNER JOIN clause and with to the query using the PriceList relation
 *
 * @method     \vgi\ConsoleQuery|\vgi\CategoryQuery|\vgi\StateQuery|\vgi\StyleQuery|\vgi\ExtraQuery|\vgi\PriceListQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildItem findOne(ConnectionInterface $con = null) Return the first ChildItem matching the query
 * @method     ChildItem findOneOrCreate(ConnectionInterface $con = null) Return the first ChildItem matching the query, or a new ChildItem object populated from the query conditions when no match is found
 *
 * @method     ChildItem findOneByItemId(string $item_id) Return the first ChildItem filtered by the item_id column
 * @method     ChildItem findOneByName(string $name) Return the first ChildItem filtered by the name column
 * @method     ChildItem findOneByLink(string $link) Return the first ChildItem filtered by the link column
 * @method     ChildItem findOneByImageUrl(string $image_url) Return the first ChildItem filtered by the image_url column
 * @method     ChildItem findOneByConsole(string $console) Return the first ChildItem filtered by the console column
 * @method     ChildItem findOneByCategory(string $category) Return the first ChildItem filtered by the category column
 * @method     ChildItem findOneByState(string $state) Return the first ChildItem filtered by the state column
 * @method     ChildItem findOneByBox(boolean $box) Return the first ChildItem filtered by the box column
 * @method     ChildItem findOneByManual(boolean $manual) Return the first ChildItem filtered by the manual column
 * @method     ChildItem findOneByStyle(string $style) Return the first ChildItem filtered by the style column *

 * @method     ChildItem requirePk($key, ConnectionInterface $con = null) Return the ChildItem by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItem requireOne(ConnectionInterface $con = null) Return the first ChildItem matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildItem requireOneByItemId(string $item_id) Return the first ChildItem filtered by the item_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItem requireOneByName(string $name) Return the first ChildItem filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItem requireOneByLink(string $link) Return the first ChildItem filtered by the link column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItem requireOneByImageUrl(string $image_url) Return the first ChildItem filtered by the image_url column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItem requireOneByConsole(string $console) Return the first ChildItem filtered by the console column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItem requireOneByCategory(string $category) Return the first ChildItem filtered by the category column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItem requireOneByState(string $state) Return the first ChildItem filtered by the state column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItem requireOneByBox(boolean $box) Return the first ChildItem filtered by the box column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItem requireOneByManual(boolean $manual) Return the first ChildItem filtered by the manual column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildItem requireOneByStyle(string $style) Return the first ChildItem filtered by the style column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildItem[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildItem objects based on current ModelCriteria
 * @method     ChildItem[]|ObjectCollection findByItemId(string $item_id) Return ChildItem objects filtered by the item_id column
 * @method     ChildItem[]|ObjectCollection findByName(string $name) Return ChildItem objects filtered by the name column
 * @method     ChildItem[]|ObjectCollection findByLink(string $link) Return ChildItem objects filtered by the link column
 * @method     ChildItem[]|ObjectCollection findByImageUrl(string $image_url) Return ChildItem objects filtered by the image_url column
 * @method     ChildItem[]|ObjectCollection findByConsole(string $console) Return ChildItem objects filtered by the console column
 * @method     ChildItem[]|ObjectCollection findByCategory(string $category) Return ChildItem objects filtered by the category column
 * @method     ChildItem[]|ObjectCollection findByState(string $state) Return ChildItem objects filtered by the state column
 * @method     ChildItem[]|ObjectCollection findByBox(boolean $box) Return ChildItem objects filtered by the box column
 * @method     ChildItem[]|ObjectCollection findByManual(boolean $manual) Return ChildItem objects filtered by the manual column
 * @method     ChildItem[]|ObjectCollection findByStyle(string $style) Return ChildItem objects filtered by the style column
 * @method     ChildItem[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ItemQuery extends ModelCriteria
{

    // archivable behavior
    protected $archiveOnDelete = true;
protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \vgi\Base\ItemQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\vgi\\Item', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildItemQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildItemQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildItemQuery) {
            return $criteria;
        }
        $query = new ChildItemQuery();
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
     * @return ChildItem|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ItemTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = ItemTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildItem A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT item_id, name, link, image_url, console, category, state, box, manual, style FROM item WHERE item_id = :p0';
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
            /** @var ChildItem $obj */
            $obj = new ChildItem();
            $obj->hydrate($row);
            ItemTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildItem|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ItemTableMap::COL_ITEM_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ItemTableMap::COL_ITEM_ID, $keys, Criteria::IN);
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
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function filterByItemId($itemId = null, $comparison = null)
    {
        if (is_array($itemId)) {
            $useMinMax = false;
            if (isset($itemId['min'])) {
                $this->addUsingAlias(ItemTableMap::COL_ITEM_ID, $itemId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($itemId['max'])) {
                $this->addUsingAlias(ItemTableMap::COL_ITEM_ID, $itemId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemTableMap::COL_ITEM_ID, $itemId, $comparison);
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
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemTableMap::COL_NAME, $name, $comparison);
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
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function filterByLink($link = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($link)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemTableMap::COL_LINK, $link, $comparison);
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
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function filterByImageUrl($imageUrl = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($imageUrl)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemTableMap::COL_IMAGE_URL, $imageUrl, $comparison);
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
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function filterByConsole($console = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($console)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemTableMap::COL_CONSOLE, $console, $comparison);
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
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function filterByCategory($category = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($category)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemTableMap::COL_CATEGORY, $category, $comparison);
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
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function filterByState($state = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($state)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemTableMap::COL_STATE, $state, $comparison);
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
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function filterByBox($box = null, $comparison = null)
    {
        if (is_string($box)) {
            $box = in_array(strtolower($box), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(ItemTableMap::COL_BOX, $box, $comparison);
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
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function filterByManual($manual = null, $comparison = null)
    {
        if (is_string($manual)) {
            $manual = in_array(strtolower($manual), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(ItemTableMap::COL_MANUAL, $manual, $comparison);
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
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function filterByStyle($style = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($style)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ItemTableMap::COL_STYLE, $style, $comparison);
    }

    /**
     * Filter the query by a related \vgi\Console object
     *
     * @param \vgi\Console|ObjectCollection $console The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildItemQuery The current query, for fluid interface
     */
    public function filterBy_Console($console, $comparison = null)
    {
        if ($console instanceof \vgi\Console) {
            return $this
                ->addUsingAlias(ItemTableMap::COL_CONSOLE, $console->getText(), $comparison);
        } elseif ($console instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ItemTableMap::COL_CONSOLE, $console->toKeyValue('PrimaryKey', 'Text'), $comparison);
        } else {
            throw new PropelException('filterBy_Console() only accepts arguments of type \vgi\Console or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the _Console relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function join_Console($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('_Console');

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
            $this->addJoinObject($join, '_Console');
        }

        return $this;
    }

    /**
     * Use the _Console relation Console object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \vgi\ConsoleQuery A secondary query class using the current class as primary query
     */
    public function use_ConsoleQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->join_Console($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : '_Console', '\vgi\ConsoleQuery');
    }

    /**
     * Filter the query by a related \vgi\Category object
     *
     * @param \vgi\Category|ObjectCollection $category The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildItemQuery The current query, for fluid interface
     */
    public function filterBy_Category($category, $comparison = null)
    {
        if ($category instanceof \vgi\Category) {
            return $this
                ->addUsingAlias(ItemTableMap::COL_CATEGORY, $category->getText(), $comparison);
        } elseif ($category instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ItemTableMap::COL_CATEGORY, $category->toKeyValue('PrimaryKey', 'Text'), $comparison);
        } else {
            throw new PropelException('filterBy_Category() only accepts arguments of type \vgi\Category or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the _Category relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function join_Category($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('_Category');

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
            $this->addJoinObject($join, '_Category');
        }

        return $this;
    }

    /**
     * Use the _Category relation Category object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \vgi\CategoryQuery A secondary query class using the current class as primary query
     */
    public function use_CategoryQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->join_Category($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : '_Category', '\vgi\CategoryQuery');
    }

    /**
     * Filter the query by a related \vgi\State object
     *
     * @param \vgi\State|ObjectCollection $state The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildItemQuery The current query, for fluid interface
     */
    public function filterBy_State($state, $comparison = null)
    {
        if ($state instanceof \vgi\State) {
            return $this
                ->addUsingAlias(ItemTableMap::COL_STATE, $state->getText(), $comparison);
        } elseif ($state instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ItemTableMap::COL_STATE, $state->toKeyValue('PrimaryKey', 'Text'), $comparison);
        } else {
            throw new PropelException('filterBy_State() only accepts arguments of type \vgi\State or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the _State relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function join_State($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('_State');

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
            $this->addJoinObject($join, '_State');
        }

        return $this;
    }

    /**
     * Use the _State relation State object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \vgi\StateQuery A secondary query class using the current class as primary query
     */
    public function use_StateQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->join_State($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : '_State', '\vgi\StateQuery');
    }

    /**
     * Filter the query by a related \vgi\Style object
     *
     * @param \vgi\Style|ObjectCollection $style The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildItemQuery The current query, for fluid interface
     */
    public function filterBy_Style($style, $comparison = null)
    {
        if ($style instanceof \vgi\Style) {
            return $this
                ->addUsingAlias(ItemTableMap::COL_STYLE, $style->getName(), $comparison);
        } elseif ($style instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ItemTableMap::COL_STYLE, $style->toKeyValue('PrimaryKey', 'Name'), $comparison);
        } else {
            throw new PropelException('filterBy_Style() only accepts arguments of type \vgi\Style or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the _Style relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function join_Style($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('_Style');

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
            $this->addJoinObject($join, '_Style');
        }

        return $this;
    }

    /**
     * Use the _Style relation Style object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \vgi\StyleQuery A secondary query class using the current class as primary query
     */
    public function use_StyleQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->join_Style($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : '_Style', '\vgi\StyleQuery');
    }

    /**
     * Filter the query by a related \vgi\Extra object
     *
     * @param \vgi\Extra|ObjectCollection $extra the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildItemQuery The current query, for fluid interface
     */
    public function filterByExtra($extra, $comparison = null)
    {
        if ($extra instanceof \vgi\Extra) {
            return $this
                ->addUsingAlias(ItemTableMap::COL_ITEM_ID, $extra->getItemId(), $comparison);
        } elseif ($extra instanceof ObjectCollection) {
            return $this
                ->useExtraQuery()
                ->filterByPrimaryKeys($extra->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByExtra() only accepts arguments of type \vgi\Extra or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Extra relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function joinExtra($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Extra');

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
            $this->addJoinObject($join, 'Extra');
        }

        return $this;
    }

    /**
     * Use the Extra relation Extra object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \vgi\ExtraQuery A secondary query class using the current class as primary query
     */
    public function useExtraQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinExtra($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Extra', '\vgi\ExtraQuery');
    }

    /**
     * Filter the query by a related \vgi\PriceList object
     *
     * @param \vgi\PriceList|ObjectCollection $priceList the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildItemQuery The current query, for fluid interface
     */
    public function filterByPriceList($priceList, $comparison = null)
    {
        if ($priceList instanceof \vgi\PriceList) {
            return $this
                ->addUsingAlias(ItemTableMap::COL_ITEM_ID, $priceList->getItemId(), $comparison);
        } elseif ($priceList instanceof ObjectCollection) {
            return $this
                ->usePriceListQuery()
                ->filterByPrimaryKeys($priceList->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPriceList() only accepts arguments of type \vgi\PriceList or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PriceList relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function joinPriceList($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PriceList');

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
            $this->addJoinObject($join, 'PriceList');
        }

        return $this;
    }

    /**
     * Use the PriceList relation PriceList object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \vgi\PriceListQuery A secondary query class using the current class as primary query
     */
    public function usePriceListQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPriceList($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PriceList', '\vgi\PriceListQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildItem $item Object to remove from the list of results
     *
     * @return $this|ChildItemQuery The current query, for fluid interface
     */
    public function prune($item = null)
    {
        if ($item) {
            $this->addUsingAlias(ItemTableMap::COL_ITEM_ID, $item->getItemId(), Criteria::NOT_EQUAL);
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
     * Deletes all rows from the item table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ItemTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ItemTableMap::clearInstancePool();
            ItemTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ItemTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ItemTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ItemTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ItemTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // archivable behavior

    /**
     * Copy the data of the objects satisfying the query into ChildItemArchive archive objects.
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
            $con = Propel::getServiceContainer()->getWriteConnection(ItemTableMap::DATABASE_NAME);
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

} // ItemQuery
