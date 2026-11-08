-- Cấu trúc database
drop database if exists `techstore`;
create database `techstore` default character set utf8mb4 collate utf8mb4_general_ci;
use `techstore`;

CREATE TABLE categories (
  id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  parent_id  INT UNSIGNED NULL,
  name       VARCHAR(100) NOT NULL,
  slug       VARCHAR(120) NOT NULL UNIQUE,
  image      VARCHAR(255) NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (parent_id) REFERENCES categories(id) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE brands (
  id   INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  slug VARCHAR(120) NOT NULL UNIQUE,
  logo VARCHAR(255) NULL
) ENGINE=InnoDB;

CREATE TABLE users (
  id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name          VARCHAR(100) NOT NULL,
  email         VARCHAR(150) NOT NULL UNIQUE,
  phone         VARCHAR(20)  NULL,
  password_hash VARCHAR(255) NOT NULL,
  role          ENUM('customer','admin') NOT NULL DEFAULT 'customer',
  status        ENUM('active','blocked') NOT NULL DEFAULT 'active',
  created_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE addresses (
  id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id    INT UNSIGNED NOT NULL,
  receiver   VARCHAR(100) NOT NULL,
  phone      VARCHAR(20)  NOT NULL,
  province   VARCHAR(100) NOT NULL,
  district   VARCHAR(100) NOT NULL,
  ward       VARCHAR(100) NOT NULL,
  detail     VARCHAR(255) NOT NULL,
  is_default TINYINT(1)   NOT NULL DEFAULT 0,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE products (
  id              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  category_id     INT UNSIGNED NOT NULL,
  brand_id        INT UNSIGNED NOT NULL,
  name            VARCHAR(200) NOT NULL,
  slug            VARCHAR(220) NOT NULL UNIQUE,
  model_code      VARCHAR(100) NOT NULL UNIQUE,
  short_desc      VARCHAR(500) NULL,
  description     TEXT NULL,
  design_desc     VARCHAR(500) NULL,
  in_the_box       VARCHAR(500) NULL,
  selling_points  VARCHAR(500) NULL,
  warranty_months TINYINT UNSIGNED NOT NULL DEFAULT 12,
  is_featured     TINYINT(1) NOT NULL DEFAULT 0,
  status          ENUM('draft','published','hidden') NOT NULL DEFAULT 'published',
  created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE RESTRICT,
  FOREIGN KEY (brand_id) REFERENCES brands(id) ON DELETE RESTRICT,
  INDEX idx_product_filter (category_id, brand_id, status)
) ENGINE=InnoDB;

CREATE TABLE product_variants (
  id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  product_id INT UNSIGNED NOT NULL,
  sku        VARCHAR(100) NOT NULL UNIQUE,
  color      VARCHAR(50)  NOT NULL,
  color_hex   CHAR(7)      NOT NULL DEFAULT '#000000',
  ram        VARCHAR(20)  NULL,
  storage    VARCHAR(50)  NULL,
  price      BIGINT UNSIGNED NOT NULL,
  sale_price BIGINT UNSIGNED NULL,
  stock      INT UNSIGNED NOT NULL DEFAULT 0,
  is_default TINYINT(1)   NOT NULL DEFAULT 0,
  FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
  INDEX idx_variant_price (price, sale_price)
) ENGINE=InnoDB;

CREATE TABLE product_specs (
  id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  product_id INT UNSIGNED NOT NULL,
  group_name VARCHAR(100) NOT NULL DEFAULT 'Cấu hình',
  spec_key   VARCHAR(100) NOT NULL,
  spec_value VARCHAR(255) NOT NULL,
  sort_order SMALLINT UNSIGNED NOT NULL DEFAULT 0,
  FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE product_media (
  id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  product_id INT UNSIGNED NOT NULL,
  variant_id INT UNSIGNED NULL,
  type       ENUM('image','video') NOT NULL DEFAULT 'image',
  file_path  VARCHAR(255) NOT NULL,
  angle      VARCHAR(50)  NULL,
  alt_text   VARCHAR(255) NOT NULL,
  ai_prompt  TEXT NULL,
  ai_tool    VARCHAR(100) NULL,
  ai_seed    VARCHAR(100) NULL,
  sort_order SMALLINT UNSIGNED NOT NULL DEFAULT 0,
  FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
  FOREIGN KEY (variant_id) REFERENCES product_variants(id) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE coupons (
  id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  code        VARCHAR(50) NOT NULL UNIQUE,
  type        ENUM('percent','fixed') NOT NULL,
  value       BIGINT UNSIGNED NOT NULL,
  min_order   BIGINT UNSIGNED NOT NULL DEFAULT 0,
  start_at    DATETIME NULL,
  end_at      DATETIME NULL,
  usage_limit INT UNSIGNED NOT NULL DEFAULT 100,
  used_count  INT UNSIGNED NOT NULL DEFAULT 0,
  status      ENUM('active','inactive') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB;

CREATE TABLE orders (
  id             INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  order_code     VARCHAR(30)  NOT NULL UNIQUE,
  user_id        INT UNSIGNED NULL,
  receiver_name  VARCHAR(100) NOT NULL,
  receiver_phone VARCHAR(20)  NOT NULL,
  shipping_addr  VARCHAR(500) NOT NULL,
  note           VARCHAR(500) NULL,
  subtotal       BIGINT UNSIGNED NOT NULL,
  shipping_fee   BIGINT UNSIGNED NOT NULL DEFAULT 0,
  discount       BIGINT UNSIGNED NOT NULL DEFAULT 0,
  coupon_code    VARCHAR(50)  NULL,
  total          BIGINT UNSIGNED NOT NULL,
  payment_method ENUM('cod','qr','vnpay','momo') NOT NULL DEFAULT 'cod',
  payment_status ENUM('pending','paid','failed','refunded') NOT NULL DEFAULT 'pending',
  status         ENUM('pending','confirmed','shipping','completed','cancelled') NOT NULL DEFAULT 'pending',
  created_at     TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE order_items (
  id           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  order_id     INT UNSIGNED NOT NULL,
  variant_id   INT UNSIGNED NULL,
  product_name VARCHAR(200) NOT NULL,
  sku          VARCHAR(100) NOT NULL,
  variant_info VARCHAR(100) NOT NULL,
  price        BIGINT UNSIGNED NOT NULL,
  quantity     SMALLINT UNSIGNED NOT NULL,
  FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
  FOREIGN KEY (variant_id) REFERENCES product_variants(id) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE reviews (
  id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  product_id INT UNSIGNED NOT NULL,
  user_id    INT UNSIGNED NOT NULL,
  rating     TINYINT UNSIGNED NOT NULL,
  content    TEXT NOT NULL,
  status     ENUM('pending','approved','hidden') NOT NULL DEFAULT 'approved',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE wishlists (
  user_id    INT UNSIGNED NOT NULL,
  product_id INT UNSIGNED NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (user_id, product_id),
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB;

