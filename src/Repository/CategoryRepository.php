<?php

declare(strict_types=1);

namespace App\Repository;

use PDO;

final class CategoryRepository
{
    public function __construct(
        private readonly PDO $db,
    ) {
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare(
            'SELECT id, name, description, created_at
             FROM categories
             WHERE id = :id
             LIMIT 1',
        );
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();

        return $row !== false ? $row : null;
    }

    /**
     * Категории, в которых есть хотя бы одна статья.
     *
     * @return list<array<string, mixed>>
     */
    public function findAllWithArticles(): array
    {
        $stmt = $this->db->query(
            'SELECT DISTINCT c.id, c.name, c.description, c.created_at
             FROM categories c
             INNER JOIN article_category ac ON ac.category_id = c.id
             ORDER BY c.name ASC',
        );

        return $stmt->fetchAll();
    }
}
