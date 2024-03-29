<?php

namespace Kantaria\Models\Base;

use \Exception;
use \PDO;
use Kantaria\Models\Hero as ChildHero;
use Kantaria\Models\HeroQuery as ChildHeroQuery;
use Kantaria\Models\Inventory as ChildInventory;
use Kantaria\Models\InventoryQuery as ChildInventoryQuery;
use Kantaria\Models\Quest as ChildQuest;
use Kantaria\Models\QuestQuery as ChildQuestQuery;
use Kantaria\Models\User as ChildUser;
use Kantaria\Models\UserQuery as ChildUserQuery;
use Kantaria\Models\Map\HeroTableMap;
use Kantaria\Models\Map\InventoryTableMap;
use Kantaria\Models\Map\QuestTableMap;
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
use Symfony\Component\Translation\IdentityTranslator;
use Symfony\Component\Validator\ConstraintValidatorFactory;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Context\ExecutionContextFactory;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Mapping\Factory\LazyLoadingMetadataFactory;
use Symfony\Component\Validator\Mapping\Loader\StaticMethodLoader;
use Symfony\Component\Validator\Validator\RecursiveValidator;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Base class that represents a row from the 'hero' table.
 *
 *
 *
 * @package    propel.generator.Kantaria.Models.Base
 */
abstract class Hero implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Kantaria\\Models\\Map\\HeroTableMap';


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
     * The value for the id field.
     *
     * @var        int
     */
    protected $id;

    /**
     * The value for the user_id field.
     *
     * @var        int
     */
    protected $user_id;

    /**
     * The value for the first_name field.
     *
     * @var        string
     */
    protected $first_name;

    /**
     * The value for the last_name field.
     *
     * @var        string
     */
    protected $last_name;

    /**
     * The value for the health field.
     *
     * @var        int
     */
    protected $health;

    /**
     * The value for the oxygen field.
     *
     * @var        int
     */
    protected $oxygen;

    /**
     * The value for the food field.
     *
     * @var        int
     */
    protected $food;

    /**
     * The value for the posx field.
     *
     * @var        int
     */
    protected $posx;

    /**
     * The value for the posy field.
     *
     * @var        int
     */
    protected $posy;

    /**
     * The value for the posz field.
     *
     * @var        int
     */
    protected $posz;

    /**
     * @var        ChildUser
     */
    protected $aUser;

    /**
     * @var        ObjectCollection|ChildInventory[] Collection to store aggregation of ChildInventory objects.
     */
    protected $collInventories;
    protected $collInventoriesPartial;

    /**
     * @var        ObjectCollection|ChildQuest[] Collection to store aggregation of ChildQuest objects.
     */
    protected $collQuests;
    protected $collQuestsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    // validate behavior

    /**
     * Flag to prevent endless validation loop, if this object is referenced
     * by another object which falls in this transaction.
     * @var        boolean
     */
    protected $alreadyInValidation = false;

    /**
     * ConstraintViolationList object
     *
     * @see     http://api.symfony.com/2.0/Symfony/Component/Validator/ConstraintViolationList.html
     * @var     ConstraintViolationList
     */
    protected $validationFailures;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildInventory[]
     */
    protected $inventoriesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildQuest[]
     */
    protected $questsScheduledForDeletion = null;

    /**
     * Initializes internal state of Kantaria\Models\Base\Hero object.
     */
    public function __construct()
    {
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
     * Compares this with another <code>Hero</code> instance.  If
     * <code>obj</code> is an instance of <code>Hero</code>, delegates to
     * <code>equals(Hero)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Hero The current object, for fluid interface
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
     * Get the [id] column value.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [user_id] column value.
     *
     * @return int
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Get the [first_name] column value.
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * Get the [last_name] column value.
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * Get the [health] column value.
     *
     * @return int
     */
    public function getHealth()
    {
        return $this->health;
    }

    /**
     * Get the [oxygen] column value.
     *
     * @return int
     */
    public function getOxygen()
    {
        return $this->oxygen;
    }

    /**
     * Get the [food] column value.
     *
     * @return int
     */
    public function getFood()
    {
        return $this->food;
    }

    /**
     * Get the [posx] column value.
     *
     * @return int
     */
    public function getPosx()
    {
        return $this->posx;
    }

    /**
     * Get the [posy] column value.
     *
     * @return int
     */
    public function getPosy()
    {
        return $this->posy;
    }

    /**
     * Get the [posz] column value.
     *
     * @return int
     */
    public function getPosz()
    {
        return $this->posz;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\Kantaria\Models\Hero The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[HeroTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [user_id] column.
     *
     * @param int $v new value
     * @return $this|\Kantaria\Models\Hero The current object (for fluent API support)
     */
    public function setUserId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->user_id !== $v) {
            $this->user_id = $v;
            $this->modifiedColumns[HeroTableMap::COL_USER_ID] = true;
        }

        if ($this->aUser !== null && $this->aUser->getId() !== $v) {
            $this->aUser = null;
        }

        return $this;
    } // setUserId()

    /**
     * Set the value of [first_name] column.
     *
     * @param string $v new value
     * @return $this|\Kantaria\Models\Hero The current object (for fluent API support)
     */
    public function setFirstName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->first_name !== $v) {
            $this->first_name = $v;
            $this->modifiedColumns[HeroTableMap::COL_FIRST_NAME] = true;
        }

        return $this;
    } // setFirstName()

    /**
     * Set the value of [last_name] column.
     *
     * @param string $v new value
     * @return $this|\Kantaria\Models\Hero The current object (for fluent API support)
     */
    public function setLastName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->last_name !== $v) {
            $this->last_name = $v;
            $this->modifiedColumns[HeroTableMap::COL_LAST_NAME] = true;
        }

        return $this;
    } // setLastName()

    /**
     * Set the value of [health] column.
     *
     * @param int $v new value
     * @return $this|\Kantaria\Models\Hero The current object (for fluent API support)
     */
    public function setHealth($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->health !== $v) {
            $this->health = $v;
            $this->modifiedColumns[HeroTableMap::COL_HEALTH] = true;
        }

        return $this;
    } // setHealth()

    /**
     * Set the value of [oxygen] column.
     *
     * @param int $v new value
     * @return $this|\Kantaria\Models\Hero The current object (for fluent API support)
     */
    public function setOxygen($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->oxygen !== $v) {
            $this->oxygen = $v;
            $this->modifiedColumns[HeroTableMap::COL_OXYGEN] = true;
        }

        return $this;
    } // setOxygen()

    /**
     * Set the value of [food] column.
     *
     * @param int $v new value
     * @return $this|\Kantaria\Models\Hero The current object (for fluent API support)
     */
    public function setFood($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->food !== $v) {
            $this->food = $v;
            $this->modifiedColumns[HeroTableMap::COL_FOOD] = true;
        }

        return $this;
    } // setFood()

    /**
     * Set the value of [posx] column.
     *
     * @param int $v new value
     * @return $this|\Kantaria\Models\Hero The current object (for fluent API support)
     */
    public function setPosx($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->posx !== $v) {
            $this->posx = $v;
            $this->modifiedColumns[HeroTableMap::COL_POSX] = true;
        }

        return $this;
    } // setPosx()

    /**
     * Set the value of [posy] column.
     *
     * @param int $v new value
     * @return $this|\Kantaria\Models\Hero The current object (for fluent API support)
     */
    public function setPosy($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->posy !== $v) {
            $this->posy = $v;
            $this->modifiedColumns[HeroTableMap::COL_POSY] = true;
        }

        return $this;
    } // setPosy()

    /**
     * Set the value of [posz] column.
     *
     * @param int $v new value
     * @return $this|\Kantaria\Models\Hero The current object (for fluent API support)
     */
    public function setPosz($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->posz !== $v) {
            $this->posz = $v;
            $this->modifiedColumns[HeroTableMap::COL_POSZ] = true;
        }

        return $this;
    } // setPosz()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : HeroTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : HeroTableMap::translateFieldName('UserId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->user_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : HeroTableMap::translateFieldName('FirstName', TableMap::TYPE_PHPNAME, $indexType)];
            $this->first_name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : HeroTableMap::translateFieldName('LastName', TableMap::TYPE_PHPNAME, $indexType)];
            $this->last_name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : HeroTableMap::translateFieldName('Health', TableMap::TYPE_PHPNAME, $indexType)];
            $this->health = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : HeroTableMap::translateFieldName('Oxygen', TableMap::TYPE_PHPNAME, $indexType)];
            $this->oxygen = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : HeroTableMap::translateFieldName('Food', TableMap::TYPE_PHPNAME, $indexType)];
            $this->food = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : HeroTableMap::translateFieldName('Posx', TableMap::TYPE_PHPNAME, $indexType)];
            $this->posx = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : HeroTableMap::translateFieldName('Posy', TableMap::TYPE_PHPNAME, $indexType)];
            $this->posy = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : HeroTableMap::translateFieldName('Posz', TableMap::TYPE_PHPNAME, $indexType)];
            $this->posz = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 10; // 10 = HeroTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Kantaria\\Models\\Hero'), 0, $e);
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
        if ($this->aUser !== null && $this->user_id !== $this->aUser->getId()) {
            $this->aUser = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(HeroTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildHeroQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aUser = null;
            $this->collInventories = null;

            $this->collQuests = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Hero::setDeleted()
     * @see Hero::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(HeroTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildHeroQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
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

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(HeroTableMap::DATABASE_NAME);
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
                HeroTableMap::addInstanceToPool($this);
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

            if ($this->aUser !== null) {
                if ($this->aUser->isModified() || $this->aUser->isNew()) {
                    $affectedRows += $this->aUser->save($con);
                }
                $this->setUser($this->aUser);
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

            if ($this->inventoriesScheduledForDeletion !== null) {
                if (!$this->inventoriesScheduledForDeletion->isEmpty()) {
                    \Kantaria\Models\InventoryQuery::create()
                        ->filterByPrimaryKeys($this->inventoriesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->inventoriesScheduledForDeletion = null;
                }
            }

            if ($this->collInventories !== null) {
                foreach ($this->collInventories as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->questsScheduledForDeletion !== null) {
                if (!$this->questsScheduledForDeletion->isEmpty()) {
                    \Kantaria\Models\QuestQuery::create()
                        ->filterByPrimaryKeys($this->questsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->questsScheduledForDeletion = null;
                }
            }

            if ($this->collQuests !== null) {
                foreach ($this->collQuests as $referrerFK) {
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

        $this->modifiedColumns[HeroTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . HeroTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(HeroTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(HeroTableMap::COL_USER_ID)) {
            $modifiedColumns[':p' . $index++]  = 'user_id';
        }
        if ($this->isColumnModified(HeroTableMap::COL_FIRST_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'first_name';
        }
        if ($this->isColumnModified(HeroTableMap::COL_LAST_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'last_name';
        }
        if ($this->isColumnModified(HeroTableMap::COL_HEALTH)) {
            $modifiedColumns[':p' . $index++]  = 'health';
        }
        if ($this->isColumnModified(HeroTableMap::COL_OXYGEN)) {
            $modifiedColumns[':p' . $index++]  = 'oxygen';
        }
        if ($this->isColumnModified(HeroTableMap::COL_FOOD)) {
            $modifiedColumns[':p' . $index++]  = 'food';
        }
        if ($this->isColumnModified(HeroTableMap::COL_POSX)) {
            $modifiedColumns[':p' . $index++]  = 'posx';
        }
        if ($this->isColumnModified(HeroTableMap::COL_POSY)) {
            $modifiedColumns[':p' . $index++]  = 'posy';
        }
        if ($this->isColumnModified(HeroTableMap::COL_POSZ)) {
            $modifiedColumns[':p' . $index++]  = 'posz';
        }

        $sql = sprintf(
            'INSERT INTO hero (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'id':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case 'user_id':
                        $stmt->bindValue($identifier, $this->user_id, PDO::PARAM_INT);
                        break;
                    case 'first_name':
                        $stmt->bindValue($identifier, $this->first_name, PDO::PARAM_STR);
                        break;
                    case 'last_name':
                        $stmt->bindValue($identifier, $this->last_name, PDO::PARAM_STR);
                        break;
                    case 'health':
                        $stmt->bindValue($identifier, $this->health, PDO::PARAM_INT);
                        break;
                    case 'oxygen':
                        $stmt->bindValue($identifier, $this->oxygen, PDO::PARAM_INT);
                        break;
                    case 'food':
                        $stmt->bindValue($identifier, $this->food, PDO::PARAM_INT);
                        break;
                    case 'posx':
                        $stmt->bindValue($identifier, $this->posx, PDO::PARAM_INT);
                        break;
                    case 'posy':
                        $stmt->bindValue($identifier, $this->posy, PDO::PARAM_INT);
                        break;
                    case 'posz':
                        $stmt->bindValue($identifier, $this->posz, PDO::PARAM_INT);
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
        $this->setId($pk);

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
        $pos = HeroTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getId();
                break;
            case 1:
                return $this->getUserId();
                break;
            case 2:
                return $this->getFirstName();
                break;
            case 3:
                return $this->getLastName();
                break;
            case 4:
                return $this->getHealth();
                break;
            case 5:
                return $this->getOxygen();
                break;
            case 6:
                return $this->getFood();
                break;
            case 7:
                return $this->getPosx();
                break;
            case 8:
                return $this->getPosy();
                break;
            case 9:
                return $this->getPosz();
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

        if (isset($alreadyDumpedObjects['Hero'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Hero'][$this->hashCode()] = true;
        $keys = HeroTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getUserId(),
            $keys[2] => $this->getFirstName(),
            $keys[3] => $this->getLastName(),
            $keys[4] => $this->getHealth(),
            $keys[5] => $this->getOxygen(),
            $keys[6] => $this->getFood(),
            $keys[7] => $this->getPosx(),
            $keys[8] => $this->getPosy(),
            $keys[9] => $this->getPosz(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aUser) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'user';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'user';
                        break;
                    default:
                        $key = 'User';
                }

                $result[$key] = $this->aUser->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collInventories) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'inventories';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'inventories';
                        break;
                    default:
                        $key = 'Inventories';
                }

                $result[$key] = $this->collInventories->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collQuests) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'quests';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'quests';
                        break;
                    default:
                        $key = 'Quests';
                }

                $result[$key] = $this->collQuests->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\Kantaria\Models\Hero
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = HeroTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Kantaria\Models\Hero
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setUserId($value);
                break;
            case 2:
                $this->setFirstName($value);
                break;
            case 3:
                $this->setLastName($value);
                break;
            case 4:
                $this->setHealth($value);
                break;
            case 5:
                $this->setOxygen($value);
                break;
            case 6:
                $this->setFood($value);
                break;
            case 7:
                $this->setPosx($value);
                break;
            case 8:
                $this->setPosy($value);
                break;
            case 9:
                $this->setPosz($value);
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
        $keys = HeroTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setUserId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setFirstName($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setLastName($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setHealth($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setOxygen($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setFood($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setPosx($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setPosy($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setPosz($arr[$keys[9]]);
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
     * @return $this|\Kantaria\Models\Hero The current object, for fluid interface
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
        $criteria = new Criteria(HeroTableMap::DATABASE_NAME);

        if ($this->isColumnModified(HeroTableMap::COL_ID)) {
            $criteria->add(HeroTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(HeroTableMap::COL_USER_ID)) {
            $criteria->add(HeroTableMap::COL_USER_ID, $this->user_id);
        }
        if ($this->isColumnModified(HeroTableMap::COL_FIRST_NAME)) {
            $criteria->add(HeroTableMap::COL_FIRST_NAME, $this->first_name);
        }
        if ($this->isColumnModified(HeroTableMap::COL_LAST_NAME)) {
            $criteria->add(HeroTableMap::COL_LAST_NAME, $this->last_name);
        }
        if ($this->isColumnModified(HeroTableMap::COL_HEALTH)) {
            $criteria->add(HeroTableMap::COL_HEALTH, $this->health);
        }
        if ($this->isColumnModified(HeroTableMap::COL_OXYGEN)) {
            $criteria->add(HeroTableMap::COL_OXYGEN, $this->oxygen);
        }
        if ($this->isColumnModified(HeroTableMap::COL_FOOD)) {
            $criteria->add(HeroTableMap::COL_FOOD, $this->food);
        }
        if ($this->isColumnModified(HeroTableMap::COL_POSX)) {
            $criteria->add(HeroTableMap::COL_POSX, $this->posx);
        }
        if ($this->isColumnModified(HeroTableMap::COL_POSY)) {
            $criteria->add(HeroTableMap::COL_POSY, $this->posy);
        }
        if ($this->isColumnModified(HeroTableMap::COL_POSZ)) {
            $criteria->add(HeroTableMap::COL_POSZ, $this->posz);
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
        $criteria = ChildHeroQuery::create();
        $criteria->add(HeroTableMap::COL_ID, $this->id);

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
        $validPk = null !== $this->getId();

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
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Kantaria\Models\Hero (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setUserId($this->getUserId());
        $copyObj->setFirstName($this->getFirstName());
        $copyObj->setLastName($this->getLastName());
        $copyObj->setHealth($this->getHealth());
        $copyObj->setOxygen($this->getOxygen());
        $copyObj->setFood($this->getFood());
        $copyObj->setPosx($this->getPosx());
        $copyObj->setPosy($this->getPosy());
        $copyObj->setPosz($this->getPosz());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getInventories() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addInventory($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getQuests() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addQuest($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
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
     * @return \Kantaria\Models\Hero Clone of current object.
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
     * Declares an association between this object and a ChildUser object.
     *
     * @param  ChildUser $v
     * @return $this|\Kantaria\Models\Hero The current object (for fluent API support)
     * @throws PropelException
     */
    public function setUser(ChildUser $v = null)
    {
        if ($v === null) {
            $this->setUserId(NULL);
        } else {
            $this->setUserId($v->getId());
        }

        $this->aUser = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildUser object, it will not be re-added.
        if ($v !== null) {
            $v->addHero($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildUser object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildUser The associated ChildUser object.
     * @throws PropelException
     */
    public function getUser(ConnectionInterface $con = null)
    {
        if ($this->aUser === null && ($this->user_id !== null)) {
            $this->aUser = ChildUserQuery::create()->findPk($this->user_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aUser->addHeros($this);
             */
        }

        return $this->aUser;
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
        if ('Inventory' == $relationName) {
            return $this->initInventories();
        }
        if ('Quest' == $relationName) {
            return $this->initQuests();
        }
    }

    /**
     * Clears out the collInventories collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addInventories()
     */
    public function clearInventories()
    {
        $this->collInventories = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collInventories collection loaded partially.
     */
    public function resetPartialInventories($v = true)
    {
        $this->collInventoriesPartial = $v;
    }

    /**
     * Initializes the collInventories collection.
     *
     * By default this just sets the collInventories collection to an empty array (like clearcollInventories());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initInventories($overrideExisting = true)
    {
        if (null !== $this->collInventories && !$overrideExisting) {
            return;
        }

        $collectionClassName = InventoryTableMap::getTableMap()->getCollectionClassName();

        $this->collInventories = new $collectionClassName;
        $this->collInventories->setModel('\Kantaria\Models\Inventory');
    }

    /**
     * Gets an array of ChildInventory objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildHero is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildInventory[] List of ChildInventory objects
     * @throws PropelException
     */
    public function getInventories(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collInventoriesPartial && !$this->isNew();
        if (null === $this->collInventories || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collInventories) {
                // return empty collection
                $this->initInventories();
            } else {
                $collInventories = ChildInventoryQuery::create(null, $criteria)
                    ->filterByHero($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collInventoriesPartial && count($collInventories)) {
                        $this->initInventories(false);

                        foreach ($collInventories as $obj) {
                            if (false == $this->collInventories->contains($obj)) {
                                $this->collInventories->append($obj);
                            }
                        }

                        $this->collInventoriesPartial = true;
                    }

                    return $collInventories;
                }

                if ($partial && $this->collInventories) {
                    foreach ($this->collInventories as $obj) {
                        if ($obj->isNew()) {
                            $collInventories[] = $obj;
                        }
                    }
                }

                $this->collInventories = $collInventories;
                $this->collInventoriesPartial = false;
            }
        }

        return $this->collInventories;
    }

    /**
     * Sets a collection of ChildInventory objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $inventories A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildHero The current object (for fluent API support)
     */
    public function setInventories(Collection $inventories, ConnectionInterface $con = null)
    {
        /** @var ChildInventory[] $inventoriesToDelete */
        $inventoriesToDelete = $this->getInventories(new Criteria(), $con)->diff($inventories);


        $this->inventoriesScheduledForDeletion = $inventoriesToDelete;

        foreach ($inventoriesToDelete as $inventoryRemoved) {
            $inventoryRemoved->setHero(null);
        }

        $this->collInventories = null;
        foreach ($inventories as $inventory) {
            $this->addInventory($inventory);
        }

        $this->collInventories = $inventories;
        $this->collInventoriesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Inventory objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Inventory objects.
     * @throws PropelException
     */
    public function countInventories(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collInventoriesPartial && !$this->isNew();
        if (null === $this->collInventories || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collInventories) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getInventories());
            }

            $query = ChildInventoryQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByHero($this)
                ->count($con);
        }

        return count($this->collInventories);
    }

    /**
     * Method called to associate a ChildInventory object to this object
     * through the ChildInventory foreign key attribute.
     *
     * @param  ChildInventory $l ChildInventory
     * @return $this|\Kantaria\Models\Hero The current object (for fluent API support)
     */
    public function addInventory(ChildInventory $l)
    {
        if ($this->collInventories === null) {
            $this->initInventories();
            $this->collInventoriesPartial = true;
        }

        if (!$this->collInventories->contains($l)) {
            $this->doAddInventory($l);

            if ($this->inventoriesScheduledForDeletion and $this->inventoriesScheduledForDeletion->contains($l)) {
                $this->inventoriesScheduledForDeletion->remove($this->inventoriesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildInventory $inventory The ChildInventory object to add.
     */
    protected function doAddInventory(ChildInventory $inventory)
    {
        $this->collInventories[]= $inventory;
        $inventory->setHero($this);
    }

    /**
     * @param  ChildInventory $inventory The ChildInventory object to remove.
     * @return $this|ChildHero The current object (for fluent API support)
     */
    public function removeInventory(ChildInventory $inventory)
    {
        if ($this->getInventories()->contains($inventory)) {
            $pos = $this->collInventories->search($inventory);
            $this->collInventories->remove($pos);
            if (null === $this->inventoriesScheduledForDeletion) {
                $this->inventoriesScheduledForDeletion = clone $this->collInventories;
                $this->inventoriesScheduledForDeletion->clear();
            }
            $this->inventoriesScheduledForDeletion[]= clone $inventory;
            $inventory->setHero(null);
        }

        return $this;
    }

    /**
     * Clears out the collQuests collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addQuests()
     */
    public function clearQuests()
    {
        $this->collQuests = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collQuests collection loaded partially.
     */
    public function resetPartialQuests($v = true)
    {
        $this->collQuestsPartial = $v;
    }

    /**
     * Initializes the collQuests collection.
     *
     * By default this just sets the collQuests collection to an empty array (like clearcollQuests());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initQuests($overrideExisting = true)
    {
        if (null !== $this->collQuests && !$overrideExisting) {
            return;
        }

        $collectionClassName = QuestTableMap::getTableMap()->getCollectionClassName();

        $this->collQuests = new $collectionClassName;
        $this->collQuests->setModel('\Kantaria\Models\Quest');
    }

    /**
     * Gets an array of ChildQuest objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildHero is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildQuest[] List of ChildQuest objects
     * @throws PropelException
     */
    public function getQuests(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collQuestsPartial && !$this->isNew();
        if (null === $this->collQuests || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collQuests) {
                // return empty collection
                $this->initQuests();
            } else {
                $collQuests = ChildQuestQuery::create(null, $criteria)
                    ->filterByHero($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collQuestsPartial && count($collQuests)) {
                        $this->initQuests(false);

                        foreach ($collQuests as $obj) {
                            if (false == $this->collQuests->contains($obj)) {
                                $this->collQuests->append($obj);
                            }
                        }

                        $this->collQuestsPartial = true;
                    }

                    return $collQuests;
                }

                if ($partial && $this->collQuests) {
                    foreach ($this->collQuests as $obj) {
                        if ($obj->isNew()) {
                            $collQuests[] = $obj;
                        }
                    }
                }

                $this->collQuests = $collQuests;
                $this->collQuestsPartial = false;
            }
        }

        return $this->collQuests;
    }

    /**
     * Sets a collection of ChildQuest objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $quests A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildHero The current object (for fluent API support)
     */
    public function setQuests(Collection $quests, ConnectionInterface $con = null)
    {
        /** @var ChildQuest[] $questsToDelete */
        $questsToDelete = $this->getQuests(new Criteria(), $con)->diff($quests);


        $this->questsScheduledForDeletion = $questsToDelete;

        foreach ($questsToDelete as $questRemoved) {
            $questRemoved->setHero(null);
        }

        $this->collQuests = null;
        foreach ($quests as $quest) {
            $this->addQuest($quest);
        }

        $this->collQuests = $quests;
        $this->collQuestsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Quest objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Quest objects.
     * @throws PropelException
     */
    public function countQuests(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collQuestsPartial && !$this->isNew();
        if (null === $this->collQuests || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collQuests) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getQuests());
            }

            $query = ChildQuestQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByHero($this)
                ->count($con);
        }

        return count($this->collQuests);
    }

    /**
     * Method called to associate a ChildQuest object to this object
     * through the ChildQuest foreign key attribute.
     *
     * @param  ChildQuest $l ChildQuest
     * @return $this|\Kantaria\Models\Hero The current object (for fluent API support)
     */
    public function addQuest(ChildQuest $l)
    {
        if ($this->collQuests === null) {
            $this->initQuests();
            $this->collQuestsPartial = true;
        }

        if (!$this->collQuests->contains($l)) {
            $this->doAddQuest($l);

            if ($this->questsScheduledForDeletion and $this->questsScheduledForDeletion->contains($l)) {
                $this->questsScheduledForDeletion->remove($this->questsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildQuest $quest The ChildQuest object to add.
     */
    protected function doAddQuest(ChildQuest $quest)
    {
        $this->collQuests[]= $quest;
        $quest->setHero($this);
    }

    /**
     * @param  ChildQuest $quest The ChildQuest object to remove.
     * @return $this|ChildHero The current object (for fluent API support)
     */
    public function removeQuest(ChildQuest $quest)
    {
        if ($this->getQuests()->contains($quest)) {
            $pos = $this->collQuests->search($quest);
            $this->collQuests->remove($pos);
            if (null === $this->questsScheduledForDeletion) {
                $this->questsScheduledForDeletion = clone $this->collQuests;
                $this->questsScheduledForDeletion->clear();
            }
            $this->questsScheduledForDeletion[]= clone $quest;
            $quest->setHero(null);
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
        if (null !== $this->aUser) {
            $this->aUser->removeHero($this);
        }
        $this->id = null;
        $this->user_id = null;
        $this->first_name = null;
        $this->last_name = null;
        $this->health = null;
        $this->oxygen = null;
        $this->food = null;
        $this->posx = null;
        $this->posy = null;
        $this->posz = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
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
            if ($this->collInventories) {
                foreach ($this->collInventories as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collQuests) {
                foreach ($this->collQuests as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collInventories = null;
        $this->collQuests = null;
        $this->aUser = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(HeroTableMap::DEFAULT_STRING_FORMAT);
    }

    // validate behavior

    /**
     * Configure validators constraints. The Validator object uses this method
     * to perform object validation.
     *
     * @param ClassMetadata $metadata
     */
    static public function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('user_id', new NotNull());
        $metadata->addPropertyConstraint('first_name', new NotNull());
        $metadata->addPropertyConstraint('last_name', new NotNull());
    }

    /**
     * Validates the object and all objects related to this table.
     *
     * @see        getValidationFailures()
     * @param      ValidatorInterface|null $validator A Validator class instance
     * @return     boolean Whether all objects pass validation.
     */
    public function validate(ValidatorInterface $validator = null)
    {
        if (null === $validator) {
            $validator = new RecursiveValidator(
                new ExecutionContextFactory(new IdentityTranslator()),
                new LazyLoadingMetadataFactory(new StaticMethodLoader()),
                new ConstraintValidatorFactory()
            );
        }

        $failureMap = new ConstraintViolationList();

        if (!$this->alreadyInValidation) {
            $this->alreadyInValidation = true;
            $retval = null;

            // We call the validate method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            // If validate() method exists, the validate-behavior is configured for related object
            if (method_exists($this->aUser, 'validate')) {
                if (!$this->aUser->validate($validator)) {
                    $failureMap->addAll($this->aUser->getValidationFailures());
                }
            }

            $retval = $validator->validate($this);
            if (count($retval) > 0) {
                $failureMap->addAll($retval);
            }

            if (null !== $this->collInventories) {
                foreach ($this->collInventories as $referrerFK) {
                    if (method_exists($referrerFK, 'validate')) {
                        if (!$referrerFK->validate($validator)) {
                            $failureMap->addAll($referrerFK->getValidationFailures());
                        }
                    }
                }
            }
            if (null !== $this->collQuests) {
                foreach ($this->collQuests as $referrerFK) {
                    if (method_exists($referrerFK, 'validate')) {
                        if (!$referrerFK->validate($validator)) {
                            $failureMap->addAll($referrerFK->getValidationFailures());
                        }
                    }
                }
            }

            $this->alreadyInValidation = false;
        }

        $this->validationFailures = $failureMap;

        return (Boolean) (!(count($this->validationFailures) > 0));

    }

    /**
     * Gets any ConstraintViolation objects that resulted from last call to validate().
     *
     *
     * @return     object ConstraintViolationList
     * @see        validate()
     */
    public function getValidationFailures()
    {
        return $this->validationFailures;
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
