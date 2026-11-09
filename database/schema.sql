SET NAMES utf8mb4;
CREATE TABLE users(
 id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 role ENUM('customer','seller','admin') NOT NULL DEFAULT 'customer',
 name VARCHAR(120) NOT NULL,
 email VARCHAR(190) NOT NULL UNIQUE,
 phone VARCHAR(20) NOT NULL UNIQUE,
 google_sub VARCHAR(100) NULL UNIQUE,
 password_hash VARCHAR(255) NULL,
 status ENUM('pending','active','rejected','suspended') NOT NULL DEFAULT 'pending',
 approved_at DATETIME NULL,
 approved_by BIGINT UNSIGNED NULL,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 INDEX(status,created_at),
 FOREIGN KEY(approved_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE TABLE activation_tokens(
 id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 user_id BIGINT UNSIGNED NOT NULL,
 token_hash CHAR(64) NOT NULL UNIQUE,
 expires_at DATETIME NOT NULL,
 used_at DATETIME NULL,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE,
 INDEX(user_id,expires_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE TABLE seller_profiles(id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,user_id BIGINT UNSIGNED NOT NULL UNIQUE,store_name VARCHAR(150) NOT NULL,store_slug VARCHAR(180) NOT NULL UNIQUE,approval_status ENUM('pending','approved','rejected','suspended') NOT NULL DEFAULT 'pending',commission_percent DECIMAL(5,2) NOT NULL DEFAULT 10.00,created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE TABLE categories(id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,parent_id BIGINT UNSIGNED NULL,slug VARCHAR(160) NOT NULL UNIQUE,name_en VARCHAR(150) NOT NULL,name_ur VARCHAR(150) NOT NULL,image_path VARCHAR(255),is_active TINYINT(1) NOT NULL DEFAULT 1,sort_order INT NOT NULL DEFAULT 0,FOREIGN KEY(parent_id) REFERENCES categories(id) ON DELETE SET NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE TABLE products(id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,seller_id BIGINT UNSIGNED NOT NULL,category_id BIGINT UNSIGNED NULL,brand VARCHAR(100),slug VARCHAR(190) NOT NULL UNIQUE,sku VARCHAR(80) UNIQUE,name_en VARCHAR(200) NOT NULL,name_ur VARCHAR(200) NOT NULL,description_en TEXT,description_ur TEXT,price DECIMAL(12,2) NOT NULL,compare_at_price DECIMAL(12,2),stock_quantity INT UNSIGNED NOT NULL DEFAULT 0,status ENUM('draft','pending','published','rejected','archived') NOT NULL DEFAULT 'pending',created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,FOREIGN KEY(seller_id) REFERENCES seller_profiles(id),FOREIGN KEY(category_id) REFERENCES categories(id) ON DELETE SET NULL,INDEX(status,category_id),CHECK(price>=0)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE TABLE product_images(id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,product_id BIGINT UNSIGNED NOT NULL,image_path VARCHAR(255) NOT NULL,alt_en VARCHAR(200),alt_ur VARCHAR(200),sort_order INT NOT NULL DEFAULT 0,FOREIGN KEY(product_id) REFERENCES products(id) ON DELETE CASCADE) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE TABLE orders(id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,order_number VARCHAR(40) NOT NULL UNIQUE,customer_id BIGINT UNSIGNED NOT NULL,address_snapshot JSON NOT NULL,subtotal DECIMAL(12,2) NOT NULL,delivery_fee DECIMAL(12,2) NOT NULL DEFAULT 0,discount_total DECIMAL(12,2) NOT NULL DEFAULT 0,grand_total DECIMAL(12,2) NOT NULL,currency CHAR(3) NOT NULL DEFAULT 'PKR',payment_method ENUM('cod','bank_transfer','easypaisa','jazzcash') NOT NULL DEFAULT 'cod',payment_status ENUM('unpaid','submitted','verified','rejected','refunded') NOT NULL DEFAULT 'unpaid',order_status ENUM('pending','confirmed','processing','packed','shipped','out_for_delivery','delivered','cancelled','returned') NOT NULL DEFAULT 'pending',created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,FOREIGN KEY(customer_id) REFERENCES users(id),INDEX(customer_id,created_at),INDEX(order_status,created_at)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE TABLE order_items(id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,order_id BIGINT UNSIGNED NOT NULL,seller_id BIGINT UNSIGNED NOT NULL,product_id BIGINT UNSIGNED NOT NULL,product_name_snapshot VARCHAR(200) NOT NULL,quantity INT UNSIGNED NOT NULL,unit_price DECIMAL(12,2) NOT NULL,line_total DECIMAL(12,2) NOT NULL,commission_amount DECIMAL(12,2) NOT NULL DEFAULT 0,seller_amount DECIMAL(12,2) NOT NULL DEFAULT 0,fulfilment_status ENUM('pending','accepted','packed','shipped','delivered','cancelled','returned') NOT NULL DEFAULT 'pending',FOREIGN KEY(order_id) REFERENCES orders(id) ON DELETE CASCADE,FOREIGN KEY(seller_id) REFERENCES seller_profiles(id),FOREIGN KEY(product_id) REFERENCES products(id),INDEX(seller_id,fulfilment_status)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE TABLE payments(id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,order_id BIGINT UNSIGNED NOT NULL,method VARCHAR(40) NOT NULL,amount DECIMAL(12,2) NOT NULL,transaction_reference VARCHAR(120),proof_path VARCHAR(255),verification_status ENUM('pending','verified','rejected') NOT NULL DEFAULT 'pending',verified_by BIGINT UNSIGNED NULL,verified_at DATETIME,created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,FOREIGN KEY(order_id) REFERENCES orders(id) ON DELETE CASCADE,FOREIGN KEY(verified_by) REFERENCES users(id) ON DELETE SET NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE TABLE shipments(id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,order_item_id BIGINT UNSIGNED NOT NULL,courier_name VARCHAR(100),tracking_number VARCHAR(120),tracking_url VARCHAR(255),shipped_at DATETIME,delivered_at DATETIME,FOREIGN KEY(order_item_id) REFERENCES order_items(id) ON DELETE CASCADE) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE TABLE audit_logs(id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,actor_user_id BIGINT UNSIGNED NULL,action VARCHAR(120) NOT NULL,entity_type VARCHAR(80) NOT NULL,entity_id BIGINT UNSIGNED NULL,details JSON,ip_address VARCHAR(45),created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,FOREIGN KEY(actor_user_id) REFERENCES users(id) ON DELETE SET NULL,INDEX(created_at)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;