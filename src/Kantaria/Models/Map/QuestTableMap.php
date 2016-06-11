<?php

namespace Kantaria\Models\Map;

use Kantaria\Models\Quest;
use Kantaria\Models\QuestQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'quest' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class QuestTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'Kantaria.Models.Map.QuestTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'quest';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Kantaria\\Models\\Quest';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Kantaria.Models.Quest';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 8;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 8;

    /**
     * the column name for the id field
     */
    const COL_ID = 'quest.id';

    /**
     * the column name for the character_id field
     */
    const COL_CHARACTER_ID = 'quest.character_id';

    /**
     * the column name for the quest field
     */
    const COL_QUEST = 'quest.quest';

    /**
     * the column name for the completed field
     */
    const COL_COMPLETED = 'quest.completed';

    /**
     * the column name for the task1 field
     */
    const COL_TASK1 = 'quest.task1';

    /**
     * the column name for the task2 field
     */
    const COL_TASK2 = 'quest.task2';

    /**
     * the column name for the task3 field
     */
    const COL_TASK3 = 'quest.task3';

    /**
     * the column name for the task4 field
     */
    const COL_TASK4 = 'quest.task4';

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
        self::TYPE_PHPNAME       => array('Id', 'CharacterId', 'Quest', 'Completed', 'Task1', 'Task2', 'Task3', 'Task4', ),
        self::TYPE_CAMELNAME     => array('id', 'characterId', 'quest', 'completed', 'task1', 'task2', 'task3', 'task4', ),
        self::TYPE_COLNAME       => array(QuestTableMap::COL_ID, QuestTableMap::COL_CHARACTER_ID, QuestTableMap::COL_QUEST, QuestTableMap::COL_COMPLETED, QuestTableMap::COL_TASK1, QuestTableMap::COL_TASK2, QuestTableMap::COL_TASK3, QuestTableMap::COL_TASK4, ),
        self::TYPE_FIELDNAME     => array('id', 'character_id', 'quest', 'completed', 'task1', 'task2', 'task3', 'task4', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'CharacterId' => 1, 'Quest' => 2, 'Completed' => 3, 'Task1' => 4, 'Task2' => 5, 'Task3' => 6, 'Task4' => 7, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'characterId' => 1, 'quest' => 2, 'completed' => 3, 'task1' => 4, 'task2' => 5, 'task3' => 6, 'task4' => 7, ),
        self::TYPE_COLNAME       => array(QuestTableMap::COL_ID => 0, QuestTableMap::COL_CHARACTER_ID => 1, QuestTableMap::COL_QUEST => 2, QuestTableMap::COL_COMPLETED => 3, QuestTableMap::COL_TASK1 => 4, QuestTableMap::COL_TASK2 => 5, QuestTableMap::COL_TASK3 => 6, QuestTableMap::COL_TASK4 => 7, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'character_id' => 1, 'quest' => 2, 'completed' => 3, 'task1' => 4, 'task2' => 5, 'task3' => 6, 'task4' => 7, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, )
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
        $this->setName('quest');
        $this->setPhpName('Quest');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Kantaria\\Models\\Quest');
        $this->setPackage('Kantaria.Models');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('character_id', 'CharacterId', 'INTEGER', 'character', 'id', true, null, null);
        $this->addColumn('quest', 'Quest', 'VARCHAR', true, 70, null);
        $this->addColumn('completed', 'Completed', 'TINYINT', true, null, null);
        $this->addColumn('task1', 'Task1', 'INTEGER', true, null, null);
        $this->addColumn('task2', 'Task2', 'INTEGER', true, null, null);
        $this->addColumn('task3', 'Task3', 'INTEGER', true, null, null);
        $this->addColumn('task4', 'Task4', 'INTEGER', true, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Character', '\\Kantaria\\Models\\Character', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':character_id',
    1 => ':id',
  ),
), null, null, null, false);
    } // buildRelations()

    /**
     *
     * Gets the list of behaviors registered for this table
     *
     * @return array Associative array (name => parameters) of behaviors
     */
    public function getBehaviors()
    {
        return array(
            'validate' => array('characterIdNotNull' => array ('column' => 'character_id','validator' => 'NotNull',), 'questNotNull' => array ('column' => 'quest','validator' => 'NotNull',), 'completedNotNull' => array ('column' => 'completed','validator' => 'NotNull',), 'task1NotNull' => array ('column' => 'task1','validator' => 'NotNull',), 'task2NotNull' => array ('column' => 'task2','validator' => 'NotNull',), 'task3NotNull' => array ('column' => 'task3','validator' => 'NotNull',), 'task4NotNull' => array ('column' => 'task4','validator' => 'NotNull',), ),
        );
    } // getBehaviors()

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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
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
        return (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? QuestTableMap::CLASS_DEFAULT : QuestTableMap::OM_CLASS;
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
     * @return array           (Quest object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = QuestTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = QuestTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + QuestTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = QuestTableMap::OM_CLASS;
            /** @var Quest $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            QuestTableMap::addInstanceToPool($obj, $key);
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
            $key = QuestTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = QuestTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Quest $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                QuestTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(QuestTableMap::COL_ID);
            $criteria->addSelectColumn(QuestTableMap::COL_CHARACTER_ID);
            $criteria->addSelectColumn(QuestTableMap::COL_QUEST);
            $criteria->addSelectColumn(QuestTableMap::COL_COMPLETED);
            $criteria->addSelectColumn(QuestTableMap::COL_TASK1);
            $criteria->addSelectColumn(QuestTableMap::COL_TASK2);
            $criteria->addSelectColumn(QuestTableMap::COL_TASK3);
            $criteria->addSelectColumn(QuestTableMap::COL_TASK4);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.character_id');
            $criteria->addSelectColumn($alias . '.quest');
            $criteria->addSelectColumn($alias . '.completed');
            $criteria->addSelectColumn($alias . '.task1');
            $criteria->addSelectColumn($alias . '.task2');
            $criteria->addSelectColumn($alias . '.task3');
            $criteria->addSelectColumn($alias . '.task4');
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
        return Propel::getServiceContainer()->getDatabaseMap(QuestTableMap::DATABASE_NAME)->getTable(QuestTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(QuestTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(QuestTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new QuestTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Quest or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Quest object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(QuestTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Kantaria\Models\Quest) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(QuestTableMap::DATABASE_NAME);
            $criteria->add(QuestTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = QuestQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            QuestTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                QuestTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the quest table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return QuestQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Quest or Criteria object.
     *
     * @param mixed               $criteria Criteria or Quest object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(QuestTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Quest object
        }

        if ($criteria->containsKey(QuestTableMap::COL_ID) && $criteria->keyContainsValue(QuestTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.QuestTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = QuestQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // QuestTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
QuestTableMap::buildTableMap();
