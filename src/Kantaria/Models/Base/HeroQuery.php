<?php

namespace Kantaria\Models\Base;

use \Exception;
use \PDO;
use Kantaria\Models\Hero as ChildHero;
use Kantaria\Models\HeroQuery as ChildHeroQuery;
use Kantaria\Models\Map\HeroTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'hero' table.
 *
 *
 *
 * @method     ChildHeroQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildHeroQuery orderByUserId($order = Criteria::ASC) Order by the user_id column
 * @method     ChildHeroQuery orderByFirstName($order = Criteria::ASC) Order by the first_name column
 * @method     ChildHeroQuery orderByLastName($order = Criteria::ASC) Order by the last_name column
 * @method     ChildHeroQuery orderByHealth($order = Criteria::ASC) Order by the health column
 * @method     ChildHeroQuery orderByOxygen($order = Criteria::ASC) Order by the oxygen column
 * @method     ChildHeroQuery orderByFood($order = Criteria::ASC) Order by the food column
 * @method     ChildHeroQuery orderByPosx($order = Criteria::ASC) Order by the posx column
 * @method     ChildHeroQuery orderByPosy($order = Criteria::ASC) Order by the posy column
 * @method     ChildHeroQuery orderByPosz($order = Criteria::ASC) Order by the posz column
 *
 * @method     ChildHeroQuery groupById() Group by the id column
 * @method     ChildHeroQuery groupByUserId() Group by the user_id column
 * @method     ChildHeroQuery groupByFirstName() Group by the first_name column
 * @method     ChildHeroQuery groupByLastName() Group by the last_name column
 * @method     ChildHeroQuery groupByHealth() Group by the health column
 * @method     ChildHeroQuery groupByOxygen() Group by the oxygen column
 * @method     ChildHeroQuery groupByFood() Group by the food column
 * @method     ChildHeroQuery groupByPosx() Group by the posx column
 * @method     ChildHeroQuery groupByPosy() Group by the posy column
 * @method     ChildHeroQuery groupByPosz() Group by the posz column
 *
 * @method     ChildHeroQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildHeroQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildHeroQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildHeroQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildHeroQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildHeroQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildHeroQuery leftJoinUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the User relation
 * @method     ChildHeroQuery rightJoinUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the User relation
 * @method     ChildHeroQuery innerJoinUser($relationAlias = null) Adds a INNER JOIN clause to the query using the User relation
 *
 * @method     ChildHeroQuery joinWithUser($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the User relation
 *
 * @method     ChildHeroQuery leftJoinWithUser() Adds a LEFT JOIN clause and with to the query using the User relation
 * @method     ChildHeroQuery rightJoinWithUser() Adds a RIGHT JOIN clause and with to the query using the User relation
 * @method     ChildHeroQuery innerJoinWithUser() Adds a INNER JOIN clause and with to the query using the User relation
 *
 * @method     ChildHeroQuery leftJoinInventory($relationAlias = null) Adds a LEFT JOIN clause to the query using the Inventory relation
 * @method     ChildHeroQuery rightJoinInventory($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Inventory relation
 * @method     ChildHeroQuery innerJoinInventory($relationAlias = null) Adds a INNER JOIN clause to the query using the Inventory relation
 *
 * @method     ChildHeroQuery joinWithInventory($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Inventory relation
 *
 * @method     ChildHeroQuery leftJoinWithInventory() Adds a LEFT JOIN clause and with to the query using the Inventory relation
 * @method     ChildHeroQuery rightJoinWithInventory() Adds a RIGHT JOIN clause and with to the query using the Inventory relation
 * @method     ChildHeroQuery innerJoinWithInventory() Adds a INNER JOIN clause and with to the query using the Inventory relation
 *
 * @method     ChildHeroQuery leftJoinQuest($relationAlias = null) Adds a LEFT JOIN clause to the query using the Quest relation
 * @method     ChildHeroQuery rightJoinQuest($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Quest relation
 * @method     ChildHeroQuery innerJoinQuest($relationAlias = null) Adds a INNER JOIN clause to the query using the Quest relation
 *
 * @method     ChildHeroQuery joinWithQuest($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Quest relation
 *
 * @method     ChildHeroQuery leftJoinWithQuest() Adds a LEFT JOIN clause and with to the query using the Quest relation
 * @method     ChildHeroQuery rightJoinWithQuest() Adds a RIGHT JOIN clause and with to the query using the Quest relation
 * @method     ChildHeroQuery innerJoinWithQuest() Adds a INNER JOIN clause and with to the query using the Quest relation
 *
 * @method     \Kantaria\Models\UserQuery|\Kantaria\Models\InventoryQuery|\Kantaria\Models\QuestQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildHero findOne(ConnectionInterface $con = null) Return the first ChildHero matching the query
 * @method     ChildHero findOneOrCreate(ConnectionInterface $con = null) Return the first ChildHero matching the query, or a new ChildHero object populated from the query conditions when no match is found
 *
 * @method     ChildHero findOneById(int $id) Return the first ChildHero filtered by the id column
 * @method     ChildHero findOneByUserId(int $user_id) Return the first ChildHero filtered by the user_id column
 * @method     ChildHero findOneByFirstName(string $first_name) Return the first ChildHero filtered by the first_name column
 * @method     ChildHero findOneByLastName(string $last_name) Return the first ChildHero filtered by the last_name column
 * @method     ChildHero findOneByHealth(int $health) Return the first ChildHero filtered by the health column
 * @method     ChildHero findOneByOxygen(int $oxygen) Return the first ChildHero filtered by the oxygen column
 * @method     ChildHero findOneByFood(int $food) Return the first ChildHero filtered by the food column
 * @method     ChildHero findOneByPosx(int $posx) Return the first ChildHero filtered by the posx column
 * @method     ChildHero findOneByPosy(int $posy) Return the first ChildHero filtered by the posy column
 * @method     ChildHero findOneByPosz(int $posz) Return the first ChildHero filtered by the posz column *

 * @method     ChildHero requirePk($key, ConnectionInterface $con = null) Return the ChildHero by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildHero requireOne(ConnectionInterface $con = null) Return the first ChildHero matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildHero requireOneById(int $id) Return the first ChildHero filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildHero requireOneByUserId(int $user_id) Return the first ChildHero filtered by the user_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildHero requireOneByFirstName(string $first_name) Return the first ChildHero filtered by the first_name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildHero requireOneByLastName(string $last_name) Return the first ChildHero filtered by the last_name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildHero requireOneByHealth(int $health) Return the first ChildHero filtered by the health column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildHero requireOneByOxygen(int $oxygen) Return the first ChildHero filtered by the oxygen column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildHero requireOneByFood(int $food) Return the first ChildHero filtered by the food column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildHero requireOneByPosx(int $posx) Return the first ChildHero filtered by the posx column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildHero requireOneByPosy(int $posy) Return the first ChildHero filtered by the posy column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildHero requireOneByPosz(int $posz) Return the first ChildHero filtered by the posz column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildHero[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildHero objects based on current ModelCriteria
 * @method     ChildHero[]|ObjectCollection findById(int $id) Return ChildHero objects filtered by the id column
 * @method     ChildHero[]|ObjectCollection findByUserId(int $user_id) Return ChildHero objects filtered by the user_id column
 * @method     ChildHero[]|ObjectCollection findByFirstName(string $first_name) Return ChildHero objects filtered by the first_name column
 * @method     ChildHero[]|ObjectCollection findByLastName(string $last_name) Return ChildHero objects filtered by the last_name column
 * @method     ChildHero[]|ObjectCollection findByHealth(int $health) Return ChildHero objects filtered by the health column
 * @method     ChildHero[]|ObjectCollection findByOxygen(int $oxygen) Return ChildHero objects filtered by the oxygen column
 * @method     ChildHero[]|ObjectCollection findByFood(int $food) Return ChildHero objects filtered by the food column
 * @method     ChildHero[]|ObjectCollection findByPosx(int $posx) Return ChildHero objects filtered by the posx column
 * @method     ChildHero[]|ObjectCollection findByPosy(int $posy) Return ChildHero objects filtered by the posy column
 * @method     ChildHero[]|ObjectCollection findByPosz(int $posz) Return ChildHero objects filtered by the posz column
 * @method     ChildHero[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class HeroQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Kantaria\Models\Base\HeroQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Kantaria\\Models\\Hero', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildHeroQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildHeroQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildHeroQuery) {
            return $criteria;
        }
        $query = new ChildHeroQuery();
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
     * @return ChildHero|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(HeroTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = HeroTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildHero A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, user_id, first_name, last_name, health, oxygen, food, posx, posy, posz FROM hero WHERE id = :p0';
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
            /** @var ChildHero $obj */
            $obj = new ChildHero();
            $obj->hydrate($row);
            HeroTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildHero|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildHeroQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(HeroTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildHeroQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(HeroTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildHeroQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(HeroTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(HeroTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HeroTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the user_id column
     *
     * Example usage:
     * <code>
     * $query->filterByUserId(1234); // WHERE user_id = 1234
     * $query->filterByUserId(array(12, 34)); // WHERE user_id IN (12, 34)
     * $query->filterByUserId(array('min' => 12)); // WHERE user_id > 12
     * </code>
     *
     * @see       filterByUser()
     *
     * @param     mixed $userId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildHeroQuery The current query, for fluid interface
     */
    public function filterByUserId($userId = null, $comparison = null)
    {
        if (is_array($userId)) {
            $useMinMax = false;
            if (isset($userId['min'])) {
                $this->addUsingAlias(HeroTableMap::COL_USER_ID, $userId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userId['max'])) {
                $this->addUsingAlias(HeroTableMap::COL_USER_ID, $userId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HeroTableMap::COL_USER_ID, $userId, $comparison);
    }

    /**
     * Filter the query on the first_name column
     *
     * Example usage:
     * <code>
     * $query->filterByFirstName('fooValue');   // WHERE first_name = 'fooValue'
     * $query->filterByFirstName('%fooValue%'); // WHERE first_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $firstName The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildHeroQuery The current query, for fluid interface
     */
    public function filterByFirstName($firstName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($firstName)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HeroTableMap::COL_FIRST_NAME, $firstName, $comparison);
    }

    /**
     * Filter the query on the last_name column
     *
     * Example usage:
     * <code>
     * $query->filterByLastName('fooValue');   // WHERE last_name = 'fooValue'
     * $query->filterByLastName('%fooValue%'); // WHERE last_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $lastName The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildHeroQuery The current query, for fluid interface
     */
    public function filterByLastName($lastName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($lastName)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HeroTableMap::COL_LAST_NAME, $lastName, $comparison);
    }

    /**
     * Filter the query on the health column
     *
     * Example usage:
     * <code>
     * $query->filterByHealth(1234); // WHERE health = 1234
     * $query->filterByHealth(array(12, 34)); // WHERE health IN (12, 34)
     * $query->filterByHealth(array('min' => 12)); // WHERE health > 12
     * </code>
     *
     * @param     mixed $health The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildHeroQuery The current query, for fluid interface
     */
    public function filterByHealth($health = null, $comparison = null)
    {
        if (is_array($health)) {
            $useMinMax = false;
            if (isset($health['min'])) {
                $this->addUsingAlias(HeroTableMap::COL_HEALTH, $health['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($health['max'])) {
                $this->addUsingAlias(HeroTableMap::COL_HEALTH, $health['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HeroTableMap::COL_HEALTH, $health, $comparison);
    }

    /**
     * Filter the query on the oxygen column
     *
     * Example usage:
     * <code>
     * $query->filterByOxygen(1234); // WHERE oxygen = 1234
     * $query->filterByOxygen(array(12, 34)); // WHERE oxygen IN (12, 34)
     * $query->filterByOxygen(array('min' => 12)); // WHERE oxygen > 12
     * </code>
     *
     * @param     mixed $oxygen The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildHeroQuery The current query, for fluid interface
     */
    public function filterByOxygen($oxygen = null, $comparison = null)
    {
        if (is_array($oxygen)) {
            $useMinMax = false;
            if (isset($oxygen['min'])) {
                $this->addUsingAlias(HeroTableMap::COL_OXYGEN, $oxygen['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($oxygen['max'])) {
                $this->addUsingAlias(HeroTableMap::COL_OXYGEN, $oxygen['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HeroTableMap::COL_OXYGEN, $oxygen, $comparison);
    }

    /**
     * Filter the query on the food column
     *
     * Example usage:
     * <code>
     * $query->filterByFood(1234); // WHERE food = 1234
     * $query->filterByFood(array(12, 34)); // WHERE food IN (12, 34)
     * $query->filterByFood(array('min' => 12)); // WHERE food > 12
     * </code>
     *
     * @param     mixed $food The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildHeroQuery The current query, for fluid interface
     */
    public function filterByFood($food = null, $comparison = null)
    {
        if (is_array($food)) {
            $useMinMax = false;
            if (isset($food['min'])) {
                $this->addUsingAlias(HeroTableMap::COL_FOOD, $food['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($food['max'])) {
                $this->addUsingAlias(HeroTableMap::COL_FOOD, $food['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HeroTableMap::COL_FOOD, $food, $comparison);
    }

    /**
     * Filter the query on the posx column
     *
     * Example usage:
     * <code>
     * $query->filterByPosx(1234); // WHERE posx = 1234
     * $query->filterByPosx(array(12, 34)); // WHERE posx IN (12, 34)
     * $query->filterByPosx(array('min' => 12)); // WHERE posx > 12
     * </code>
     *
     * @param     mixed $posx The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildHeroQuery The current query, for fluid interface
     */
    public function filterByPosx($posx = null, $comparison = null)
    {
        if (is_array($posx)) {
            $useMinMax = false;
            if (isset($posx['min'])) {
                $this->addUsingAlias(HeroTableMap::COL_POSX, $posx['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($posx['max'])) {
                $this->addUsingAlias(HeroTableMap::COL_POSX, $posx['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HeroTableMap::COL_POSX, $posx, $comparison);
    }

    /**
     * Filter the query on the posy column
     *
     * Example usage:
     * <code>
     * $query->filterByPosy(1234); // WHERE posy = 1234
     * $query->filterByPosy(array(12, 34)); // WHERE posy IN (12, 34)
     * $query->filterByPosy(array('min' => 12)); // WHERE posy > 12
     * </code>
     *
     * @param     mixed $posy The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildHeroQuery The current query, for fluid interface
     */
    public function filterByPosy($posy = null, $comparison = null)
    {
        if (is_array($posy)) {
            $useMinMax = false;
            if (isset($posy['min'])) {
                $this->addUsingAlias(HeroTableMap::COL_POSY, $posy['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($posy['max'])) {
                $this->addUsingAlias(HeroTableMap::COL_POSY, $posy['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HeroTableMap::COL_POSY, $posy, $comparison);
    }

    /**
     * Filter the query on the posz column
     *
     * Example usage:
     * <code>
     * $query->filterByPosz(1234); // WHERE posz = 1234
     * $query->filterByPosz(array(12, 34)); // WHERE posz IN (12, 34)
     * $query->filterByPosz(array('min' => 12)); // WHERE posz > 12
     * </code>
     *
     * @param     mixed $posz The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildHeroQuery The current query, for fluid interface
     */
    public function filterByPosz($posz = null, $comparison = null)
    {
        if (is_array($posz)) {
            $useMinMax = false;
            if (isset($posz['min'])) {
                $this->addUsingAlias(HeroTableMap::COL_POSZ, $posz['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($posz['max'])) {
                $this->addUsingAlias(HeroTableMap::COL_POSZ, $posz['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HeroTableMap::COL_POSZ, $posz, $comparison);
    }

    /**
     * Filter the query by a related \Kantaria\Models\User object
     *
     * @param \Kantaria\Models\User|ObjectCollection $user The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildHeroQuery The current query, for fluid interface
     */
    public function filterByUser($user, $comparison = null)
    {
        if ($user instanceof \Kantaria\Models\User) {
            return $this
                ->addUsingAlias(HeroTableMap::COL_USER_ID, $user->getId(), $comparison);
        } elseif ($user instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(HeroTableMap::COL_USER_ID, $user->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByUser() only accepts arguments of type \Kantaria\Models\User or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the User relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildHeroQuery The current query, for fluid interface
     */
    public function joinUser($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('User');

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
            $this->addJoinObject($join, 'User');
        }

        return $this;
    }

    /**
     * Use the User relation User object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Kantaria\Models\UserQuery A secondary query class using the current class as primary query
     */
    public function useUserQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUser($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'User', '\Kantaria\Models\UserQuery');
    }

    /**
     * Filter the query by a related \Kantaria\Models\Inventory object
     *
     * @param \Kantaria\Models\Inventory|ObjectCollection $inventory the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHeroQuery The current query, for fluid interface
     */
    public function filterByInventory($inventory, $comparison = null)
    {
        if ($inventory instanceof \Kantaria\Models\Inventory) {
            return $this
                ->addUsingAlias(HeroTableMap::COL_ID, $inventory->getHeroId(), $comparison);
        } elseif ($inventory instanceof ObjectCollection) {
            return $this
                ->useInventoryQuery()
                ->filterByPrimaryKeys($inventory->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByInventory() only accepts arguments of type \Kantaria\Models\Inventory or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Inventory relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildHeroQuery The current query, for fluid interface
     */
    public function joinInventory($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Inventory');

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
            $this->addJoinObject($join, 'Inventory');
        }

        return $this;
    }

    /**
     * Use the Inventory relation Inventory object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Kantaria\Models\InventoryQuery A secondary query class using the current class as primary query
     */
    public function useInventoryQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinInventory($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Inventory', '\Kantaria\Models\InventoryQuery');
    }

    /**
     * Filter the query by a related \Kantaria\Models\Quest object
     *
     * @param \Kantaria\Models\Quest|ObjectCollection $quest the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildHeroQuery The current query, for fluid interface
     */
    public function filterByQuest($quest, $comparison = null)
    {
        if ($quest instanceof \Kantaria\Models\Quest) {
            return $this
                ->addUsingAlias(HeroTableMap::COL_ID, $quest->getHeroId(), $comparison);
        } elseif ($quest instanceof ObjectCollection) {
            return $this
                ->useQuestQuery()
                ->filterByPrimaryKeys($quest->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByQuest() only accepts arguments of type \Kantaria\Models\Quest or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Quest relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildHeroQuery The current query, for fluid interface
     */
    public function joinQuest($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Quest');

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
            $this->addJoinObject($join, 'Quest');
        }

        return $this;
    }

    /**
     * Use the Quest relation Quest object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Kantaria\Models\QuestQuery A secondary query class using the current class as primary query
     */
    public function useQuestQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinQuest($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Quest', '\Kantaria\Models\QuestQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildHero $hero Object to remove from the list of results
     *
     * @return $this|ChildHeroQuery The current query, for fluid interface
     */
    public function prune($hero = null)
    {
        if ($hero) {
            $this->addUsingAlias(HeroTableMap::COL_ID, $hero->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the hero table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(HeroTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            HeroTableMap::clearInstancePool();
            HeroTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(HeroTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(HeroTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            HeroTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            HeroTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // HeroQuery
