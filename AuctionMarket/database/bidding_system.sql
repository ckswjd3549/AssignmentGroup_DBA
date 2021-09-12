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
    Email varchar(200) NOT NULL,
    Phone varchar(30) NOT NULL,
    Password varchar(30) NOT NULL,
    First_name varchar(30) NOT NULL,
    Last_name varchar(30) NOT NULL,
    Id_num varchar(30) NOT NULL,
    UID INT NOT NULL,
    Address varchar(200) NOT NULL,
    City varchar(30) NOT NULL,
    Country varchar(30) NOT NULL,
    Balance float NOT NULL,
    Admin boolean default false,
    UNIQUE(UID, Email, Phone)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data is automatically executed in register.php page.

-- Table structure for table auction
CREATE TABLE IF NOT EXISTS auction(
    AID INT NOT NULL,
    UID VARCHAR(30) NOT NULL,
    Product VARCHAR(30) NOT NULL,
    Amount INT NOT NULL,
    Status tinyint NOT NULL DEFAULT 1 ,
    Closing_time datetime NOT NULL,
    Date_created datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    Ongoing boolean default false,
	Bid_count INT NOT NULL default 0,
    Latest_bidder INT not null default 0,
    UNIQUE(AID, UID, Product, Amount)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table auction
Insert into auction(`UID`, `Product`, `Amount`,`Closing_time`) VALUES('3','c','1','2021-09-10-20:00');

-- Table structure for table bidlist
CREATE TABLE IF NOT EXISTS bidlist(
	AID INT NOT NULL,
	BID INT NOT NULL,
	UID INT NOT NULL,	
    Product VARCHAR(30) NOT NULL,
    Amount INT NOT NULL,
    date_created datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    UNIQUE(BID, UID, Product, Amount)
    )ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table bidlist
Insert into bidlist(`UID`, `Product`, `Amount`,`AID`) VALUES('3','c','3.5','4');

-- Table structure for table auction
CREATE TABLE IF NOT EXISTS Transaction(
	TID INT NOT NULL,
	Deposit_UID INT NOT NULL,
	Recipent_UID INT NOT NULL,
	Amount INT NOT NULL,
    date_created datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    UNIQUE(TID, Deposit_UID,Amount)
    )ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table transaction
INSERT INTO transaction(`Deposit_UID`, `Recipent_UID`, `Amount`)
values('1','2','3');
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

-- Indexes for table auction
ALTER TABLE auction
    ADD PRIMARY KEY (AID, Amount);

-- Indexes for table bidlist
ALTER TABLE bidlist
    ADD PRIMARY KEY (BID, amount);

-- Indexes for table Transaction
ALTER TABLE Transaction
    ADD PRIMARY KEY (TID, amount);

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

-- AUTO_INCREMENT for table auction
ALTER TABLE auction
    MODIFY AID INT NOT NULL AUTO_INCREMENT;

-- AUTO_INCREMENT for table bidlist
ALTER TABLE bidlist
    MODIFY BID INT NOT NULL AUTO_INCREMENT;

-- AUTO_INCREMENT for table Transaction
ALTER TABLE Transaction
    MODIFY TID INT NOT NULL AUTO_INCREMENT;

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

ALTER TABLE auction
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

SELECT * FROM auction where amount = 300;

DELIMITER $$

create procedure sp_bidding_price(in b_id INT, in new_amount INT)
begin
update auction set amount = new_amount
where UID = b_id;
end $$

DELIMITER ;

call sp_bidding_price('1', 100);

delimiter $$

create trigger tgr_prevent_bidding_amount
    before update on auction
    for each row
begin
    if old.amount >= new.amount then
        signal sqlstate '45000' set message_text = 'Bidding amount must be higher than current price';
end if;
end $$

delimiter ;


