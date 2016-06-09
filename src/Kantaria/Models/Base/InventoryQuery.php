<?php

namespace Kantaria\Models\Base;

use \Exception;
use \PDO;
use Kantaria\Models\Inventory as ChildInventory;
use Kantaria\Models\InventoryQuery as ChildInventoryQuery;
use Kantaria\Models\Map\InventoryTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'inventory' table.
 *
 *
 *
 * @method     ChildInventoryQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildInventoryQuery orderByCharacterId($order = Criteria::ASC) Order by the character_id column
 * @method     ChildInventoryQuery orderBySlot($order = Criteria::ASC) Order by the slot column
 * @method     ChildInventoryQuery orderByItem($order = Criteria::ASC) Order by the item column
 * @method     ChildInventoryQuery orderByAmount($order = Criteria::ASC) Order by the amount column
 *
 * @method     ChildInventoryQuery groupById() Group by the id column
 * @method     ChildInventoryQuery groupByCharacterId() Group by the character_id column
 * @method     ChildInventoryQuery groupBySlot() Group by the slot column
 * @method     ChildInventoryQuery groupByItem() Group by the item column
 * @method     ChildInventoryQuery groupByAmount() Group by the amount column
 *
 * @method     ChildInventoryQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildInventoryQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildInventoryQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildInventoryQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildInventoryQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildInventoryQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildInventoryQuery leftJoinCharacter($relationAlias = null) Adds a LEFT JOIN clause to the query using the Character relation
 * @method     ChildInventoryQuery rightJoinCharacter($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Character relation
 * @method     ChildInventoryQuery innerJoinCharacter($relationAlias = null) Adds a INNER JOIN clause to the query using the Character relation
 *
 * @method     ChildInventoryQuery joinWithCharacter($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Character relation
 *
 * @method     ChildInventoryQuery leftJoinWithCharacter() Adds a LEFT JOIN clause and with to the query using the Character relation
 * @method     ChildInventoryQuery rightJoinWithCharacter() Adds a RIGHT JOIN clause and with to the query using the Character relation
 * @method     ChildInventoryQuery innerJoinWithCharacter() Adds a INNER JOIN clause and with to the query using the Character relation
 *
 * @method     \Kantaria\Models\CharacterQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildInventory findOne(ConnectionInterface $con = null) Return the first ChildInventory matching the query
 * @method     ChildInventory findOneOrCreate(ConnectionInterface $con = null) Return the first ChildInventory matching the query, or a new ChildInventory object populated from the query conditions when no match is found
 *
 * @method     ChildInventory findOneById(int $id) Return the first ChildInventory filtered by the id column
 * @method     ChildInventory findOneByCharacterId(int $character_id) Return the first ChildInventory filtered by the character_id column
 * @method     ChildInventory findOneBySlot(int $slot) Return the first ChildInventory filtered by the slot column
 * @method     ChildInventory findOneByItem(string $item) Return the first ChildInventory filtered by the item column
 * @method     ChildInventory findOneByAmount(int $amount) Return the first ChildInventory filtered by the amount column *

 * @method     ChildInventory requirePk($key, ConnectionInterface $con = null) Return the ChildInventory by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInventory requireOne(ConnectionInterface $con = null) Return the first ChildInventory matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildInventory requireOneById(int $id) Return the first ChildInventory filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInventory requireOneByCharacterId(int $character_id) Return the first ChildInventory filtered by the character_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInventory requireOneBySlot(int $slot) Return the first ChildInventory filtered by the slot column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInventory requireOneByItem(string $item) Return the first ChildInventory filtered by the item column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildInventory requireOneByAmount(int $amount) Return the first ChildInventory filtered by the amount column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildInventory[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildInventory objects based on current ModelCriteria
 * @method     ChildInventory[]|ObjectCollection findById(int $id) Return ChildInventory objects filtered by the id column
 * @method     ChildInventory[]|ObjectCollection findByCharacterId(int $character_id) Return ChildInventory objects filtered by the character_id column
 * @method     ChildInventory[]|ObjectCollection findBySlot(int $slot) Return ChildInventory objects filtered by the slot column
 * @method     ChildInventory[]|ObjectCollection findByItem(string $item) Return ChildInventory objects filtered by the item column
 * @method     ChildInventory[]|ObjectCollection findByAmount(int $amount) Return ChildInventory objects filtered by the amount column
 * @method     ChildInventory[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class InventoryQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Kantaria\Models\Base\InventoryQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Kantaria\\Models\\Inventory', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildInventoryQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildInventoryQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildInventoryQuery) {
            return $criteria;
        }
        $query = new ChildInventoryQuery();
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
     * @return ChildInventory|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(InventoryTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = InventoryTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildInventory A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, character_id, slot, item, amount FROM inventory WHERE id = :p0';
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
            /** @var ChildInventory $obj */
            $obj = new ChildInventory();
            $obj->hydrate($row);
            InventoryTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildInventory|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildInventoryQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(InventoryTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildInventoryQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(InventoryTableMap::COL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildInventoryQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(InventoryTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(InventoryTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(InventoryTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the character_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCharacterId(1234); // WHERE character_id = 1234
     * $query->filterByCharacterId(array(12, 34)); // WHERE character_id IN (12, 34)
     * $query->filterByCharacterId(array('min' => 12)); // WHERE character_id > 12
     * </code>
     *
     * @see       filterByCharacter()
     *
     * @param     mixed $characterId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildInventoryQuery The current query, for fluid interface
     */
    public function filterByCharacterId($characterId = null, $comparison = null)
    {
        if (is_array($characterId)) {
            $useMinMax = false;
            if (isset($characterId['min'])) {
                $this->addUsingAlias(InventoryTableMap::COL_CHARACTER_ID, $characterId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($characterId['max'])) {
                $this->addUsingAlias(InventoryTableMap::COL_CHARACTER_ID, $characterId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(InventoryTableMap::COL_CHARACTER_ID, $characterId, $comparison);
    }

    /**
     * Filter the query on the slot column
     *
     * Example usage:
     * <code>
     * $query->filterBySlot(1234); // WHERE slot = 1234
     * $query->filterBySlot(array(12, 34)); // WHERE slot IN (12, 34)
     * $query->filterBySlot(array('min' => 12)); // WHERE slot > 12
     * </code>
     *
     * @param     mixed $slot The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildInventoryQuery The current query, for fluid interface
     */
    public function filterBySlot($slot = null, $comparison = null)
    {
        if (is_array($slot)) {
            $useMinMax = false;
            if (isset($slot['min'])) {
                $this->addUsingAlias(InventoryTableMap::COL_SLOT, $slot['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($slot['max'])) {
                $this->addUsingAlias(InventoryTableMap::COL_SLOT, $slot['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(InventoryTableMap::COL_SLOT, $slot, $comparison);
    }

    /**
     * Filter the query on the item column
     *
     * Example usage:
     * <code>
     * $query->filterByItem('fooValue');   // WHERE item = 'fooValue'
     * $query->filterByItem('%fooValue%'); // WHERE item LIKE '%fooValue%'
     * </code>
     *
     * @param     string $item The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildInventoryQuery The current query, for fluid interface
     */
    public function filterByItem($item = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($item)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $item)) {
                $item = str_replace('*', '%', $item);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(InventoryTableMap::COL_ITEM, $item, $comparison);
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
     * @return $this|ChildInventoryQuery The current query, for fluid interface
     */
    public function filterByAmount($amount = null, $comparison = null)
    {
        if (is_array($amount)) {
            $useMinMax = false;
            if (isset($amount['min'])) {
                $this->addUsingAlias(InventoryTableMap::COL_AMOUNT, $amount['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($amount['max'])) {
                $this->addUsingAlias(InventoryTableMap::COL_AMOUNT, $amount['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(InventoryTableMap::COL_AMOUNT, $amount, $comparison);
    }

    /**
     * Filter the query by a related \Kantaria\Models\Character object
     *
     * @param \Kantaria\Models\Character|ObjectCollection $character The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildInventoryQuery The current query, for fluid interface
     */
    public function filterByCharacter($character, $comparison = null)
    {
        if ($character instanceof \Kantaria\Models\Character) {
            return $this
                ->addUsingAlias(InventoryTableMap::COL_CHARACTER_ID, $character->getId(), $comparison);
        } elseif ($character instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(InventoryTableMap::COL_CHARACTER_ID, $character->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByCharacter() only accepts arguments of type \Kantaria\Models\Character or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Character relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildInventoryQuery The current query, for fluid interface
     */
    public function joinCharacter($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Character');

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
            $this->addJoinObject($join, 'Character');
        }

        return $this;
    }

    /**
     * Use the Character relation Character object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Kantaria\Models\CharacterQuery A secondary query class using the current class as primary query
     */
    public function useCharacterQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCharacter($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Character', '\Kantaria\Models\CharacterQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildInventory $inventory Object to remove from the list of results
     *
     * @return $this|ChildInventoryQuery The current query, for fluid interface
     */
    public function prune($inventory = null)
    {
        if ($inventory) {
            $this->addUsingAlias(InventoryTableMap::COL_ID, $inventory->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the inventory table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(InventoryTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            InventoryTableMap::clearInstancePool();
            InventoryTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(InventoryTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(InventoryTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            InventoryTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            InventoryTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // InventoryQuery
