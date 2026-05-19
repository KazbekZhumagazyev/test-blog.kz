<?php

declare(strict_types=1);

namespace App\Repository;

use PDO;

final class ArticleRepository
{
    public function __construct(
        private readonly PDO $db,
    ) {
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare(
            'SELECT id, title, description, body, image, views, published_at, created_at
             FROM articles
             WHERE id = :id
             LIMIT 1',
        );
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();

        return $row !== false ? $row : null;
    }

    public function incrementViews(int $id): void
    {
        $stmt = $this->db->prepare(
            'UPDATE articles SET views = views + 1 WHERE id = :id',
        );
        $stmt->execute(['id' => $id]);
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function findCategoriesForArticle(int $articleId): array
    {
        $stmt = $this->db->prepare(
            'SELECT c.id, c.name
             FROM categories c
             INNER JOIN article_category ac ON ac.category_id = c.id
             WHERE ac.article_id = :article_id
             ORDER BY c.name ASC',
        );
        $stmt->execute(['article_id' => $articleId]);

        return $stmt->fetchAll();
    }

    public function countByCategory(int $categoryId): int
    {
        $stmt = $this->db->prepare(
            'SELECT COUNT(DISTINCT a.id)
             FROM articles a
             INNER JOIN article_category ac ON ac.article_id = a.id
             WHERE ac.category_id = :category_id',
        );
        $stmt->execute(['category_id' => $categoryId]);

        return (int) $stmt->fetchColumn();
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function findByCategory(
        int $categoryId,
        int $limit,
        int $offset,
        string $sort = 'date',
    ): array {
        $orderBy = $sort === 'views'
            ? 'a.views DESC, a.published_at DESC'
            : 'a.published_at DESC';

        $sql = sprintf(
            'SELECT DISTINCT a.id, a.title, a.description, a.image, a.views, a.published_at
             FROM articles a
             INNER JOIN article_category ac ON ac.article_id = a.id
             WHERE ac.category_id = :category_id
             ORDER BY %s
             LIMIT :limit OFFSET :offset',
            $orderBy,
        );

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue('category_id', $categoryId, PDO::PARAM_INT);
        $stmt->bindValue('limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue('offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * Последние статьи категории (для главной).
     *
     * @return list<array<string, mixed>>
     */
    public function findLatestByCategory(int $categoryId, int $limit = 3): array
    {
        return $this->findByCategory($categoryId, $limit, 0, 'date');
    }
}
