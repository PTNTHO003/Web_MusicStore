create database if not exists `AudioStoreDB` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
use `AudioStoreDB`;

-- Table structure for category
drop table if exists `T_CATEGORY`;
create table if not exists `T_CATEGORY` (
	`CATE_ID` int(10) not null auto_increment,
	`CATE_NAME` varchar(64)  DEFAULT NULL,
    `CATE_DESC` varchar(255)  DEFAULT NULL,
  PRIMARY KEY (`CATE_ID`)
) ;

-- Table structure for brand

drop table if exists `T_BRAND`;
create table if not exists `T_BRAND` (
	`BRAND_ID` INT(10) not null auto_increment,
    `BRAND_NAME` varchar(64)  NOT NULL,
    `BRAND_DESCRIPTION` varchar(255)  DEFAULT NULL,
    `BRAND_IMAGEURL` varchar(255)  DEFAULT NULL,
    PRIMARY KEY (`BRAND_ID`)
) ;

-- Table structure for device table

drop table if exists `T_DEVICE`;
create table if not exists `T_DEVICE` (
	`DEV_ID` INT(10) NOT NULL AUTO_INCREMENT,
    `DEV_NAME` VARCHAR(255)  NOT NULL,
    `CATE_ID` int(10) not null ,
    `BRAND_ID` INT(10) not null,
    `DEV_IMAGEURL` VARCHAR(255)  NOT NULL,
    `DEV_PRICE` DECIMAL(12,2) NOT NULL,
    primary key (`DEV_ID`),
    foreign key (`CATE_ID`) references `T_CATEGORY` (`CATE_ID`),
    foreign key (`BRAND_ID`) references `T_BRAND` (`BRAND_ID`)
) ;

-- Table structure for employee table

drop table if exists `T_EMPLOYEE`;
create table if not exists `T_EMPLOYEE` (
	`EMP_ID` char (8) not null,
    `EMP_NAME` varchar(255)  NOT NULL,
    `EMP_PHONE` varchar(11)  NOT NULL UNIQUE,
    `EMP_EMAIL` varchar(255)  NOT NULL UNIQUE,
    `EMP_ACCOUNT` varchar(255)  NOT NULL UNIQUE,
    `EMP_PASSWORD` varchar(255)  NOT NULL,
    PRIMARY KEY (`EMP_ID`)
) ;

-- Table structure for Customer

drop table if exists `T_CUSTOMER`;
create table if not exists `T_CUSTOMER` (
    `CUSTOMER_ID` int(10)  NOT NULL auto_increment,
	`CUSTOMER_PHONE` varchar(11)  NOT NULL UNIQUE,
    `CUSTOMER_NAME` VARCHAR(255)  NOT NULL,
    `CUSTOMER_EMAIL` VARCHAR(255)  NOT NULL UNIQUE,
    `CUSTOMER_ADDRESS` VARCHAR(255)  NOT NULL,
    `CUSTOMER_ACCOUNT` VARCHAR(255)  NOT NULL unique,
    `CUSTOMER_PASSWORD` VARCHAR(255)  NOT NULL,
    primary key(`CUSTOMER_ID`)
) ;

-- table structure for order table

drop table if exists `T_ORDER`;
create table if not exists `T_ORDER` (
	`ORDER_ID` INT(10) NOT NULL AUTO_INCREMENT,
	`CUSTOMER_PHONE` VARCHAR(11)  NOT NULL,
    `ORDER_DATETIME` timestamp default CURRENT_TIMESTAMP,
    `ORDER_TOTAL_AMOUNT` decimal(12,2) not null,
    `ORDER_NOTES` varchar(255) ,
    primary key (`ORDER_ID`),
    foreign key (`CUSTOMER_PHONE`) references `T_CUSTOMER` (`CUSTOMER_PHONE`)
) ;

-- table structure for table order-items

drop table if exists `T_ORDER-DEVICES`;
CREATE TABLE IF NOT EXISTS `T_ORDER-DEVICES` (
    `ORDER_ID` INT(10)  NOT NULL,
    `DEV_ID` INT(10) NOT NULL,
    PRIMARY KEY (`ORDER_ID`, `DEV_ID`),
    FOREIGN KEY (ORDER_ID) REFERENCES T_ORDER(ORDER_ID),
    FOREIGN KEY (DEV_ID) REFERENCES T_DEVICE(DEV_ID)
);

-- table structure for table temporary order

DROP TABLE IF EXISTS `T_TEMPORARY_ORDER`;
CREATE TABLE IF NOT EXISTS `T_TEMPORARY_ORDER` (
    `TEMP_ORDER_ID` INT(10)  NOT NULL AUTO_INCREMENT,
    `CUSTOMER_PHONE` VARCHAR(11) NOT NULL,
    `Order_DateTime` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `Total_amount` INT(12),
    `ORDER_NOTES` varchar(255),
    PRIMARY KEY (`TEMP_ORDER_ID`),
    FOREIGN KEY (`CUSTOMER_PHONE`) REFERENCES `T_CUSTOMER`(`CUSTOMER_PHONE`)
);

-- Table structure for table temporary order-devices

DROP TABLE IF EXISTS `T_TEMPORARY_ORDER_DEVICES`;
CREATE TABLE IF NOT EXISTS `T_TEMPORARY_ORDER_DEVICES` (
    `TEMP_ORDER_ID` int(10) NOT NULL,
    `DEV_ID` int(10) NOT NULL,
    PRIMARY KEY (`TEMP_ORDER_ID`, `DEV_ID`),
    FOREIGN KEY (`TEMP_ORDER_ID`) REFERENCES `T_TEMPORARY_ORDER`(`TEMP_ORDER_ID`),
    FOREIGN KEY (`DEV_ID`) REFERENCES `T_DEVICE`(`DEV_ID`)
);

-- dumping data for t_category

insert into `T_CATEGORY`(`CATE_NAME`,`CATE_DESC`)
values
('Wired In-ear headphones', 'Reliable, high-quality sound without the hassle of charging.'),
('Wired On-ear headphones', 'Comfortable fit, immersive sound for extended listening.'),
('Wireless In-ear headphones', 'Convenient, tangle-free listening on the go.'),
('Wireless On-ear headphones', 'Seamless wireless experience, long-lasting battery.'),
('Digital Music Player', 'Compact, high-fidelity music on the move.'),
('Wired Speaker', 'Crisp, clear sound for home entertainment.'),
('Wireless Speaker', 'Portable, Bluetooth-enabled audio streaming.'),
('Audio Accessories', 'Enhance your setup with cables, adapters, and more.');


-- Dumping data for t_brand

insert into `T_BRAND` (`BRAND_NAME`, `BRAND_DESCRIPTION`, `BRAND_IMAGEURL`)
values
('SONY', 'Sony is a major Japanese manufacturer of consumer electronics products. It was established in 1946 as Tokyo Tsushin Kogyo by Masaru Ibuka and Akio Morita. 
Sony is known for creating products such as the transistor radio TR-55, the home video tape recorder CV-2000, the portable audio player Walkman, and the compact disc player CDP-101', 'Sony_Logo.jpg'),
('JBL', 'JBL is an American audio equipment manufacturer headquartered in Los Angeles, California, United States. JBL serves the customer home and professional market.', 'JBL_Logo.png'),
('BOSE', 'Bose Corporation is an American manufacturing company that predominantly sells audio equipments. The company was established by Amar Bose in 1964 and is based in Framingham, Massachusetts1. 
It is best known for its home audio systems and speakers, noise cancelling headphones, professional audio products and automobile sound systems', 'Bose_Logo.jpg'),
('MARSHALL', 'Marshall, a legendary name in the world of music amplification, has been synonymous with powerful sound and iconic design for over 60 years. Founded by Jim Marshall, a shop owner and drummer, the company has left an indelible mark on the music industry.', 'Marshall_Logo.png'),
('YAMAHA', "As the world's leading manufacturer of musical instruments and audio equipment, Yamaha is uniquely positioned to express every sound as the artist intended. Sound that delivers incredibly detailed and accurate timbre in each note. 
Sound experienced by the emotive contrast between stillness and motion.", 'Yamaha_Logo.png');

-- Dumping data into T_DEVICE

-- Devices for SONY
INSERT INTO `T_DEVICE` (`DEV_NAME`, `CATE_ID`, `BRAND_ID`, `DEV_IMAGEURL`, `DEV_PRICE`)
VALUES
('Wireless In-ear headphones WF-1000XM5', 3, 1, 'WF-1000XM5.jpg', 199.99),
('Wireless In-ear headphones WF-1000XM4', 3, 1, 'WF-1000XM4.png', 179.99),
('Wireless On-ear headphones WH-1000XM5', 4, 1, 'WH-1000XM5.jpg', 349.99),
('Wireless On-ear headphones WH-1000XM4', 4, 1, 'WH-1000XM4.jpg', 299.99),
('Wired On-ear headphones MDR-Z1R', 2, 1, 'MDR-Z1R.jpg', 1699.99),
('Wired On-ear headphones MDR-Z7M2', 2, 1, 'MDR-Z7M2.jpg', 699.99),
('Wired On-ear headphones MDR-MV1', 2, 1, 'MDR-MV1.jpg', 299.99),
('Wired In-ear headphones MDR-EX15AP', 1, 1, 'MDR-EX15AP.jpg', 19.99),
('Wired In-ear headphones IER-M9', 1, 1, 'IER-M9.jpg', 899.99),
('Digital Music Player Walkman NW-WM1ZM2', 5, 1, 'Walkman NW-WM1ZM2.jpg', 3199.99),
('Digital Music Player Walkman NW-WM1AM2', 5, 1, 'Walkman NW-WM1AM2.jpg', 2199.99);

-- Devices for JBL
INSERT INTO `T_DEVICE` (`DEV_NAME`, `CATE_ID`, `BRAND_ID`, `DEV_IMAGEURL`, `DEV_PRICE`)
VALUES
('Wireless Speaker Charge 5', 7, 2, 'Charge 5.jpg', 179.95),
('Wireless Speaker Flip 6', 7, 2, 'Flip 6.jpg', 129.95),
('Wireless Speaker Xtreme 3', 7, 2, 'Xtreme 3.jpg', 349.95),
('Wireless Speaker Boombox 3', 7, 2, 'Boombox 3.jpg', 499.95),
('Wireless Speaker Flip Essential 2', 7, 2, 'Flip Essential 2.jpg', 99.95),
('Wireless Speaker Wind 3S', 7, 2, 'Wind 3S.jpg', 99.95),
('Wireless In-ear headphones Live Pro 2 TWS', 3, 2, 'Live Pro 2 TWS.jpg', 179.95),
('Wireless In-ear headphones Wave Beam', 3, 2, 'Wave Beam.jpg', 79.95),
('Wireless In-ear headphones Tune Beam', 3, 2, 'Tune Beam.jpg', 99.95),
('Wireless On-ear headphones Tune 520BT', 4, 2, 'Tune 520BT.jpg', 59.95),
('Wireless On-ear headphones Tour One M2', 4, 2, 'Tour One_M2.jpg', 199.95),
('Audio Accessories Stadium GTO 600C', 8, 2, 'Stadium GTO 600C.png', 179.95),
('Audio Accessories Club 605CSQ', 8, 2, 'Club 605CSQ.jpg', 119.95),
('Audio Accessories Stage3 607C', 8, 2, 'Stage3 607C.jpg', 69.95);

-- Devices for BOSE
INSERT INTO `T_DEVICE` (`DEV_NAME`, `CATE_ID`, `BRAND_ID`, `DEV_IMAGEURL`, `DEV_PRICE`)
VALUES
('Wireless In-ear headphones Bose Ultra Open Earbuds', 3, 3, 'Bose Ultra Open Earbuds.jpg', 199.00),
('Wireless In-ear headphones Bose QuietComfort Ultra Earbuds', 3, 3, 'Bose QuietComfort Ultra Earbuds.jpg', 279.00),
('Wireless On-ear headphones Bose QuietComfort Ultra Headphones', 4, 3, 'Bose QuietComfort Ultra Headphones.jpg', 349.00),
('Wireless On-ear headphones Bose QuietComfort Headphones', 4, 3, 'Bose QuietComfort Headphones.jpg', 299.00),
('Wireless On-ear headphones Bose A30 Aviation Headset', 4, 3, 'Bose A30 Aviation Headset.jpg', 995.00),
('Audio Accessories Bose Ultra Open Earbuds Wireless Charging Case Cover', 8, 3, 'Bose Ultra Open Earbuds Wireless Charging Case Cover.png', 39.00),
('Audio Accessories AirFly SE', 8, 3, 'AirFly SE.png', 49.00),
('Audio Accessories AirFly Pro', 8, 3, 'AirFly Pro.png', 69.00),
('Audio Accessories Bose Wireless Charging Case Cover', 8, 3, 'Bose Wireless Charging Case Cover.jpg', 39.00),
('Audio Accessories QuietComfort 45 Headphones Ear Cushion Kit', 8, 3, 'QuietComfort 45 Headphones Ear Cushion Kit.jpg', 29.00);

-- Devices for Marshall
INSERT INTO `T_DEVICE` (`DEV_NAME`, `CATE_ID`, `BRAND_ID`, `DEV_IMAGEURL`, `DEV_PRICE`)
VALUES
('Wireless Speaker ACTON III BLACK', 7, 4, 'MRSHL-ACTON III BLACK.jpeg', 299.99),
('Wireless Speaker ACTON III BROWN', 7, 4, 'MRSHL-ACTON III BROWN.jpg', 299.99),
('Wireless Speaker ACTON III CREAM', 7, 4, 'MRSHL-ACTON III CREAM.jpg', 299.99),
('Wireless Speaker STANMORE III BLACK', 7, 4, 'MRSHL-STANMORE III BLACK.jpg', 399.99),
('Wireless Speaker WOBURN III BLACK', 7, 4, 'MRSHL-WOBURN III BLACK.jpg', 499.99),
('Wireless Speaker WOBURN III CREAM', 7, 4, 'MRSHL-WOBURN III CREAM.jpg', 499.99),
('Wireless On-ear headphones MONITOR II A.N.C. BLACK', 4, 4, 'MRSHL-MONITOR II A.N.C BLACK.jpg', 349.99),
('Wireless On-ear headphones MAJOR IV BLACK', 4, 4, 'MRSHL-MAJOR IV BLACK.jpg', 149.99),
('Wireless On-ear headphones MAJOR IV BROWN', 4, 4, 'MRSHL-MAJOR IV BROWN.jpg', 149.99),
('Wireless in-ear headphones MOTIF II A.N.C BLACK', 3, 4, 'MRSHL-MOTIF II A.N.C BLACK.png', 249.99),
('Wireless in-ear headphones MINOR III BLACK', 3, 4, 'MRSHL-MINOR III BLACK.png', 129.99);

-- Devices for Yamaha
INSERT INTO `T_DEVICE` (`DEV_NAME`, `CATE_ID`, `BRAND_ID`, `DEV_IMAGEURL`, `DEV_PRICE`)
VALUES
('Wired Speaker CZR15', 6, 5, 'YAMAHA-CZR15.jpg', 1299.00),
('Wired Speaker CZR12', 6, 5, 'YAMAHA-CZR12.jpg', 1099.00),
('Wired Speaker CZR10', 6, 5, 'YAMAHA-CZR10.jpg', 999.00),
('Wired Speaker CXS18XLF', 6, 5, 'YAMAHA-CXS18XLF.jpg', 1999.00),
('Wired Speaker CXS15XLF', 6, 5, 'YAMAHA-CXS15XLF.jpg', 1799.00),
('Wireless Speaker TRUE X SPEAKER 1A', 7, 5, 'YAMAHA-TRUE-X-1A.jpg', 499.00),
('Wireless Speaker WS-B1A', 7, 5, 'YAMAHA-WS-B1A.jpg', 399.00),
('Audio Accessories HXC-SC020', 8, 5, 'YAMAHA-HXC-SC020.jpg', 29.00),
('Audio Accessories HUC-SC020', 8, 5, 'YAMAHA-HUC-SC020.jpg', 39.00),
('Audio Accessories HBC-SC020', 8, 5, 'YAMAHA-HBC-SC020.jpg', 49.00);

-- Dumping data into emp table 

INSERT INTO `T_EMPLOYEE` (`EMP_ID`, `EMP_NAME`, `EMP_PHONE`, `EMP_EMAIL`, `EMP_ACCOUNT`, `EMP_PASSWORD`)
values
('tama0001', 'Le Thanh Tam', '0934567890', 'tamam1kaj@gmail.com', 'admin1', '123'),
('thoa0001', 'Pham Thi Ngoc Tho', '0934567190', 'thoam1kaj@gmail.com', 'admin2', '123');

-- Dumping data into customers table

INSERT INTO `T_CUSTOMER` (`CUSTOMER_PHONE`,`CUSTOMER_NAME`, `CUSTOMER_EMAIL`, `CUSTOMER_ADDRESS`, `CUSTOMER_ACCOUNT`, `CUSTOMER_PASSWORD`)
VALUES
('08765432109', 'Alice Johnson', 'alice@example.com', '321 Đường Số 1, Quận A, Thành phố HCM', 'alice_johnson321', 'password987'),
('09654321098', 'Bob Smith', 'bob@example.com', '654 Đường Số 2, Quận B, Thành phố Hà Nội', 'bob_smith654', 'password876'),
('07543210987', 'Sarah Brown', 'sarah@example.com', '987 Đường Số 3, Quận C, Thành phố Đà Nẵng', 'sarah_brown987', 'password765'),
('09432109876', 'Ryan Davis', 'ryan@example.com', '210 Đường Số 4, Quận D, Thành phố Cần Thơ', 'ryan_davis210', 'password654'),
('09321098765', 'Emma Wilson', 'emma@example.com', '543 Đường Số 5, Quận E, Thành phố Hải Phòng', 'emma_wilson543', 'password543');
