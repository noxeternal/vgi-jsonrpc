<?php

namespace vgi\Base;

use \Exception;
use \PDO;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use vgi\Category as ChildCategory;
use vgi\CategoryQuery as ChildCategoryQuery;
use vgi\Console as ChildConsole;
use vgi\ConsoleQuery as ChildConsoleQuery;
use vgi\Extra as ChildExtra;
use vgi\ExtraQuery as ChildExtraQuery;
use vgi\Item as ChildItem;
use vgi\ItemArchive as ChildItemArchive;
use vgi\ItemArchiveQuery as ChildItemArchiveQuery;
use vgi\ItemQuery as ChildItemQuery;
use vgi\PriceList as ChildPriceList;
use vgi\PriceListQuery as ChildPriceListQuery;
use vgi\State as ChildState;
use vgi\StateQuery as ChildStateQuery;
use vgi\Style as ChildStyle;
use vgi\StyleQuery as ChildStyleQuery;
use vgi\Map\ExtraTableMap;
use vgi\Map\ItemTableMap;
use vgi\Map\PriceListTableMap;

/**
 * Base class that represents a row from the 'item' table.
 *
 *
 *
 * @package    propel.generator.vgi.Base
 */
abstract class Item implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\vgi\\Map\\ItemTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the item_id field.
     *
     * @var        string
     */
    protected $item_id;

    /**
     * The value for the name field.
     *
     * @var        string
     */
    protected $name;

    /**
     * The value for the link field.
     *
     * Note: this column has a database default value of: ''
     * @var        string
     */
    protected $link;

    /**
     * The value for the image_url field.
     *
     * Note: this column has a database default value of: ''
     * @var        string
     */
    protected $image_url;

    /**
     * The value for the console field.
     *
     * @var        string
     */
    protected $console;

    /**
     * The value for the category field.
     *
     * @var        string
     */
    protected $category;

    /**
     * The value for the state field.
     *
     * @var        string
     */
    protected $state;

    /**
     * The value for the box field.
     *
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $box;

    /**
     * The value for the manual field.
     *
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $manual;

    /**
     * The value for the style field.
     *
     * Note: this column has a database default value of: ''
     * @var        string
     */
    protected $style;

    /**
     * @var        ChildConsole
     */
    protected $a_Console;

    /**
     * @var        ChildCategory
     */
    protected $a_Category;

    /**
     * @var        ChildState
     */
    protected $a_State;

    /**
     * @var        ChildStyle
     */
    protected $a_Style;

    /**
     * @var        ObjectCollection|ChildExtra[] Collection to store aggregation of ChildExtra objects.
     */
    protected $collExtras;
    protected $collExtrasPartial;

    /**
     * @var        ObjectCollection|ChildPriceList[] Collection to store aggregation of ChildPriceList objects.
     */
    protected $collPriceLists;
    protected $collPriceListsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    // archivable behavior
    protected $archiveOnDelete = true;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildExtra[]
     */
    protected $extrasScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPriceList[]
     */
    protected $priceListsScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->link = '';
        $this->image_url = '';
        $this->box = false;
        $this->manual = false;
        $this->style = '';
    }

    /**
     * Initializes internal state of vgi\Base\Item object.
     * @see applyDefaults()
     */
    public function __construct()
    {
        $this->applyDefaultValues();
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>Item</code> instance.  If
     * <code>obj</code> is an instance of <code>Item</code>, delegates to
     * <code>equals(Item)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this|Item The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        $cls = new \ReflectionClass($this);
        $propertyNames = [];
        $serializableProperties = array_diff($cls->getProperties(), $cls->getProperties(\ReflectionProperty::IS_STATIC));

        foreach($serializableProperties as $property) {
            $propertyNames[] = $property->getName();
        }

        return $propertyNames;
    }

    /**
     * Get the [item_id] column value.
     *
     * @return string
     */
    public function getItemId()
    {
        return $this->item_id;
    }

    /**
     * Get the [name] column value.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the [link] column value.
     *
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Get the [image_url] column value.
     *
     * @return string
     */
    public function getImageUrl()
    {
        return $this->image_url;
    }

    /**
     * Get the [console] column value.
     *
     * @return string
     */
    public function getConsole()
    {
        return $this->console;
    }

    /**
     * Get the [category] column value.
     *
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Get the [state] column value.
     *
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Get the [box] column value.
     *
     * @return boolean
     */
    public function getBox()
    {
        return $this->box;
    }

    /**
     * Get the [box] column value.
     *
     * @return boolean
     */
    public function isBox()
    {
        return $this->getBox();
    }

    /**
     * Get the [manual] column value.
     *
     * @return boolean
     */
    public function getManual()
    {
        return $this->manual;
    }

    /**
     * Get the [manual] column value.
     *
     * @return boolean
     */
    public function isManual()
    {
        return $this->getManual();
    }

    /**
     * Get the [style] column value.
     *
     * @return string
     */
    public function getStyle()
    {
        return $this->style;
    }

    /**
     * Set the value of [item_id] column.
     *
     * @param string $v new value
     * @return $this|\vgi\Item The current object (for fluent API support)
     */
    public function setItemId($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->item_id !== $v) {
            $this->item_id = $v;
            $this->modifiedColumns[ItemTableMap::COL_ITEM_ID] = true;
        }

        return $this;
    } // setItemId()

    /**
     * Set the value of [name] column.
     *
     * @param string $v new value
     * @return $this|\vgi\Item The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[ItemTableMap::COL_NAME] = true;
        }

        return $this;
    } // setName()

    /**
     * Set the value of [link] column.
     *
     * @param string $v new value
     * @return $this|\vgi\Item The current object (for fluent API support)
     */
    public function setLink($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->link !== $v) {
            $this->link = $v;
            $this->modifiedColumns[ItemTableMap::COL_LINK] = true;
        }

        return $this;
    } // setLink()

    /**
     * Set the value of [image_url] column.
     *
     * @param string $v new value
     * @return $this|\vgi\Item The current object (for fluent API support)
     */
    public function setImageUrl($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->image_url !== $v) {
            $this->image_url = $v;
            $this->modifiedColumns[ItemTableMap::COL_IMAGE_URL] = true;
        }

        return $this;
    } // setImageUrl()

    /**
     * Set the value of [console] column.
     *
     * @param string $v new value
     * @return $this|\vgi\Item The current object (for fluent API support)
     */
    public function setConsole($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->console !== $v) {
            $this->console = $v;
            $this->modifiedColumns[ItemTableMap::COL_CONSOLE] = true;
        }

        if ($this->a_Console !== null && $this->a_Console->getText() !== $v) {
            $this->a_Console = null;
        }

        return $this;
    } // setConsole()

    /**
     * Set the value of [category] column.
     *
     * @param string $v new value
     * @return $this|\vgi\Item The current object (for fluent API support)
     */
    public function setCategory($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->category !== $v) {
            $this->category = $v;
            $this->modifiedColumns[ItemTableMap::COL_CATEGORY] = true;
        }

        if ($this->a_Category !== null && $this->a_Category->getText() !== $v) {
            $this->a_Category = null;
        }

        return $this;
    } // setCategory()

    /**
     * Set the value of [state] column.
     *
     * @param string $v new value
     * @return $this|\vgi\Item The current object (for fluent API support)
     */
    public function setState($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->state !== $v) {
            $this->state = $v;
            $this->modifiedColumns[ItemTableMap::COL_STATE] = true;
        }

        if ($this->a_State !== null && $this->a_State->getText() !== $v) {
            $this->a_State = null;
        }

        return $this;
    } // setState()

    /**
     * Sets the value of the [box] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\vgi\Item The current object (for fluent API support)
     */
    public function setBox($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->box !== $v) {
            $this->box = $v;
            $this->modifiedColumns[ItemTableMap::COL_BOX] = true;
        }

        return $this;
    } // setBox()

    /**
     * Sets the value of the [manual] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\vgi\Item The current object (for fluent API support)
     */
    public function setManual($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->manual !== $v) {
            $this->manual = $v;
            $this->modifiedColumns[ItemTableMap::COL_MANUAL] = true;
        }

        return $this;
    } // setManual()

    /**
     * Set the value of [style] column.
     *
     * @param string $v new value
     * @return $this|\vgi\Item The current object (for fluent API support)
     */
    public function setStyle($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->style !== $v) {
            $this->style = $v;
            $this->modifiedColumns[ItemTableMap::COL_STYLE] = true;
        }

        if ($this->a_Style !== null && $this->a_Style->getName() !== $v) {
            $this->a_Style = null;
        }

        return $this;
    } // setStyle()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
            if ($this->link !== '') {
                return false;
            }

            if ($this->image_url !== '') {
                return false;
            }

            if ($this->box !== false) {
                return false;
            }

            if ($this->manual !== false) {
                return false;
            }

            if ($this->style !== '') {
                return false;
            }

        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : ItemTableMap::translateFieldName('ItemId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->item_id = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : ItemTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : ItemTableMap::translateFieldName('Link', TableMap::TYPE_PHPNAME, $indexType)];
            $this->link = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : ItemTableMap::translateFieldName('ImageUrl', TableMap::TYPE_PHPNAME, $indexType)];
            $this->image_url = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : ItemTableMap::translateFieldName('Console', TableMap::TYPE_PHPNAME, $indexType)];
            $this->console = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : ItemTableMap::translateFieldName('Category', TableMap::TYPE_PHPNAME, $indexType)];
            $this->category = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : ItemTableMap::translateFieldName('State', TableMap::TYPE_PHPNAME, $indexType)];
            $this->state = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : ItemTableMap::translateFieldName('Box', TableMap::TYPE_PHPNAME, $indexType)];
            $this->box = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : ItemTableMap::translateFieldName('Manual', TableMap::TYPE_PHPNAME, $indexType)];
            $this->manual = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : ItemTableMap::translateFieldName('Style', TableMap::TYPE_PHPNAME, $indexType)];
            $this->style = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 10; // 10 = ItemTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\vgi\\Item'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
        if ($this->a_Console !== null && $this->console !== $this->a_Console->getText()) {
            $this->a_Console = null;
        }
        if ($this->a_Category !== null && $this->category !== $this->a_Category->getText()) {
            $this->a_Category = null;
        }
        if ($this->a_State !== null && $this->state !== $this->a_State->getText()) {
            $this->a_State = null;
        }
        if ($this->a_Style !== null && $this->style !== $this->a_Style->getName()) {
            $this->a_Style = null;
        }
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ItemTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildItemQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->a_Console = null;
            $this->a_Category = null;
            $this->a_State = null;
            $this->a_Style = null;
            $this->collExtras = null;

            $this->collPriceLists = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Item::setDeleted()
     * @see Item::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(ItemTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildItemQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            // archivable behavior
            if ($ret) {
                if ($this->archiveOnDelete) {
                    // do nothing yet. The object will be archived later when calling ChildItemQuery::delete().
                } else {
                    $deleteQuery->setArchiveOnDelete(false);
                    $this->archiveOnDelete = true;
                }
            }

            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($this->alreadyInSave) {
            return 0;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(ItemTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $ret = $this->preSave($con);
            $isInsert = $this->isNew();
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                ItemTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->a_Console !== null) {
                if ($this->a_Console->isModified() || $this->a_Console->isNew()) {
                    $affectedRows += $this->a_Console->save($con);
                }
                $this->set_Console($this->a_Console);
            }

            if ($this->a_Category !== null) {
                if ($this->a_Category->isModified() || $this->a_Category->isNew()) {
                    $affectedRows += $this->a_Category->save($con);
                }
                $this->set_Category($this->a_Category);
            }

            if ($this->a_State !== null) {
                if ($this->a_State->isModified() || $this->a_State->isNew()) {
                    $affectedRows += $this->a_State->save($con);
                }
                $this->set_State($this->a_State);
            }

            if ($this->a_Style !== null) {
                if ($this->a_Style->isModified() || $this->a_Style->isNew()) {
                    $affectedRows += $this->a_Style->save($con);
                }
                $this->set_Style($this->a_Style);
            }

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                $this->resetModified();
            }

            if ($this->extrasScheduledForDeletion !== null) {
                if (!$this->extrasScheduledForDeletion->isEmpty()) {
                    \vgi\ExtraQuery::create()
                        ->filterByPrimaryKeys($this->extrasScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->extrasScheduledForDeletion = null;
                }
            }

            if ($this->collExtras !== null) {
                foreach ($this->collExtras as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->priceListsScheduledForDeletion !== null) {
                if (!$this->priceListsScheduledForDeletion->isEmpty()) {
                    \vgi\PriceListQuery::create()
                        ->filterByPrimaryKeys($this->priceListsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->priceListsScheduledForDeletion = null;
                }
            }

            if ($this->collPriceLists !== null) {
                foreach ($this->collPriceLists as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[ItemTableMap::COL_ITEM_ID] = true;
        if (null !== $this->item_id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . ItemTableMap::COL_ITEM_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ItemTableMap::COL_ITEM_ID)) {
            $modifiedColumns[':p' . $index++]  = 'item_id';
        }
        if ($this->isColumnModified(ItemTableMap::COL_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'name';
        }
        if ($this->isColumnModified(ItemTableMap::COL_LINK)) {
            $modifiedColumns[':p' . $index++]  = 'link';
        }
        if ($this->isColumnModified(ItemTableMap::COL_IMAGE_URL)) {
            $modifiedColumns[':p' . $index++]  = 'image_url';
        }
        if ($this->isColumnModified(ItemTableMap::COL_CONSOLE)) {
            $modifiedColumns[':p' . $index++]  = 'console';
        }
        if ($this->isColumnModified(ItemTableMap::COL_CATEGORY)) {
            $modifiedColumns[':p' . $index++]  = 'category';
        }
        if ($this->isColumnModified(ItemTableMap::COL_STATE)) {
            $modifiedColumns[':p' . $index++]  = 'state';
        }
        if ($this->isColumnModified(ItemTableMap::COL_BOX)) {
            $modifiedColumns[':p' . $index++]  = 'box';
        }
        if ($this->isColumnModified(ItemTableMap::COL_MANUAL)) {
            $modifiedColumns[':p' . $index++]  = 'manual';
        }
        if ($this->isColumnModified(ItemTableMap::COL_STYLE)) {
            $modifiedColumns[':p' . $index++]  = 'style';
        }

        $sql = sprintf(
            'INSERT INTO item (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'item_id':
                        $stmt->bindValue($identifier, $this->item_id, PDO::PARAM_INT);
                        break;
                    case 'name':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case 'link':
                        $stmt->bindValue($identifier, $this->link, PDO::PARAM_STR);
                        break;
                    case 'image_url':
                        $stmt->bindValue($identifier, $this->image_url, PDO::PARAM_STR);
                        break;
                    case 'console':
                        $stmt->bindValue($identifier, $this->console, PDO::PARAM_STR);
                        break;
                    case 'category':
                        $stmt->bindValue($identifier, $this->category, PDO::PARAM_STR);
                        break;
                    case 'state':
                        $stmt->bindValue($identifier, $this->state, PDO::PARAM_STR);
                        break;
                    case 'box':
                        $stmt->bindValue($identifier, (int) $this->box, PDO::PARAM_INT);
                        break;
                    case 'manual':
                        $stmt->bindValue($identifier, (int) $this->manual, PDO::PARAM_INT);
                        break;
                    case 'style':
                        $stmt->bindValue($identifier, $this->style, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setItemId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = ItemTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getItemId();
                break;
            case 1:
                return $this->getName();
                break;
            case 2:
                return $this->getLink();
                break;
            case 3:
                return $this->getImageUrl();
                break;
            case 4:
                return $this->getConsole();
                break;
            case 5:
                return $this->getCategory();
                break;
            case 6:
                return $this->getState();
                break;
            case 7:
                return $this->getBox();
                break;
            case 8:
                return $this->getManual();
                break;
            case 9:
                return $this->getStyle();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {

        if (isset($alreadyDumpedObjects['Item'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Item'][$this->hashCode()] = true;
        $keys = ItemTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getItemId(),
            $keys[1] => $this->getName(),
            $keys[2] => $this->getLink(),
            $keys[3] => $this->getImageUrl(),
            $keys[4] => $this->getConsole(),
            $keys[5] => $this->getCategory(),
            $keys[6] => $this->getState(),
            $keys[7] => $this->getBox(),
            $keys[8] => $this->getManual(),
            $keys[9] => $this->getStyle(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->a_Console) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'console';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'console';
                        break;
                    default:
                        $key = '_Console';
                }

                $result[$key] = $this->a_Console->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->a_Category) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'category';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'category';
                        break;
                    default:
                        $key = '_Category';
                }

                $result[$key] = $this->a_Category->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->a_State) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'state';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'state';
                        break;
                    default:
                        $key = '_State';
                }

                $result[$key] = $this->a_State->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->a_Style) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'style';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'style';
                        break;
                    default:
                        $key = '_Style';
                }

                $result[$key] = $this->a_Style->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collExtras) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'extras';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'extras';
                        break;
                    default:
                        $key = 'Extras';
                }

                $result[$key] = $this->collExtras->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collPriceLists) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'priceLists';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'price_lists';
                        break;
                    default:
                        $key = 'PriceLists';
                }

                $result[$key] = $this->collPriceLists->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\vgi\Item
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = ItemTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\vgi\Item
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setItemId($value);
                break;
            case 1:
                $this->setName($value);
                break;
            case 2:
                $this->setLink($value);
                break;
            case 3:
                $this->setImageUrl($value);
                break;
            case 4:
                $this->setConsole($value);
                break;
            case 5:
                $this->setCategory($value);
                break;
            case 6:
                $this->setState($value);
                break;
            case 7:
                $this->setBox($value);
                break;
            case 8:
                $this->setManual($value);
                break;
            case 9:
                $this->setStyle($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = ItemTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setItemId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setName($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setLink($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setImageUrl($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setConsole($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setCategory($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setState($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setBox($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setManual($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setStyle($arr[$keys[9]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this|\vgi\Item The current object, for fluid interface
     */
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(ItemTableMap::DATABASE_NAME);

        if ($this->isColumnModified(ItemTableMap::COL_ITEM_ID)) {
            $criteria->add(ItemTableMap::COL_ITEM_ID, $this->item_id);
        }
        if ($this->isColumnModified(ItemTableMap::COL_NAME)) {
            $criteria->add(ItemTableMap::COL_NAME, $this->name);
        }
        if ($this->isColumnModified(ItemTableMap::COL_LINK)) {
            $criteria->add(ItemTableMap::COL_LINK, $this->link);
        }
        if ($this->isColumnModified(ItemTableMap::COL_IMAGE_URL)) {
            $criteria->add(ItemTableMap::COL_IMAGE_URL, $this->image_url);
        }
        if ($this->isColumnModified(ItemTableMap::COL_CONSOLE)) {
            $criteria->add(ItemTableMap::COL_CONSOLE, $this->console);
        }
        if ($this->isColumnModified(ItemTableMap::COL_CATEGORY)) {
            $criteria->add(ItemTableMap::COL_CATEGORY, $this->category);
        }
        if ($this->isColumnModified(ItemTableMap::COL_STATE)) {
            $criteria->add(ItemTableMap::COL_STATE, $this->state);
        }
        if ($this->isColumnModified(ItemTableMap::COL_BOX)) {
            $criteria->add(ItemTableMap::COL_BOX, $this->box);
        }
        if ($this->isColumnModified(ItemTableMap::COL_MANUAL)) {
            $criteria->add(ItemTableMap::COL_MANUAL, $this->manual);
        }
        if ($this->isColumnModified(ItemTableMap::COL_STYLE)) {
            $criteria->add(ItemTableMap::COL_STYLE, $this->style);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = ChildItemQuery::create();
        $criteria->add(ItemTableMap::COL_ITEM_ID, $this->item_id);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getItemId();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the primary key for this object (row).
     * @return string
     */
    public function getPrimaryKey()
    {
        return $this->getItemId();
    }

    /**
     * Generic method to set the primary key (item_id column).
     *
     * @param       string $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setItemId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getItemId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \vgi\Item (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setName($this->getName());
        $copyObj->setLink($this->getLink());
        $copyObj->setImageUrl($this->getImageUrl());
        $copyObj->setConsole($this->getConsole());
        $copyObj->setCategory($this->getCategory());
        $copyObj->setState($this->getState());
        $copyObj->setBox($this->getBox());
        $copyObj->setManual($this->getManual());
        $copyObj->setStyle($this->getStyle());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getExtras() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addExtra($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPriceLists() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPriceList($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setItemId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \vgi\Item Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Declares an association between this object and a ChildConsole object.
     *
     * @param  ChildConsole $v
     * @return $this|\vgi\Item The current object (for fluent API support)
     * @throws PropelException
     */
    public function set_Console(ChildConsole $v = null)
    {
        if ($v === null) {
            $this->setConsole(NULL);
        } else {
            $this->setConsole($v->getText());
        }

        $this->a_Console = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildConsole object, it will not be re-added.
        if ($v !== null) {
            $v->addItem($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildConsole object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildConsole The associated ChildConsole object.
     * @throws PropelException
     */
    public function get_Console(ConnectionInterface $con = null)
    {
        if ($this->a_Console === null && (($this->console !== "" && $this->console !== null))) {
            $this->a_Console = ChildConsoleQuery::create()->findPk($this->console, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->a_Console->addItems($this);
             */
        }

        return $this->a_Console;
    }

    /**
     * Declares an association between this object and a ChildCategory object.
     *
     * @param  ChildCategory $v
     * @return $this|\vgi\Item The current object (for fluent API support)
     * @throws PropelException
     */
    public function set_Category(ChildCategory $v = null)
    {
        if ($v === null) {
            $this->setCategory(NULL);
        } else {
            $this->setCategory($v->getText());
        }

        $this->a_Category = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildCategory object, it will not be re-added.
        if ($v !== null) {
            $v->addItem($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildCategory object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildCategory The associated ChildCategory object.
     * @throws PropelException
     */
    public function get_Category(ConnectionInterface $con = null)
    {
        if ($this->a_Category === null && (($this->category !== "" && $this->category !== null))) {
            $this->a_Category = ChildCategoryQuery::create()->findPk($this->category, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->a_Category->addItems($this);
             */
        }

        return $this->a_Category;
    }

    /**
     * Declares an association between this object and a ChildState object.
     *
     * @param  ChildState $v
     * @return $this|\vgi\Item The current object (for fluent API support)
     * @throws PropelException
     */
    public function set_State(ChildState $v = null)
    {
        if ($v === null) {
            $this->setState(NULL);
        } else {
            $this->setState($v->getText());
        }

        $this->a_State = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildState object, it will not be re-added.
        if ($v !== null) {
            $v->addItem($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildState object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildState The associated ChildState object.
     * @throws PropelException
     */
    public function get_State(ConnectionInterface $con = null)
    {
        if ($this->a_State === null && (($this->state !== "" && $this->state !== null))) {
            $this->a_State = ChildStateQuery::create()->findPk($this->state, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->a_State->addItems($this);
             */
        }

        return $this->a_State;
    }

    /**
     * Declares an association between this object and a ChildStyle object.
     *
     * @param  ChildStyle $v
     * @return $this|\vgi\Item The current object (for fluent API support)
     * @throws PropelException
     */
    public function set_Style(ChildStyle $v = null)
    {
        if ($v === null) {
            $this->setStyle('');
        } else {
            $this->setStyle($v->getName());
        }

        $this->a_Style = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildStyle object, it will not be re-added.
        if ($v !== null) {
            $v->addItem($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildStyle object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildStyle The associated ChildStyle object.
     * @throws PropelException
     */
    public function get_Style(ConnectionInterface $con = null)
    {
        if ($this->a_Style === null && (($this->style !== "" && $this->style !== null))) {
            $this->a_Style = ChildStyleQuery::create()->findPk($this->style, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->a_Style->addItems($this);
             */
        }

        return $this->a_Style;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('Extra' == $relationName) {
            $this->initExtras();
            return;
        }
        if ('PriceList' == $relationName) {
            $this->initPriceLists();
            return;
        }
    }

    /**
     * Clears out the collExtras collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addExtras()
     */
    public function clearExtras()
    {
        $this->collExtras = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collExtras collection loaded partially.
     */
    public function resetPartialExtras($v = true)
    {
        $this->collExtrasPartial = $v;
    }

    /**
     * Initializes the collExtras collection.
     *
     * By default this just sets the collExtras collection to an empty array (like clearcollExtras());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initExtras($overrideExisting = true)
    {
        if (null !== $this->collExtras && !$overrideExisting) {
            return;
        }

        $collectionClassName = ExtraTableMap::getTableMap()->getCollectionClassName();

        $this->collExtras = new $collectionClassName;
        $this->collExtras->setModel('\vgi\Extra');
    }

    /**
     * Gets an array of ChildExtra objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildItem is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildExtra[] List of ChildExtra objects
     * @throws PropelException
     */
    public function getExtras(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collExtrasPartial && !$this->isNew();
        if (null === $this->collExtras || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collExtras) {
                // return empty collection
                $this->initExtras();
            } else {
                $collExtras = ChildExtraQuery::create(null, $criteria)
                    ->filterByItemIdExtra($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collExtrasPartial && count($collExtras)) {
                        $this->initExtras(false);

                        foreach ($collExtras as $obj) {
                            if (false == $this->collExtras->contains($obj)) {
                                $this->collExtras->append($obj);
                            }
                        }

                        $this->collExtrasPartial = true;
                    }

                    return $collExtras;
                }

                if ($partial && $this->collExtras) {
                    foreach ($this->collExtras as $obj) {
                        if ($obj->isNew()) {
                            $collExtras[] = $obj;
                        }
                    }
                }

                $this->collExtras = $collExtras;
                $this->collExtrasPartial = false;
            }
        }

        return $this->collExtras;
    }

    /**
     * Sets a collection of ChildExtra objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $extras A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildItem The current object (for fluent API support)
     */
    public function setExtras(Collection $extras, ConnectionInterface $con = null)
    {
        /** @var ChildExtra[] $extrasToDelete */
        $extrasToDelete = $this->getExtras(new Criteria(), $con)->diff($extras);


        $this->extrasScheduledForDeletion = $extrasToDelete;

        foreach ($extrasToDelete as $extraRemoved) {
            $extraRemoved->setItemIdExtra(null);
        }

        $this->collExtras = null;
        foreach ($extras as $extra) {
            $this->addExtra($extra);
        }

        $this->collExtras = $extras;
        $this->collExtrasPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Extra objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Extra objects.
     * @throws PropelException
     */
    public function countExtras(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collExtrasPartial && !$this->isNew();
        if (null === $this->collExtras || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collExtras) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getExtras());
            }

            $query = ChildExtraQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByItemIdExtra($this)
                ->count($con);
        }

        return count($this->collExtras);
    }

    /**
     * Method called to associate a ChildExtra object to this object
     * through the ChildExtra foreign key attribute.
     *
     * @param  ChildExtra $l ChildExtra
     * @return $this|\vgi\Item The current object (for fluent API support)
     */
    public function addExtra(ChildExtra $l)
    {
        if ($this->collExtras === null) {
            $this->initExtras();
            $this->collExtrasPartial = true;
        }

        if (!$this->collExtras->contains($l)) {
            $this->doAddExtra($l);

            if ($this->extrasScheduledForDeletion and $this->extrasScheduledForDeletion->contains($l)) {
                $this->extrasScheduledForDeletion->remove($this->extrasScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildExtra $extra The ChildExtra object to add.
     */
    protected function doAddExtra(ChildExtra $extra)
    {
        $this->collExtras[]= $extra;
        $extra->setItemIdExtra($this);
    }

    /**
     * @param  ChildExtra $extra The ChildExtra object to remove.
     * @return $this|ChildItem The current object (for fluent API support)
     */
    public function removeExtra(ChildExtra $extra)
    {
        if ($this->getExtras()->contains($extra)) {
            $pos = $this->collExtras->search($extra);
            $this->collExtras->remove($pos);
            if (null === $this->extrasScheduledForDeletion) {
                $this->extrasScheduledForDeletion = clone $this->collExtras;
                $this->extrasScheduledForDeletion->clear();
            }
            $this->extrasScheduledForDeletion[]= clone $extra;
            $extra->setItemIdExtra(null);
        }

        return $this;
    }

    /**
     * Clears out the collPriceLists collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPriceLists()
     */
    public function clearPriceLists()
    {
        $this->collPriceLists = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPriceLists collection loaded partially.
     */
    public function resetPartialPriceLists($v = true)
    {
        $this->collPriceListsPartial = $v;
    }

    /**
     * Initializes the collPriceLists collection.
     *
     * By default this just sets the collPriceLists collection to an empty array (like clearcollPriceLists());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPriceLists($overrideExisting = true)
    {
        if (null !== $this->collPriceLists && !$overrideExisting) {
            return;
        }

        $collectionClassName = PriceListTableMap::getTableMap()->getCollectionClassName();

        $this->collPriceLists = new $collectionClassName;
        $this->collPriceLists->setModel('\vgi\PriceList');
    }

    /**
     * Gets an array of ChildPriceList objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildItem is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildPriceList[] List of ChildPriceList objects
     * @throws PropelException
     */
    public function getPriceLists(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPriceListsPartial && !$this->isNew();
        if (null === $this->collPriceLists || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPriceLists) {
                // return empty collection
                $this->initPriceLists();
            } else {
                $collPriceLists = ChildPriceListQuery::create(null, $criteria)
                    ->filterByItemIdPriceList($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPriceListsPartial && count($collPriceLists)) {
                        $this->initPriceLists(false);

                        foreach ($collPriceLists as $obj) {
                            if (false == $this->collPriceLists->contains($obj)) {
                                $this->collPriceLists->append($obj);
                            }
                        }

                        $this->collPriceListsPartial = true;
                    }

                    return $collPriceLists;
                }

                if ($partial && $this->collPriceLists) {
                    foreach ($this->collPriceLists as $obj) {
                        if ($obj->isNew()) {
                            $collPriceLists[] = $obj;
                        }
                    }
                }

                $this->collPriceLists = $collPriceLists;
                $this->collPriceListsPartial = false;
            }
        }

        return $this->collPriceLists;
    }

    /**
     * Sets a collection of ChildPriceList objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $priceLists A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildItem The current object (for fluent API support)
     */
    public function setPriceLists(Collection $priceLists, ConnectionInterface $con = null)
    {
        /** @var ChildPriceList[] $priceListsToDelete */
        $priceListsToDelete = $this->getPriceLists(new Criteria(), $con)->diff($priceLists);


        $this->priceListsScheduledForDeletion = $priceListsToDelete;

        foreach ($priceListsToDelete as $priceListRemoved) {
            $priceListRemoved->setItemIdPriceList(null);
        }

        $this->collPriceLists = null;
        foreach ($priceLists as $priceList) {
            $this->addPriceList($priceList);
        }

        $this->collPriceLists = $priceLists;
        $this->collPriceListsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related PriceList objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related PriceList objects.
     * @throws PropelException
     */
    public function countPriceLists(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPriceListsPartial && !$this->isNew();
        if (null === $this->collPriceLists || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPriceLists) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPriceLists());
            }

            $query = ChildPriceListQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByItemIdPriceList($this)
                ->count($con);
        }

        return count($this->collPriceLists);
    }

    /**
     * Method called to associate a ChildPriceList object to this object
     * through the ChildPriceList foreign key attribute.
     *
     * @param  ChildPriceList $l ChildPriceList
     * @return $this|\vgi\Item The current object (for fluent API support)
     */
    public function addPriceList(ChildPriceList $l)
    {
        if ($this->collPriceLists === null) {
            $this->initPriceLists();
            $this->collPriceListsPartial = true;
        }

        if (!$this->collPriceLists->contains($l)) {
            $this->doAddPriceList($l);

            if ($this->priceListsScheduledForDeletion and $this->priceListsScheduledForDeletion->contains($l)) {
                $this->priceListsScheduledForDeletion->remove($this->priceListsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildPriceList $priceList The ChildPriceList object to add.
     */
    protected function doAddPriceList(ChildPriceList $priceList)
    {
        $this->collPriceLists[]= $priceList;
        $priceList->setItemIdPriceList($this);
    }

    /**
     * @param  ChildPriceList $priceList The ChildPriceList object to remove.
     * @return $this|ChildItem The current object (for fluent API support)
     */
    public function removePriceList(ChildPriceList $priceList)
    {
        if ($this->getPriceLists()->contains($priceList)) {
            $pos = $this->collPriceLists->search($priceList);
            $this->collPriceLists->remove($pos);
            if (null === $this->priceListsScheduledForDeletion) {
                $this->priceListsScheduledForDeletion = clone $this->collPriceLists;
                $this->priceListsScheduledForDeletion->clear();
            }
            $this->priceListsScheduledForDeletion[]= clone $priceList;
            $priceList->setItemIdPriceList(null);
        }

        return $this;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->a_Console) {
            $this->a_Console->removeItem($this);
        }
        if (null !== $this->a_Category) {
            $this->a_Category->removeItem($this);
        }
        if (null !== $this->a_State) {
            $this->a_State->removeItem($this);
        }
        if (null !== $this->a_Style) {
            $this->a_Style->removeItem($this);
        }
        $this->item_id = null;
        $this->name = null;
        $this->link = null;
        $this->image_url = null;
        $this->console = null;
        $this->category = null;
        $this->state = null;
        $this->box = null;
        $this->manual = null;
        $this->style = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->applyDefaultValues();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collExtras) {
                foreach ($this->collExtras as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPriceLists) {
                foreach ($this->collPriceLists as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collExtras = null;
        $this->collPriceLists = null;
        $this->a_Console = null;
        $this->a_Category = null;
        $this->a_State = null;
        $this->a_Style = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(ItemTableMap::DEFAULT_STRING_FORMAT);
    }

    // archivable behavior

    /**
     * Get an archived version of the current object.
     *
     * @param ConnectionInterface $con Optional connection object
     *
     * @return     ChildItemArchive An archive object, or null if the current object was never archived
     */
    public function getArchive(ConnectionInterface $con = null)
    {
        if ($this->isNew()) {
            return null;
        }
        $archive = ChildItemArchiveQuery::create()
            ->filterByPrimaryKey($this->getPrimaryKey())
            ->findOne($con);

        return $archive;
    }
    /**
     * Copy the data of the current object into a $archiveTablePhpName archive object.
     * The archived object is then saved.
     * If the current object has already been archived, the archived object
     * is updated and not duplicated.
     *
     * @param ConnectionInterface $con Optional connection object
     *
     * @throws PropelException If the object is new
     *
     * @return     ChildItemArchive The archive object based on this object
     */
    public function archive(ConnectionInterface $con = null)
    {
        if ($this->isNew()) {
            throw new PropelException('New objects cannot be archived. You must save the current object before calling archive().');
        }
        $archive = $this->getArchive($con);
        if (!$archive) {
            $archive = new ChildItemArchive();
            $archive->setPrimaryKey($this->getPrimaryKey());
        }
        $this->copyInto($archive, $deepCopy = false, $makeNew = false);
        $archive->setArchivedAt(time());
        $archive->save($con);

        return $archive;
    }

    /**
     * Revert the the current object to the state it had when it was last archived.
     * The object must be saved afterwards if the changes must persist.
     *
     * @param ConnectionInterface $con Optional connection object
     *
     * @throws PropelException If the object has no corresponding archive.
     *
     * @return $this|ChildItem The current object (for fluent API support)
     */
    public function restoreFromArchive(ConnectionInterface $con = null)
    {
        $archive = $this->getArchive($con);
        if (!$archive) {
            throw new PropelException('The current object has never been archived and cannot be restored');
        }
        $this->populateFromArchive($archive);

        return $this;
    }

    /**
     * Populates the the current object based on a $archiveTablePhpName archive object.
     *
     * @param      ChildItemArchive $archive An archived object based on the same class
      * @param      Boolean $populateAutoIncrementPrimaryKeys
     *               If true, autoincrement columns are copied from the archive object.
     *               If false, autoincrement columns are left intact.
      *
     * @return     ChildItem The current object (for fluent API support)
     */
    public function populateFromArchive($archive, $populateAutoIncrementPrimaryKeys = false) {
        if ($populateAutoIncrementPrimaryKeys) {
            $this->setItemId($archive->getItemId());
        }
        $this->setName($archive->getName());
        $this->setLink($archive->getLink());
        $this->setImageUrl($archive->getImageUrl());
        $this->setConsole($archive->getConsole());
        $this->setCategory($archive->getCategory());
        $this->setState($archive->getState());
        $this->setBox($archive->getBox());
        $this->setManual($archive->getManual());
        $this->setStyle($archive->getStyle());

        return $this;
    }

    /**
     * Removes the object from the database without archiving it.
     *
     * @param ConnectionInterface $con Optional connection object
     *
     * @return $this|ChildItem The current object (for fluent API support)
     */
    public function deleteWithoutArchive(ConnectionInterface $con = null)
    {
        $this->archiveOnDelete = false;

        return $this->delete($con);
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preSave')) {
            return parent::preSave($con);
        }
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postSave')) {
            parent::postSave($con);
        }
    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preInsert')) {
            return parent::preInsert($con);
        }
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postInsert')) {
            parent::postInsert($con);
        }
    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preUpdate')) {
            return parent::preUpdate($con);
        }
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postUpdate')) {
            parent::postUpdate($con);
        }
    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preDelete')) {
            return parent::preDelete($con);
        }
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postDelete')) {
            parent::postDelete($con);
        }
    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
