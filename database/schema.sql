CREATE DATABASE IF NOT EXISTS blog
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE blog;

CREATE TABLE categories (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE articles (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NULL,
    body MEDIUMTEXT NOT NULL,
    image VARCHAR(512) NULL,
    views INT UNSIGNED NOT NULL DEFAULT 0,
    published_at DATETIME NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_articles_published_at (published_at),
    INDEX idx_articles_views (views)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE article_category (
    article_id INT UNSIGNED NOT NULL,
    category_id INT UNSIGNED NOT NULL,
    PRIMARY KEY (article_id, category_id),
    INDEX idx_article_category_category (category_id),
    CONSTRAINT fk_ac_article
        FOREIGN KEY (article_id) REFERENCES articles (id)
        ON DELETE CASCADE,
    CONSTRAINT fk_ac_category
        FOREIGN KEY (category_id) REFERENCES categories (id)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
