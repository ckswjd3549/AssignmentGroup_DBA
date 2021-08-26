CREATE TABLE IF NOT EXISTS branch(
    code varchar(30) NOT NULL,
    name varchar(30) NOT NULL,
    address varchar(30) NOT NULL,
    hotline_number varchar(15) NOT NULL,
    UNIQUE(code, name)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
    balance float NOT NULL
    UNIQUE(email, phone, id)
);

CREATE TABLE IF NOT EXISTS bidding(
    id VARCHAR(30) NOT NULL,
    user_id VARCHAR(30) NOT NULL,
    product_id VARCHAR(30) NOT NULL,
    amount float NOT NULL,
    status tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=bid,2=confirmed,3=cancelled',
    date_created datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
)