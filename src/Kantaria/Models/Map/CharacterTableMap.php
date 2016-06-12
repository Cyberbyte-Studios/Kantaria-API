<?php

namespace Kantaria\Models\Map;

use Kantaria\Models\Character;
use Kantaria\Models\CharacterQuery;
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
 * This class defines the structure of the 'character' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class CharacterTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'Kantaria.Models.Map.CharacterTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'character';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Kantaria\\Models\\Character';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Kantaria.Models.Character';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 10;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 10;

    /**
     * the column name for the id field
     */
    const COL_ID = 'character.id';

    /**
     * the column name for the user_id field
     */
    const COL_USER_ID = 'character.user_id';

    /**
     * the column name for the first_name field
     */
    const COL_FIRST_NAME = 'character.first_name';

    /**
     * the column name for the last_name field
     */
    const COL_LAST_NAME = 'character.last_name';

    /**
     * the column name for the health field
     */
    const COL_HEALTH = 'character.health';

    /**
     * the column name for the oxygen field
     */
    const COL_OXYGEN = 'character.oxygen';

    /**
     * the column name for the food field
     */
    const COL_FOOD = 'character.food';

    /**
     * the column name for the posx field
     */
    const COL_POSX = 'character.posx';

    /**
     * the column name for the posy field
     */
    const COL_POSY = 'character.posy';

    /**
     * the column name for the posz field
     */
    const COL_POSZ = 'character.posz';

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
        self::TYPE_PHPNAME       => array('Id', 'UserId', 'FirstName', 'LastName', 'Health', 'Oxygen', 'Food', 'Posx', 'Posy', 'Posz', ),
        self::TYPE_CAMELNAME     => array('id', 'userId', 'firstName', 'lastName', 'health', 'oxygen', 'food', 'posx', 'posy', 'posz', ),
        self::TYPE_COLNAME       => array(CharacterTableMap::COL_ID, CharacterTableMap::COL_USER_ID, CharacterTableMap::COL_FIRST_NAME, CharacterTableMap::COL_LAST_NAME, CharacterTableMap::COL_HEALTH, CharacterTableMap::COL_OXYGEN, CharacterTableMap::COL_FOOD, CharacterTableMap::COL_POSX, CharacterTableMap::COL_POSY, CharacterTableMap::COL_POSZ, ),
        self::TYPE_FIELDNAME     => array('id', 'user_id', 'first_name', 'last_name', 'health', 'oxygen', 'food', 'posx', 'posy', 'posz', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'UserId' => 1, 'FirstName' => 2, 'LastName' => 3, 'Health' => 4, 'Oxygen' => 5, 'Food' => 6, 'Posx' => 7, 'Posy' => 8, 'Posz' => 9, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'userId' => 1, 'firstName' => 2, 'lastName' => 3, 'health' => 4, 'oxygen' => 5, 'food' => 6, 'posx' => 7, 'posy' => 8, 'posz' => 9, ),
        self::TYPE_COLNAME       => array(CharacterTableMap::COL_ID => 0, CharacterTableMap::COL_USER_ID => 1, CharacterTableMap::COL_FIRST_NAME => 2, CharacterTableMap::COL_LAST_NAME => 3, CharacterTableMap::COL_HEALTH => 4, CharacterTableMap::COL_OXYGEN => 5, CharacterTableMap::COL_FOOD => 6, CharacterTableMap::COL_POSX => 7, CharacterTableMap::COL_POSY => 8, CharacterTableMap::COL_POSZ => 9, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'user_id' => 1, 'first_name' => 2, 'last_name' => 3, 'health' => 4, 'oxygen' => 5, 'food' => 6, 'posx' => 7, 'posy' => 8, 'posz' => 9, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
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
        $this->setName('character');
        $this->setPhpName('Character');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Kantaria\\Models\\Character');
        $this->setPackage('Kantaria.Models');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('user_id', 'UserId', 'INTEGER', 'user', 'id', true, null, null);
        $this->addColumn('first_name', 'FirstName', 'VARCHAR', true, 128, null);
        $this->addColumn('last_name', 'LastName', 'VARCHAR', true, 128, null);
        $this->addColumn('health', 'Health', 'INTEGER', false, null, null);
        $this->addColumn('oxygen', 'Oxygen', 'INTEGER', false, null, null);
        $this->addColumn('food', 'Food', 'INTEGER', false, null, null);
        $this->addColumn('posx', 'Posx', 'INTEGER', false, null, null);
        $this->addColumn('posy', 'Posy', 'INTEGER', false, null, null);
        $this->addColumn('posz', 'Posz', 'INTEGER', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('User', '\\Kantaria\\Models\\User', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':user_id',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('Inventory', '\\Kantaria\\Models\\Inventory', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':character_id',
    1 => ':id',
  ),
), null, null, 'Inventories', false);
        $this->addRelation('Quest', '\\Kantaria\\Models\\Quest', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':character_id',
    1 => ':id',
  ),
), null, null, 'Quests', false);
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
            'validate' => array('userIdNotNull' => array ('column' => 'user_id','validator' => 'NotNull',), 'firstNameNotNull' => array ('column' => 'first_name','validator' => 'NotNull',), 'lastNameNotNull' => array ('column' => 'last_name','validator' => 'NotNull',), ),
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
        return $withPrefix ? CharacterTableMap::CLASS_DEFAULT : CharacterTableMap::OM_CLASS;
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
     * @return array           (Character object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = CharacterTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = CharacterTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + CharacterTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = CharacterTableMap::OM_CLASS;
            /** @var Character $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            CharacterTableMap::addInstanceToPool($obj, $key);
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
            $key = CharacterTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = CharacterTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Character $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                CharacterTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(CharacterTableMap::COL_ID);
            $criteria->addSelectColumn(CharacterTableMap::COL_USER_ID);
            $criteria->addSelectColumn(CharacterTableMap::COL_FIRST_NAME);
            $criteria->addSelectColumn(CharacterTableMap::COL_LAST_NAME);
            $criteria->addSelectColumn(CharacterTableMap::COL_HEALTH);
            $criteria->addSelectColumn(CharacterTableMap::COL_OXYGEN);
            $criteria->addSelectColumn(CharacterTableMap::COL_FOOD);
            $criteria->addSelectColumn(CharacterTableMap::COL_POSX);
            $criteria->addSelectColumn(CharacterTableMap::COL_POSY);
            $criteria->addSelectColumn(CharacterTableMap::COL_POSZ);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.user_id');
            $criteria->addSelectColumn($alias . '.first_name');
            $criteria->addSelectColumn($alias . '.last_name');
            $criteria->addSelectColumn($alias . '.health');
            $criteria->addSelectColumn($alias . '.oxygen');
            $criteria->addSelectColumn($alias . '.food');
            $criteria->addSelectColumn($alias . '.posx');
            $criteria->addSelectColumn($alias . '.posy');
            $criteria->addSelectColumn($alias . '.posz');
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
        return Propel::getServiceContainer()->getDatabaseMap(CharacterTableMap::DATABASE_NAME)->getTable(CharacterTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(CharacterTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(CharacterTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new CharacterTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Character or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Character object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(CharacterTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Kantaria\Models\Character) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(CharacterTableMap::DATABASE_NAME);
            $criteria->add(CharacterTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = CharacterQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            CharacterTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                CharacterTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the character table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return CharacterQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Character or Criteria object.
     *
     * @param mixed               $criteria Criteria or Character object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CharacterTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Character object
        }

        if ($criteria->containsKey(CharacterTableMap::COL_ID) && $criteria->keyContainsValue(CharacterTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.CharacterTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = CharacterQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // CharacterTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
CharacterTableMap::buildTableMap();
