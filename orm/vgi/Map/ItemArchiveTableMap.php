<?php

namespace vgi\Map;

use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;
use vgi\ItemArchive;
use vgi\ItemArchiveQuery;


/**
 * This class defines the structure of the 'item_archive' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class ItemArchiveTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'vgi.Map.ItemArchiveTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'item_archive';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\vgi\\ItemArchive';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'vgi.ItemArchive';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 11;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 11;

    /**
     * the column name for the item_id field
     */
    const COL_ITEM_ID = 'item_archive.item_id';

    /**
     * the column name for the name field
     */
    const COL_NAME = 'item_archive.name';

    /**
     * the column name for the link field
     */
    const COL_LINK = 'item_archive.link';

    /**
     * the column name for the image_url field
     */
    const COL_IMAGE_URL = 'item_archive.image_url';

    /**
     * the column name for the console field
     */
    const COL_CONSOLE = 'item_archive.console';

    /**
     * the column name for the category field
     */
    const COL_CATEGORY = 'item_archive.category';

    /**
     * the column name for the state field
     */
    const COL_STATE = 'item_archive.state';

    /**
     * the column name for the box field
     */
    const COL_BOX = 'item_archive.box';

    /**
     * the column name for the manual field
     */
    const COL_MANUAL = 'item_archive.manual';

    /**
     * the column name for the style field
     */
    const COL_STYLE = 'item_archive.style';

    /**
     * the column name for the archived_at field
     */
    const COL_ARCHIVED_AT = 'item_archive.archived_at';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('ItemId', 'Name', 'Link', 'ImageUrl', 'Console', 'Category', 'State', 'Box', 'Manual', 'Style', 'ArchivedAt', ),
        self::TYPE_CAMELNAME     => array('itemId', 'name', 'link', 'imageUrl', 'console', 'category', 'state', 'box', 'manual', 'style', 'archivedAt', ),
        self::TYPE_COLNAME       => array(ItemArchiveTableMap::COL_ITEM_ID, ItemArchiveTableMap::COL_NAME, ItemArchiveTableMap::COL_LINK, ItemArchiveTableMap::COL_IMAGE_URL, ItemArchiveTableMap::COL_CONSOLE, ItemArchiveTableMap::COL_CATEGORY, ItemArchiveTableMap::COL_STATE, ItemArchiveTableMap::COL_BOX, ItemArchiveTableMap::COL_MANUAL, ItemArchiveTableMap::COL_STYLE, ItemArchiveTableMap::COL_ARCHIVED_AT, ),
        self::TYPE_FIELDNAME     => array('item_id', 'name', 'link', 'image_url', 'console', 'category', 'state', 'box', 'manual', 'style', 'archived_at', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('ItemId' => 0, 'Name' => 1, 'Link' => 2, 'ImageUrl' => 3, 'Console' => 4, 'Category' => 5, 'State' => 6, 'Box' => 7, 'Manual' => 8, 'Style' => 9, 'ArchivedAt' => 10, ),
        self::TYPE_CAMELNAME     => array('itemId' => 0, 'name' => 1, 'link' => 2, 'imageUrl' => 3, 'console' => 4, 'category' => 5, 'state' => 6, 'box' => 7, 'manual' => 8, 'style' => 9, 'archivedAt' => 10, ),
        self::TYPE_COLNAME       => array(ItemArchiveTableMap::COL_ITEM_ID => 0, ItemArchiveTableMap::COL_NAME => 1, ItemArchiveTableMap::COL_LINK => 2, ItemArchiveTableMap::COL_IMAGE_URL => 3, ItemArchiveTableMap::COL_CONSOLE => 4, ItemArchiveTableMap::COL_CATEGORY => 5, ItemArchiveTableMap::COL_STATE => 6, ItemArchiveTableMap::COL_BOX => 7, ItemArchiveTableMap::COL_MANUAL => 8, ItemArchiveTableMap::COL_STYLE => 9, ItemArchiveTableMap::COL_ARCHIVED_AT => 10, ),
        self::TYPE_FIELDNAME     => array('item_id' => 0, 'name' => 1, 'link' => 2, 'image_url' => 3, 'console' => 4, 'category' => 5, 'state' => 6, 'box' => 7, 'manual' => 8, 'style' => 9, 'archived_at' => 10, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('item_archive');
        $this->setPhpName('ItemArchive');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\vgi\\ItemArchive');
        $this->setPackage('vgi');
        $this->setUseIdGenerator(false);
        // columns
        $this->addPrimaryKey('item_id', 'ItemId', 'BIGINT', true, null, null);
        $this->addColumn('name', 'Name', 'VARCHAR', true, 255, null);
        $this->addColumn('link', 'Link', 'VARCHAR', true, 75, '');
        $this->addColumn('image_url', 'ImageUrl', 'VARCHAR', true, 255, '');
        $this->addColumn('console', 'Console', 'VARCHAR', true, 75, null);
        $this->addColumn('category', 'Category', 'VARCHAR', true, 50, null);
        $this->addColumn('state', 'State', 'VARCHAR', true, 50, null);
        $this->addColumn('box', 'Box', 'BOOLEAN', true, 1, false);
        $this->addColumn('manual', 'Manual', 'BOOLEAN', true, 1, false);
        $this->addColumn('style', 'Style', 'VARCHAR', true, 50, '');
        $this->addColumn('archived_at', 'ArchivedAt', 'TIMESTAMP', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
    } // buildRelations()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('ItemId', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('ItemId', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('ItemId', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('ItemId', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('ItemId', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('ItemId', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        return (string) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('ItemId', TableMap::TYPE_PHPNAME, $indexType)
        ];
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? ItemArchiveTableMap::CLASS_DEFAULT : ItemArchiveTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (ItemArchive object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = ItemArchiveTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = ItemArchiveTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + ItemArchiveTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = ItemArchiveTableMap::OM_CLASS;
            /** @var ItemArchive $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            ItemArchiveTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = ItemArchiveTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = ItemArchiveTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var ItemArchive $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                ItemArchiveTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(ItemArchiveTableMap::COL_ITEM_ID);
            $criteria->addSelectColumn(ItemArchiveTableMap::COL_NAME);
            $criteria->addSelectColumn(ItemArchiveTableMap::COL_LINK);
            $criteria->addSelectColumn(ItemArchiveTableMap::COL_IMAGE_URL);
            $criteria->addSelectColumn(ItemArchiveTableMap::COL_CONSOLE);
            $criteria->addSelectColumn(ItemArchiveTableMap::COL_CATEGORY);
            $criteria->addSelectColumn(ItemArchiveTableMap::COL_STATE);
            $criteria->addSelectColumn(ItemArchiveTableMap::COL_BOX);
            $criteria->addSelectColumn(ItemArchiveTableMap::COL_MANUAL);
            $criteria->addSelectColumn(ItemArchiveTableMap::COL_STYLE);
            $criteria->addSelectColumn(ItemArchiveTableMap::COL_ARCHIVED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.item_id');
            $criteria->addSelectColumn($alias . '.name');
            $criteria->addSelectColumn($alias . '.link');
            $criteria->addSelectColumn($alias . '.image_url');
            $criteria->addSelectColumn($alias . '.console');
            $criteria->addSelectColumn($alias . '.category');
            $criteria->addSelectColumn($alias . '.state');
            $criteria->addSelectColumn($alias . '.box');
            $criteria->addSelectColumn($alias . '.manual');
            $criteria->addSelectColumn($alias . '.style');
            $criteria->addSelectColumn($alias . '.archived_at');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(ItemArchiveTableMap::DATABASE_NAME)->getTable(ItemArchiveTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(ItemArchiveTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(ItemArchiveTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new ItemArchiveTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a ItemArchive or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ItemArchive object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ItemArchiveTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \vgi\ItemArchive) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(ItemArchiveTableMap::DATABASE_NAME);
            $criteria->add(ItemArchiveTableMap::COL_ITEM_ID, (array) $values, Criteria::IN);
        }

        $query = ItemArchiveQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            ItemArchiveTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                ItemArchiveTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the item_archive table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return ItemArchiveQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a ItemArchive or Criteria object.
     *
     * @param mixed               $criteria Criteria or ItemArchive object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ItemArchiveTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from ItemArchive object
        }


        // Set the correct dbName
        $query = ItemArchiveQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // ItemArchiveTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
ItemArchiveTableMap::buildTableMap();
