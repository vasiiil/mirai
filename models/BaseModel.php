<?php


abstract class BaseModel
{
    public static function getModel()
    {
        $model = get_called_class();
        static $instances;

        if (!isset($instances[$model])) {
            $instances[$model] = new $model();
        }

        return $instances[$model];
    }

    abstract protected function table(): string;
    abstract protected function fields(): array;

    protected function select(?array $fields = null): string
    {
        $fields = $fields ?? $this->fields();

        return implode(', ', $fields);
    }

    protected function find(string $query, ?array $params = null, bool $asAssoc = true): ?array
    {
        $stmt = Factory::getDB()->prepare($query);

        if (!$stmt) {
            return null;
        }

        $stmt->execute($params);
        if ($asAssoc) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return $stmt->fetchAll();
    }

    protected function findOne(string $query, ?array $params = null, bool $asAssoc = true): ?array
    {
        $result = $this->find($query, $params, $asAssoc);

        return is_null($result) ? null : $result[0];
    }
}
