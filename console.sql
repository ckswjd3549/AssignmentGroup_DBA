-- Table structure for table branch
CREATE TABLE IF NOT EXISTS branch(
    code varchar(30) NOT NULL,
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
    id varchar(30) NOT NULL,
    address varchar(200) NOT NULL,
    city varchar(30) NOT NULL,
    country varchar(30) NOT NULL,
    profile_image text NOT NULL,
    balance float NOT NULL,
    UNIQUE(email, phone, id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Table structure for table bidding
CREATE TABLE IF NOT EXISTS bidding(
    id VARCHAR(30) NOT NULL,
    user_id VARCHAR(30) NOT NULL,
    product_id VARCHAR(30) NOT NULL,
    amount float NOT NULL,
    status tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=bid,2=confirmed,3=cancelled',
    date_created datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    UNIQUE(id, user_id, product_id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Table structure for table category
CREATE TABLE IF NOT EXISTS category(
    id VARCHAR(30) NOT NULL,
    name VARCHAR(30) NOT NULL,
    UNIQUE(id, name)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Table structure for table product
CREATE TABLE IF NOT EXISTS product(
    id VARCHAR(30) NOT NULL,
    category_id VARCHAR(30) NOT NULL,
    name VARCHAR(30) NOT NULL,
    description TEXT NOT NULL,
    start_bid float NOT NULL,
    price float NOT NULL,
    bid_end_time datetime NOT NULL,
    image text NOT NULL,
    date_created datetime NOT NULL DEFAULT current_timestamp(),
    UNIQUE(id, category_id, name)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- AUTO_INCREMENT for table bidding
ALTER TABLE bidding
    MODIFY id VARCHAR(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

-- AUTO_INCREMENT for table category
ALTER TABLE category
    MODIFY id VARCHAR(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

-- AUTO_INCREMENT for table product
ALTER TABLE product
    MODIFY id VARCHAR(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

-- AUTO_INCREMENT for table branch
ALTER TABLE branch
    MODIFY code VARCHAR(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

-- AUTO_INCREMENT for table account
ALTER TABLE account
    MODIFY id VARCHAR(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;