<?php

namespace Kantaria\Models\Base;

use \Exception;
use \PDO;
use Kantaria\Models\Quest as ChildQuest;
use Kantaria\Models\QuestQuery as ChildQuestQuery;
use Kantaria\Models\Map\QuestTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'quest' table.
 *
 *
 *
 * @method     ChildQuestQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildQuestQuery orderByCharacterId($order = Criteria::ASC) Order by the character_id column
 * @method     ChildQuestQuery orderByQuest($order = Criteria::ASC) Order by the quest column
 * @method     ChildQuestQuery orderByCompleted($order = Criteria::ASC) Order by the completed column
 * @method     ChildQuestQuery orderByTask1($order = Criteria::ASC) Order by the task1 column
 * @method     ChildQuestQuery orderByTask2($order = Criteria::ASC) Order by the task2 column
 * @method     ChildQuestQuery orderByTask3($order = Criteria::ASC) Order by the task3 column
 * @method     ChildQuestQuery orderByTask4($order = Criteria::ASC) Order by the task4 column
 *
 * @method     ChildQuestQuery groupById() Group by the id column
 * @method     ChildQuestQuery groupByCharacterId() Group by the character_id column
 * @method     ChildQuestQuery groupByQuest() Group by the quest column
 * @method     ChildQuestQuery groupByCompleted() Group by the completed column
 * @method     ChildQuestQuery groupByTask1() Group by the task1 column
 * @method     ChildQuestQuery groupByTask2() Group by the task2 column
 * @method     ChildQuestQuery groupByTask3() Group by the task3 column
 * @method     ChildQuestQuery groupByTask4() Group by the task4 column
 *
 * @method     ChildQuestQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildQuestQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildQuestQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildQuestQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildQuestQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildQuestQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildQuestQuery leftJoinCharacter($relationAlias = null) Adds a LEFT JOIN clause to the query using the Character relation
 * @method     ChildQuestQuery rightJoinCharacter($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Character relation
 * @method     ChildQuestQuery innerJoinCharacter($relationAlias = null) Adds a INNER JOIN clause to the query using the Character relation
 *
 * @method     ChildQuestQuery joinWithCharacter($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Character relation
 *
 * @method     ChildQuestQuery leftJoinWithCharacter() Adds a LEFT JOIN clause and with to the query using the Character relation
 * @method     ChildQuestQuery rightJoinWithCharacter() Adds a RIGHT JOIN clause and with to the query using the Character relation
 * @method     ChildQuestQuery innerJoinWithCharacter() Adds a INNER JOIN clause and with to the query using the Character relation
 *
 * @method     \Kantaria\Models\CharacterQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildQuest findOne(ConnectionInterface $con = null) Return the first ChildQuest matching the query
 * @method     ChildQuest findOneOrCreate(ConnectionInterface $con = null) Return the first ChildQuest matching the query, or a new ChildQuest object populated from the query conditions when no match is found
 *
 * @method     ChildQuest findOneById(int $id) Return the first ChildQuest filtered by the id column
 * @method     ChildQuest findOneByCharacterId(int $character_id) Return the first ChildQuest filtered by the character_id column
 * @method     ChildQuest findOneByQuest(string $quest) Return the first ChildQuest filtered by the quest column
 * @method     ChildQuest findOneByCompleted(int $completed) Return the first ChildQuest filtered by the completed column
 * @method     ChildQuest findOneByTask1(int $task1) Return the first ChildQuest filtered by the task1 column
 * @method     ChildQuest findOneByTask2(int $task2) Return the first ChildQuest filtered by the task2 column
 * @method     ChildQuest findOneByTask3(int $task3) Return the first ChildQuest filtered by the task3 column
 * @method     ChildQuest findOneByTask4(int $task4) Return the first ChildQuest filtered by the task4 column *

 * @method     ChildQuest requirePk($key, ConnectionInterface $con = null) Return the ChildQuest by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildQuest requireOne(ConnectionInterface $con = null) Return the first ChildQuest matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildQuest requireOneById(int $id) Return the first ChildQuest filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildQuest requireOneByCharacterId(int $character_id) Return the first ChildQuest filtered by the character_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildQuest requireOneByQuest(string $quest) Return the first ChildQuest filtered by the quest column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildQuest requireOneByCompleted(int $completed) Return the first ChildQuest filtered by the completed column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildQuest requireOneByTask1(int $task1) Return the first ChildQuest filtered by the task1 column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildQuest requireOneByTask2(int $task2) Return the first ChildQuest filtered by the task2 column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildQuest requireOneByTask3(int $task3) Return the first ChildQuest filtered by the task3 column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildQuest requireOneByTask4(int $task4) Return the first ChildQuest filtered by the task4 column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildQuest[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildQuest objects based on current ModelCriteria
 * @method     ChildQuest[]|ObjectCollection findById(int $id) Return ChildQuest objects filtered by the id column
 * @method     ChildQuest[]|ObjectCollection findByCharacterId(int $character_id) Return ChildQuest objects filtered by the character_id column
 * @method     ChildQuest[]|ObjectCollection findByQuest(string $quest) Return ChildQuest objects filtered by the quest column
 * @method     ChildQuest[]|ObjectCollection findByCompleted(int $completed) Return ChildQuest objects filtered by the completed column
 * @method     ChildQuest[]|ObjectCollection findByTask1(int $task1) Return ChildQuest objects filtered by the task1 column
 * @method     ChildQuest[]|ObjectCollection findByTask2(int $task2) Return ChildQuest objects filtered by the task2 column
 * @method     ChildQuest[]|ObjectCollection findByTask3(int $task3) Return ChildQuest objects filtered by the task3 column
 * @method     ChildQuest[]|ObjectCollection findByTask4(int $task4) Return ChildQuest objects filtered by the task4 column
 * @method     ChildQuest[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class QuestQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Kantaria\Models\Base\QuestQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Kantaria\\Models\\Quest', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildQuestQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildQuestQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildQuestQuery) {
            return $criteria;
        }
        $query = new ChildQuestQuery();
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
     * @return ChildQuest|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(QuestTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = QuestTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildQuest A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, character_id, quest, completed, task1, task2, task3, task4 FROM quest WHERE id = :p0';
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
            /** @var ChildQuest $obj */
            $obj = new ChildQuest();
            $obj->hydrate($row);
            QuestTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildQuest|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildQuestQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(QuestTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildQuestQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(QuestTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildQuestQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(QuestTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(QuestTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(QuestTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildQuestQuery The current query, for fluid interface
     */
    public function filterByCharacterId($characterId = null, $comparison = null)
    {
        if (is_array($characterId)) {
            $useMinMax = false;
            if (isset($characterId['min'])) {
                $this->addUsingAlias(QuestTableMap::COL_CHARACTER_ID, $characterId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($characterId['max'])) {
                $this->addUsingAlias(QuestTableMap::COL_CHARACTER_ID, $characterId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(QuestTableMap::COL_CHARACTER_ID, $characterId, $comparison);
    }

    /**
     * Filter the query on the quest column
     *
     * Example usage:
     * <code>
     * $query->filterByQuest('fooValue');   // WHERE quest = 'fooValue'
     * $query->filterByQuest('%fooValue%'); // WHERE quest LIKE '%fooValue%'
     * </code>
     *
     * @param     string $quest The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildQuestQuery The current query, for fluid interface
     */
    public function filterByQuest($quest = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($quest)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(QuestTableMap::COL_QUEST, $quest, $comparison);
    }

    /**
     * Filter the query on the completed column
     *
     * Example usage:
     * <code>
     * $query->filterByCompleted(1234); // WHERE completed = 1234
     * $query->filterByCompleted(array(12, 34)); // WHERE completed IN (12, 34)
     * $query->filterByCompleted(array('min' => 12)); // WHERE completed > 12
     * </code>
     *
     * @param     mixed $completed The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildQuestQuery The current query, for fluid interface
     */
    public function filterByCompleted($completed = null, $comparison = null)
    {
        if (is_array($completed)) {
            $useMinMax = false;
            if (isset($completed['min'])) {
                $this->addUsingAlias(QuestTableMap::COL_COMPLETED, $completed['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($completed['max'])) {
                $this->addUsingAlias(QuestTableMap::COL_COMPLETED, $completed['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(QuestTableMap::COL_COMPLETED, $completed, $comparison);
    }

    /**
     * Filter the query on the task1 column
     *
     * Example usage:
     * <code>
     * $query->filterByTask1(1234); // WHERE task1 = 1234
     * $query->filterByTask1(array(12, 34)); // WHERE task1 IN (12, 34)
     * $query->filterByTask1(array('min' => 12)); // WHERE task1 > 12
     * </code>
     *
     * @param     mixed $task1 The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildQuestQuery The current query, for fluid interface
     */
    public function filterByTask1($task1 = null, $comparison = null)
    {
        if (is_array($task1)) {
            $useMinMax = false;
            if (isset($task1['min'])) {
                $this->addUsingAlias(QuestTableMap::COL_TASK1, $task1['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($task1['max'])) {
                $this->addUsingAlias(QuestTableMap::COL_TASK1, $task1['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(QuestTableMap::COL_TASK1, $task1, $comparison);
    }

    /**
     * Filter the query on the task2 column
     *
     * Example usage:
     * <code>
     * $query->filterByTask2(1234); // WHERE task2 = 1234
     * $query->filterByTask2(array(12, 34)); // WHERE task2 IN (12, 34)
     * $query->filterByTask2(array('min' => 12)); // WHERE task2 > 12
     * </code>
     *
     * @param     mixed $task2 The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildQuestQuery The current query, for fluid interface
     */
    public function filterByTask2($task2 = null, $comparison = null)
    {
        if (is_array($task2)) {
            $useMinMax = false;
            if (isset($task2['min'])) {
                $this->addUsingAlias(QuestTableMap::COL_TASK2, $task2['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($task2['max'])) {
                $this->addUsingAlias(QuestTableMap::COL_TASK2, $task2['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(QuestTableMap::COL_TASK2, $task2, $comparison);
    }

    /**
     * Filter the query on the task3 column
     *
     * Example usage:
     * <code>
     * $query->filterByTask3(1234); // WHERE task3 = 1234
     * $query->filterByTask3(array(12, 34)); // WHERE task3 IN (12, 34)
     * $query->filterByTask3(array('min' => 12)); // WHERE task3 > 12
     * </code>
     *
     * @param     mixed $task3 The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildQuestQuery The current query, for fluid interface
     */
    public function filterByTask3($task3 = null, $comparison = null)
    {
        if (is_array($task3)) {
            $useMinMax = false;
            if (isset($task3['min'])) {
                $this->addUsingAlias(QuestTableMap::COL_TASK3, $task3['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($task3['max'])) {
                $this->addUsingAlias(QuestTableMap::COL_TASK3, $task3['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(QuestTableMap::COL_TASK3, $task3, $comparison);
    }

    /**
     * Filter the query on the task4 column
     *
     * Example usage:
     * <code>
     * $query->filterByTask4(1234); // WHERE task4 = 1234
     * $query->filterByTask4(array(12, 34)); // WHERE task4 IN (12, 34)
     * $query->filterByTask4(array('min' => 12)); // WHERE task4 > 12
     * </code>
     *
     * @param     mixed $task4 The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildQuestQuery The current query, for fluid interface
     */
    public function filterByTask4($task4 = null, $comparison = null)
    {
        if (is_array($task4)) {
            $useMinMax = false;
            if (isset($task4['min'])) {
                $this->addUsingAlias(QuestTableMap::COL_TASK4, $task4['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($task4['max'])) {
                $this->addUsingAlias(QuestTableMap::COL_TASK4, $task4['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(QuestTableMap::COL_TASK4, $task4, $comparison);
    }

    /**
     * Filter the query by a related \Kantaria\Models\Character object
     *
     * @param \Kantaria\Models\Character|ObjectCollection $character The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildQuestQuery The current query, for fluid interface
     */
    public function filterByCharacter($character, $comparison = null)
    {
        if ($character instanceof \Kantaria\Models\Character) {
            return $this
                ->addUsingAlias(QuestTableMap::COL_CHARACTER_ID, $character->getId(), $comparison);
        } elseif ($character instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(QuestTableMap::COL_CHARACTER_ID, $character->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildQuestQuery The current query, for fluid interface
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
     * @param   ChildQuest $quest Object to remove from the list of results
     *
     * @return $this|ChildQuestQuery The current query, for fluid interface
     */
    public function prune($quest = null)
    {
        if ($quest) {
            $this->addUsingAlias(QuestTableMap::COL_ID, $quest->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the quest table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(QuestTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            QuestTableMap::clearInstancePool();
            QuestTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(QuestTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(QuestTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            QuestTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            QuestTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // QuestQuery
