-- Table structure for table branch
# CREATE SCHEMA bidding_system;
# USE bidding_system;
CREATE TABLE IF NOT EXISTS branch(
    code INT(30) NOT NULL,
    name varchar(30) NOT NULL,
    address varchar(30) NOT NULL,
    hotline_number varchar(15) NOT NULL,
    UNIQUE(code, name)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Table structure for table account

CREATE TABLE IF NOT EXISTS account(
    Email varchar(200) NOT NULL,
    Phone varchar(30) NOT NULL,
    Password varchar(30) NOT NULL,
    First_name varchar(30) NOT NULL,
    Last_name varchar(30) NOT NULL,
    Id_num varchar(30) NOT NULL,
    UID INT NOT NULL,
    Address varchar(200) NOT NULL,
    Aity varchar(30) NOT NULL,
    Country varchar(30) NOT NULL,
    Balance float NOT NULL,
    Admin boolean default false,
    UNIQUE(UID, Email, Phone)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Table structure for table bidding
CREATE TABLE IF NOT EXISTS bidding(
    id INT(30) NOT NULL,
    user_id VARCHAR(30) NOT NULL,
    product_id VARCHAR(30) NOT NULL,
    amount float NOT NULL,
    status tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=bid,2=confirmed,3=cancelled',
    date_created datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    UNIQUE(id, user_id, product_id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Table structure for table category
CREATE TABLE IF NOT EXISTS category(
    id INT(30) NOT NULL,
    name VARCHAR(30) NOT NULL,
    UNIQUE(id, name)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Table structure for table product
CREATE TABLE IF NOT EXISTS product(
    id INT(30) NOT NULL,
    category_id VARCHAR(30) NOT NULL,
    name VARCHAR(30) NOT NULL,
    description TEXT NOT NULL,
    start_bid float NOT NULL,
    price float NOT NULL,
    bid_start_time datetime NOT NULL,
    bid_end_time datetime NOT NULL,
    image text NOT NULL,
    date_created datetime NOT NULL DEFAULT current_timestamp(),
    UNIQUE(id, category_id, name, bid_end_time)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

# DROP TABLE IF EXISTS account;
# DROP TABLE IF EXISTS bidding;
# DROP TABLE IF EXISTS branch;
# DROP TABLE IF EXISTS category;
# DROP TABLE IF EXISTS product;

-- Indexes for table bidding
ALTER TABLE bidding
    ADD PRIMARY KEY (id);

-- Indexes for table category
ALTER TABLE category
    ADD PRIMARY KEY (id);

-- Indexes for table product
ALTER TABLE product
    ADD PRIMARY KEY (id, bid_end_time);

-- Indexes for table product
ALTER TABLE branch
    ADD PRIMARY KEY (code);

-- Indexes for table product
ALTER TABLE account
    ADD PRIMARY KEY (id);

-- AUTO_INCREMENT for table bidding
ALTER TABLE bidding
    MODIFY id INT(30) NOT NULL AUTO_INCREMENT;

-- AUTO_INCREMENT for table category
ALTER TABLE category
    MODIFY id INT(30) NOT NULL AUTO_INCREMENT;

-- AUTO_INCREMENT for table product
ALTER TABLE product
    MODIFY id INT(30) NOT NULL AUTO_INCREMENT;

-- AUTO_INCREMENT for table branch
ALTER TABLE branch
    MODIFY code INT(30) NOT NULL AUTO_INCREMENT;

-- AUTO_INCREMENT for table account
ALTER TABLE account
    MODIFY id INT(30) NOT NULL AUTO_INCREMENT;

ALTER TABLE account
    ADD INDEX idx_country (country);
SELECT * from account where country = 'Vietnam';

ALTER TABLE product
    ADD INDEX idx_name (name);
SELECT * from product where name like 'New%';

ALTER TABLE product
    PARTITION BY RANGE COLUMNS(bid_end_time)(
    PARTITION p0 VALUES LESS THAN ('2020-01-01'),
    PARTITION p1 VALUES LESS THAN ('2020-03-01'),
    PARTITION p2 VALUES LESS THAN ('2020-04-01'),
    PARTITION p3 VALUES LESS THAN ('2020-06-01'),
    PARTITION p4 VALUES LESS THAN ('2020-07-01'),
    PARTITION p5 VALUES LESS THAN ('2020-10-01'),
    PARTITION p6 VALUES LESS THAN ('2020-11-01'),
    PARTITION p7 VALUES LESS THAN ('2020-12-01')
    );

ALTER TABLE account
    PARTITION BY RANGE (id)(
    PARTITION p0 VALUES LESS THAN (10),
    PARTITION p1 VALUES LESS THAN (20),
    PARTITION p2 VALUES LESS THAN (30),
    PARTITION p3 VALUES LESS THAN (40),
    PARTITION p4 VALUES LESS THAN (maxvalue)
    );

