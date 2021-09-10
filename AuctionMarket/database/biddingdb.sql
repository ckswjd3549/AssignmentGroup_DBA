-- Table structure for table branch
# CREATE SCHEMA bidding_system;
# USE bidding_system;
CREATE TABLE IF NOT EXISTS branch(
                                     code INT NOT NULL,
                                     name varchar(30) NOT NULL,
    address varchar(200) NOT NULL,
    hotline_number varchar(15) NOT NULL,
    UNIQUE(code, name)
    )ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table branch
INSERT INTO branch values (1, 'Online bidding system', '702 Nguyen Van Linh, Tan Hung, Quan 7, Thanh pho Ho Chi Minh 700000', '0778139985');

-- Table structure for table account
CREATE TABLE IF NOT EXISTS account(
    email varchar(200) NOT NULL,
    phone varchar(30) NOT NULL,
    password varchar(30) NOT NULL,
    first_name varchar(30) NOT NULL,
    last_name varchar(30) NOT NULL,
    id INT(30) NOT NULL,
    address varchar(200) NOT NULL,
    city varchar(30) NOT NULL,
    country varchar(30) NOT NULL,
    profile_image text NOT NULL,
    balance float NOT NULL,
    UNIQUE(id, email, phone)
    )ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data is automatically executed in register.php page.

-- Table structure for table bidding
CREATE TABLE IF NOT EXISTS bidding(
                                      id INT NOT NULL,
                                      user_id INT(30) NOT NULL,
    product_id INT(30) NOT NULL,
    amount INT NOT NULL,
    status tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=bid,2=confirmed,3=cancelled',
    date_created datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    UNIQUE(id, user_id, product_id, amount)
    )ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table bidding
INSERT INTO bidding VALUES(1, 5, 1, 300, 1, '2020-10-27 14:18:50');
INSERT INTO bidding VALUES(4, 5, 3, 155000, 1, '2020-10-27 16:37:29');

-- Table structure for table category
CREATE TABLE IF NOT EXISTS category(
                                       id INT NOT NULL,
                                       name VARCHAR(30) NOT NULL,
    UNIQUE(id, name)
    )ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table category
INSERT INTO category VALUES(1, 'Sample Category'),
                           (2, 'Appliances'),
                           (3, 'Desktop Computers'),
                           (4, 'Laptop'),
                           (5, 'Mobile Phone'),
                           (6, 'hobbies'),
                           (7, 'history');

-- Table structure for table product
CREATE TABLE IF NOT EXISTS product(
                                      id INT NOT NULL,
                                      category_id INT(30) NOT NULL,
    name VARCHAR(30) NOT NULL,
    bid_start_time float NOT NULL,
    price float NOT NULL,
    bid_end_time datetime NOT NULL,
    date_created datetime NOT NULL DEFAULT current_timestamp(),
    UNIQUE(id, category_id, name)
    )ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table product
INSERT INTO product VALUES(1, 5, 'Sample Smart Phone',  7000, 7000, '2020-10-27 19:00:00', '2020-10-27 09:50:54'),
                          (3, 1, 'Gadget Package',  150000, 15000, '2020-10-27 17:00:00', '2020-10-27 09:59:39');

# DROP TABLE IF EXISTS account;
# DROP TABLE IF EXISTS bidding;
# DROP TABLE IF EXISTS branch;
# DROP TABLE IF EXISTS category;
# DROP TABLE IF EXISTS product;

-- Indexes for table bidding
ALTER TABLE bidding
    ADD PRIMARY KEY (id, amount);

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
    MODIFY id INT NOT NULL AUTO_INCREMENT;

-- AUTO_INCREMENT for table category
ALTER TABLE category
    MODIFY id INT NOT NULL AUTO_INCREMENT;

-- AUTO_INCREMENT for table product
ALTER TABLE product
    MODIFY id INT NOT NULL AUTO_INCREMENT;

-- AUTO_INCREMENT for table branch
ALTER TABLE branch
    MODIFY code INT NOT NULL AUTO_INCREMENT;

-- AUTO_INCREMENT for table account
ALTER TABLE account
    MODIFY id INT NOT NULL AUTO_INCREMENT;

ALTER TABLE category
    ADD INDEX idx_country (name);

SELECT * from category where name = 'Appliances';

ALTER TABLE bidding
    PARTITION BY RANGE (amount)(
    PARTITION p0 VALUES LESS THAN (100),
    PARTITION p1 VALUES LESS THAN (200),
    PARTITION p2 VALUES LESS THAN (300),
    PARTITION p3 VALUES LESS THAN (500),
    PARTITION p4 VALUES LESS THAN (1000),
    PARTITION p5 VALUES LESS THAN (2000),
    PARTITION p6 VALUES LESS THAN (5000),
    PARTITION p7 VALUES LESS THAN (maxvalue)
    );

SELECT * FROM bidding where amount = 300;

DELIMITER $$

create procedure sp_bidding_price(in b_id INT, in new_amount INT)
begin
update bidding set amount = new_amount
where id = b_id;
end $$

DELIMITER ;

call sp_bidding_price('1', 100);

delimiter $$

create trigger tgr_prevent_bidding_amount
    before update on bidding
    for each row
begin
    if old.amount >= new.amount then
        signal sqlstate '45000' set message_text = 'Bidding amount must be higher than current price';
end if;
end $$

delimiter ;


