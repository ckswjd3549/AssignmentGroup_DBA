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
    email varchar(200) NOT NULL,
    phone varchar(30) NOT NULL,
    password varchar(30) NOT NULL,
    first_name varchar(30) NOT NULL,
    last_name varchar(30) NOT NULL,
    id_num varchar(30) NOT NULL,
    id INT NOT NULL,
    address varchar(200) NOT NULL,
    city varchar(30) NOT NULL,
    country varchar(30) NOT NULL,
    balance float NOT NULL,
    admin boolean default false,
    UNIQUE(id, email, phone)
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
    bid_start_time float NOT NULL,
    price float NOT NULL,
    bid_end_time datetime NOT NULL,
    image text NOT NULL,
    date_created datetime NOT NULL DEFAULT current_timestamp(),
    UNIQUE(id, category_id, name)
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
    ADD PRIMARY KEY (id);

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

