--
-- Database: wiziShop
--

-- --------------------------------------------------------

--
-- Table structure for table products
--

CREATE TABLE products (
  id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  title varchar(255) NOT NULL,
  description text NOT NULL,
  price double NOT NULL,
  stock int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table structure for table users
--

CREATE TABLE users (
  id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  lastname varchar(255) NOT NULL,
  mail varchar(255) NOT NULL,
  secrets text NOT NULL,
  role tinyint(1) NOT NULL DEFAULT 0,
  passwords text NOT NULL,
  creation_date datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
