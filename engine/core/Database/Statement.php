<?php

namespace Engine\Core\Database;

class Statement
{
    /**
     * @var string sql
     */
    protected $sql = '';

    /**
     * @var PDOStatement connection statement.
     */
    protected $stmt;

    /**
     * @var PDO Database connection.
     */
    protected $connection;

    public function __construct(string $sql = '', string $db = 'engine')
    {
        if ('' !== $sql) {
            $this->prepare($sql);
        }

        if ('' !== $db) {
            $this->connection = Database::connection($db);
        }
    }

    /**
     * Initiates a transaction
     *
     * @return bool
     */
    public function beginTxn(): bool
    {
        return $this->connection->beginTransaction();
    }

    /**
     * Finalize a transaction
     *
     * @param bool $commit
     * @return bool
     */
    public function endTxn(bool $commit = true): bool
    {
        return ($commit) ? $this->connection->commit() : $this->connection->rollBack();
    }

    /**
     * Checks if inside a transaction
     *
     * @return bool
     */
    public function inTxn(): bool
    {
        return $this->connection->inTransaction();
    }

    /**
     * Performs an SQL statement.
     *
     * @param string $sql The query string
     * @return Statement
     */
    public function query(string $sql): Statement
    {
        $this->stmt = $this->connection->query($this->sql = $sql);

        return $this;
    }

    /**
     * Undocumented function
     *
     * @param string $sql The query string
     * @return int
     */
    public function exec(string $sql): int
    {
        return $this->connection->exec($this->sql = $sql);
    }

    /**
     * Prepares an SQL statement.
     *
     * @param string $sql The query to prepare.
     * @return Statement
     */
    public function prepare(string $sql): Statement
    {
        $this->stmt = $this->connection->prepare($this->sql = $sql);

        return $this;
    }

    /**
     * Binds a parameter to a value.
     *
     * @param mixed $parameter
     * @param mixed $value
     * @param int $type
     * @return Statement
     */
    public function bind($parameter, $value, int $type = 0): Statement
    {
        if (null === $this->stmt) {
            throw new \LogicException('Not a single request was not prepared');
        }

        if (0 === $type) {
            switch (strtolower(gettype($value))) {
                case 'integer':
                    $type = \PDO::PARAM_INT;
                    break;
                case 'boolean':
                    $type = \PDO::PARAM_BOOL;
                    break;
                case 'null':
                    $type = \PDO::PARAM_NULL;
                    break;
                default:
                    $type = \PDO::PARAM_STR;
            }
        }

        $this->stmt->bindValue($parameter, $value, $type);

        return $this;
    }

    public function bindMore(array $array): Statement
    {
        if (null === $this->stmt) {
            throw new \LogicException('Not a single request was not prepared');
        }

        foreach ($array as $parameter => $value) {
            $this->bind($parameter, $value);
        }

        return $this;
    }

    /**
     * Executes the prepared statement.
     *
     * @return bool
     */
    public function execute(): bool
    {
        if (null === $this->stmt) {

            throw new \LogicException('Not a single request was not prepared');
        }

        try {
            return $this->stmt->execute();

        } catch (\PDOException $error) {
            echo '<h1>MySQL Error</h1>';
            echo '<p>' . $error->errorInfo[2] . '</p>';
            echo '<h3>Last Query</h3>';
            echo '<p>' . $this->sql . '</p>';
            exit;
        }
    }

    /**
     * Fetches a single result.
     *
     * @return array|bool
     */
    public function fetch()
    {
        return $this->stmt->fetch();
    }

    /**
     * Fetches all results.
     *
     * @return array
     */
    public function all(): array
    {
        return $this->stmt->fetchAll();
    }

    /**
     * Fetches the number of results.
     *
     * @return int
     */
    public function rowCount(): int
    {
        return $this->stmt->rowCount();
    }

    /**
     * Undocumented function
     *
     * @return bool
     */
    public function nextRowset(): bool
    {
        return $this->stmt->nextRowSet();
    }

    /**
     * Returns error information associated with the last query.
     *
     * @return array
     */
    public function errors(): array
    {
        return $this->stmt->errorInfo();
    }

    /**
     * Undocumented function
     *
     * @return bool
     */
    public function endData(): bool
    {
        return $this->stmt->closeCursor();
    }
}
