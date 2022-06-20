<?php


class City extends BaseModel
{
    public function getAll()
    {
        $query ="
            SELECT
                {$this->select()}
            FROM
                {$this->table()}
        ";

        return $this->find($query);
    }

    public function getById(string $id): ?array
    {
        $query ="
            SELECT
                {$this->select()}
            FROM
                {$this->table()}
            WHERE
                id = ?
        ";

        return $this->findOne($query, [$id]);
    }

    protected function table(): string
    {
        return 'city';
    }

    protected function fields(): array
    {
        return [
            'id',
            'country_iso3',
            'name',
            'latitude',
            'longitude'
        ];
    }
}
