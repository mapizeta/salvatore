-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb2
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 12-08-2013 a las 19:39:58
-- Versión del servidor: 5.5.31
-- Versión de PHP: 5.4.4-14+deb7u2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `puntoventa`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `app_config`
--

CREATE TABLE IF NOT EXISTS `app_config` (
  `key` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `app_config`
--

INSERT INTO `app_config` (`key`, `value`) VALUES
('address', 'Calle Principal N°1234'),
('company', 'Punto de venta'),
('default_tax_1_name', 'IVA'),
('default_tax_1_rate', '19'),
('default_tax_2_name', 'iva2'),
('default_tax_2_rate', ''),
('default_tax_rate', '8'),
('email', 'admin@puntodeventa.com'),
('fax', ''),
('language', 'spanish'),
('phone', '045232323'),
('print_after_sale', 'print_after_sale'),
('return_policy', 'Test'),
('version', '10.0'),
('website', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id_category` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`id_category`),
  KEY `id_category` (`id_category`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `customers`
--

CREATE TABLE IF NOT EXISTS `customers` (
  `person_id` int(10) NOT NULL,
  `account_number` varchar(255) DEFAULT NULL,
  `taxable` int(1) NOT NULL DEFAULT '1',
  UNIQUE KEY `account_number` (`account_number`),
  KEY `person_id` (`person_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `customers`
--

INSERT INTO `customers` (`person_id`, `account_number`, `taxable`) VALUES
(3, NULL, 1),
(4, NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `document`
--

CREATE TABLE IF NOT EXISTS `document` (
  `id_document` int(11) NOT NULL AUTO_INCREMENT,
  `person_id` int(11) NOT NULL,
  `num_doc` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `contacto` varchar(100) NOT NULL,
  `fk_id_type_doc` int(11) NOT NULL,
  `fk_rut` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL,
  `afecto_adicional` int(11) NOT NULL,
  `neto` int(11) NOT NULL,
  `valor_adicional` int(11) NOT NULL,
  `iva` int(11) NOT NULL,
  `valor_flete` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  PRIMARY KEY (`id_document`),
  KEY `fk_rut` (`fk_rut`),
  KEY `person_id` (`person_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

--
-- Volcado de datos para la tabla `document`
--

INSERT INTO `document` (`id_document`, `person_id`, `num_doc`, `fecha`, `contacto`, `fk_id_type_doc`, `fk_rut`, `subtotal`, `afecto_adicional`, `neto`, `valor_adicional`, `iva`, `valor_flete`, `total`) VALUES
(27, 32, 47037914, '2013-07-07', 'manuel pizarro', 1, 99554560, 0, 7154, 8462, 930, 0, 1308, 11000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `employees`
--

CREATE TABLE IF NOT EXISTS `employees` (
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `person_id` int(10) NOT NULL,
  UNIQUE KEY `username` (`username`),
  KEY `person_id` (`person_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `employees`
--

INSERT INTO `employees` (`username`, `password`, `person_id`) VALUES
('admin', '202cb962ac59075b964b07152d234b70 ', 1),
('pepino', '595beda5844fca23a0f38be617200324', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `name` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `item_number` varchar(255) DEFAULT NULL,
  `description` varchar(255) NOT NULL,
  `cost_price` double(15,2) NOT NULL,
  `unit_price` double(15,2) NOT NULL,
  `quantity` double(15,2) NOT NULL DEFAULT '0.00',
  `reorder_level` double(15,2) NOT NULL DEFAULT '0.00',
  `item_id` int(10) NOT NULL AUTO_INCREMENT,
  `allow_alt_description` tinyint(1) NOT NULL,
  `is_serialized` tinyint(1) NOT NULL,
  PRIMARY KEY (`item_id`),
  UNIQUE KEY `item_number` (`item_number`),
  KEY `phppos_items_ibfk_1` (`supplier_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Volcado de datos para la tabla `items`
--

INSERT INTO `items` (`name`, `category`, `supplier_id`, `item_number`, `description`, `cost_price`, `unit_price`, `quantity`, `reorder_level`, `item_id`, `allow_alt_description`, `is_serialized`) VALUES
('CATUN MAS CITRUS PET500X1', 'BEBIDAS', NULL, '000001', '', 500.00, 0.00, 10.00, 1.00, 10, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `items_taxes`
--

CREATE TABLE IF NOT EXISTS `items_taxes` (
  `item_id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `percent` double(15,2) NOT NULL,
  PRIMARY KEY (`item_id`,`name`,`percent`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `item_document`
--

CREATE TABLE IF NOT EXISTS `item_document` (
  `id_item_document` int(11) NOT NULL AUTO_INCREMENT,
  `fk_item_id` int(11) NOT NULL,
  `fk_id_document` int(11) NOT NULL,
  `g_valor_neto` int(11) NOT NULL,
  `g_valor_exento` int(11) NOT NULL,
  `g_iva` int(11) NOT NULL,
  `g_total` int(11) NOT NULL,
  `g_cantidad` int(11) NOT NULL,
  `i_valor_neto` int(11) NOT NULL,
  `i_valor_exento` int(11) NOT NULL,
  `i_iva` int(11) NOT NULL,
  `i_total` int(11) NOT NULL,
  `i_valor_sugerido` int(11) NOT NULL,
  `porcentaje_desc` int(11) NOT NULL,
  `i_valor_venta` int(11) NOT NULL,
  PRIMARY KEY (`id_item_document`),
  KEY `fk_item_id` (`fk_item_id`),
  KEY `fk_id_document` (`fk_id_document`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modules`
--

CREATE TABLE IF NOT EXISTS `modules` (
  `name_lang_key` varchar(255) NOT NULL,
  `desc_lang_key` varchar(255) NOT NULL,
  `sort` int(10) NOT NULL,
  `module_id` varchar(255) NOT NULL,
  PRIMARY KEY (`module_id`),
  UNIQUE KEY `desc_lang_key` (`desc_lang_key`),
  UNIQUE KEY `name_lang_key` (`name_lang_key`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `modules`
--

INSERT INTO `modules` (`name_lang_key`, `desc_lang_key`, `sort`, `module_id`) VALUES
('module_config', 'module_config_desc', 6, 'config'),
('module_customers', 'module_customers_desc', 1, 'customers'),
('module_documents', 'module_documents_desc', 2, 'documents'),
('module_employees', 'module_employees_desc', 5, 'employees'),
('module_items', 'module_items_desc', 2, 'items'),
('module_products', 'module_products_desc', 10, 'products'),
('module_reports', 'module_reports_desc', 3, 'reports'),
('module_sales', 'module_sales_desc', 4, 'sales'),
('module_suppliers', 'module_suppliers_desc', 3, 'suppliers');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `people`
--

CREATE TABLE IF NOT EXISTS `people` (
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address_1` varchar(255) NOT NULL,
  `address_2` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `zip` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `comments` text NOT NULL,
  `person_id` int(10) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`person_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

--
-- Volcado de datos para la tabla `people`
--

INSERT INTO `people` (`first_name`, `last_name`, `phone_number`, `email`, `address_1`, `address_2`, `city`, `state`, `zip`, `country`, `comments`, `person_id`) VALUES
('Pablo', 'Alvarez', '98989898', 'admin@puntoventa.cl', 'Mi casa 123', '', '', '', '', '', '', 1),
('Pepe', 'Perez', '', '', '', '', '', '', '', '', '', 2),
('cristian ', 'soto', '', '', '', '', '', '', '', '', '', 3),
('pepe', 'perez', '', '', '', '', '', '', '', '', '', 4),
('mauricio', 'perez', '666', '', 'Santander 02035', '', '', '', '', '', '', 6),
('Informatica Pehuen', '', '73299804', '', 'SaNTANDER 02035', '', '', '', '', '', '', 18),
('COMERCIAL CCU SA', '', '73299804', '', 'AVDA VITACURA 2670', '', '', '', '', '', '', 32);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permissions`
--

CREATE TABLE IF NOT EXISTS `permissions` (
  `module_id` varchar(255) NOT NULL,
  `person_id` int(10) NOT NULL,
  PRIMARY KEY (`module_id`,`person_id`),
  KEY `person_id` (`person_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `permissions`
--

INSERT INTO `permissions` (`module_id`, `person_id`) VALUES
('config', 1),
('customers', 1),
('documents', 1),
('employees', 1),
('items', 1),
('products', 1),
('reports', 1),
('sales', 1),
('suppliers', 1),
('customers', 2),
('items', 2),
('reports', 2),
('sales', 2),
('suppliers', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sales`
--

CREATE TABLE IF NOT EXISTS `sales` (
  `sale_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `customer_id` int(10) DEFAULT NULL,
  `employee_id` int(10) NOT NULL DEFAULT '0',
  `comment` text NOT NULL,
  `sale_id` int(10) NOT NULL AUTO_INCREMENT,
  `payment_type` varchar(512) DEFAULT NULL,
  PRIMARY KEY (`sale_id`),
  KEY `customer_id` (`customer_id`),
  KEY `employee_id` (`employee_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sales_items`
--

CREATE TABLE IF NOT EXISTS `sales_items` (
  `sale_id` int(10) NOT NULL DEFAULT '0',
  `item_id` int(10) NOT NULL DEFAULT '0',
  `description` varchar(30) DEFAULT NULL,
  `serialnumber` varchar(30) DEFAULT NULL,
  `line` int(3) NOT NULL DEFAULT '0',
  `quantity_purchased` double(15,2) NOT NULL DEFAULT '0.00',
  `item_cost_price` decimal(15,2) NOT NULL,
  `item_unit_price` double(15,2) NOT NULL,
  `discount_percent` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sale_id`,`item_id`,`line`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sales_items_taxes`
--

CREATE TABLE IF NOT EXISTS `sales_items_taxes` (
  `sale_id` int(10) NOT NULL,
  `item_id` int(10) NOT NULL,
  `line` int(3) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `percent` double(15,2) NOT NULL,
  PRIMARY KEY (`sale_id`,`item_id`,`line`,`name`,`percent`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sales_payments`
--

CREATE TABLE IF NOT EXISTS `sales_payments` (
  `sale_id` int(10) NOT NULL,
  `payment_type` varchar(40) NOT NULL,
  `payment_amount` decimal(15,2) NOT NULL,
  PRIMARY KEY (`sale_id`,`payment_type`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
--

CREATE TABLE IF NOT EXISTS `sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `user_agent` varchar(50) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `sessions`
--

INSERT INTO `sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('15c94f77a08e7d50a768a5ef38d20034', '190.160.253.150', 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.31 (K', 1367206465, 'a:5:{s:9:"person_id";s:1:"2";s:4:"cart";a:0:{}s:9:"sale_mode";s:4:"sale";s:8:"customer";s:2:"-1";s:8:"payments";a:0:{}}'),
('1976d82b6e6302b7630498ab2c33a64a', '190.217.192.47', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/53', 1367191575, 'a:5:{s:9:"person_id";s:1:"1";s:4:"cart";a:0:{}s:9:"sale_mode";s:4:"sale";s:8:"customer";s:2:"-1";s:8:"payments";a:0:{}}'),
('26136ecc8e67298135286ee5fbd49477', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; rv:21.0) Gecko/201001', 1370403032, ''),
('2b41d972eb2bc377555a17aba38f831b', '190.217.230.46', 'Mozilla/5.0 (X11; Linux x86_64; rv:10.0.12) Gecko/', 1370398365, 'a:5:{s:9:"person_id";s:1:"1";s:4:"cart";a:1:{i:1;a:11:{s:7:"item_id";s:1:"5";s:4:"line";i:1;s:4:"name";s:14:"Cuaderno Colon";s:11:"item_number";s:13:"7806505570597";s:11:"description";s:0:"";s:12:"serialnumber";s:0:"";s:21:"allow_alt_description";s:1:"0";s:13:"is_serialized";s:1:"0";s:8:"quantity";i:4;s:8:"discount";i:0;s:5:"price";s:7:"1200.00";}}s:9:"sale_mode";s:4:"sale";s:8:"customer";s:2:"-1";s:8:"payments";a:0:{}}'),
('2e51b88806280ecba6d1f793bcce11d6', '190.217.230.46', 'Mozilla/5.0 (Windows NT 6.1; rv:21.0) Gecko/201001', 1369689560, 'a:5:{s:9:"person_id";s:1:"1";s:4:"cart";a:1:{i:1;a:11:{s:7:"item_id";s:1:"1";s:4:"line";i:1;s:4:"name";s:15:"PERFUME ALTHEUS";s:11:"item_number";N;s:11:"description";s:0:"";s:12:"serialnumber";s:0:"";s:21:"allow_alt_description";s:1:"0";s:13:"is_serialized";s:1:"0";s:8:"quantity";i:1;s:8:"discount";i:0;s:5:"price";s:7:"6800.00";}}s:9:"sale_mode";s:4:"sale";s:8:"customer";s:2:"-1";s:8:"payments";a:0:{}}'),
('30c00362a8fbcaf6f0aa4fa7a50cb9c3', '190.217.192.47', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/53', 1367289685, 'a:5:{s:9:"person_id";s:1:"1";s:4:"cart";a:0:{}s:9:"sale_mode";s:4:"sale";s:8:"customer";s:2:"-1";s:8:"payments";a:0:{}}'),
('34b4c80888b44d8c77739e068649cd8c', '69.171.247.115', 'facebookexternalhit/1.1 (+http://www.facebook.com/', 1367205659, ''),
('3aa1e678eec12784bbcef9c8f5927d10', '190.217.230.46', 'Mozilla/5.0 (Windows NT 6.1; rv:20.0) Gecko/201001', 1369270178, 'a:5:{s:9:"person_id";s:1:"1";s:4:"cart";a:3:{i:1;a:11:{s:7:"item_id";s:1:"1";s:4:"line";i:1;s:4:"name";s:15:"PERFUME ALTHEUS";s:11:"item_number";N;s:11:"description";s:0:"";s:12:"serialnumber";s:0:"";s:21:"allow_alt_description";s:1:"0";s:13:"is_serialized";s:1:"0";s:8:"quantity";i:2;s:8:"discount";i:0;s:5:"price";s:7:"6800.00";}i:2;a:11:{s:7:"item_id";s:1:"2";s:4:"line";i:2;s:4:"name";s:7:"piscola";s:11:"item_number";N;s:11:"description";s:0:"";s:12:"serialnumber";s:0:"";s:21:"allow_alt_description";s:1:"0";s:13:"is_serialized";s:1:"0";s:8:"quantity";i:1;s:8:"discount";i:0;s:5:"price";s:7:"2000.00";}i:3;a:11:{s:7:"item_id";s:1:"3";s:4:"line";i:3;s:4:"name";s:7:"piscola";s:11:"item_number";N;s:11:"description";s:0:"";s:12:"serialnumber";s:0:"";s:21:"allow_alt_description";s:1:"0";s:13:"is_serialized";s:1:"0";s:8:"quantity";i:1;s:8:"discount";i:0;s:5:"price";s:7:"2000.00";}}s:9:"sale_mode";s:4:"sale";s:8:"customer";s:2:"-1";s:8:"payments";a:0:{}}'),
('4a94b4693041c2480822633c2838f635', '217.124.188.6', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31', 1369753634, 'a:1:{s:9:"person_id";s:1:"1";}'),
('5812145b7c9f15b7f7467115bb6f9606', '201.186.220.54', 'Mozilla/5.0 (Windows NT 6.1; rv:20.0) Gecko/201001', 1367541066, 'a:5:{s:9:"person_id";s:1:"1";s:4:"cart";a:0:{}s:9:"sale_mode";s:4:"sale";s:8:"customer";s:2:"-1";s:8:"payments";a:0:{}}'),
('5dfa0902ff7573247ca0c75e8445f287', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; rv:21.0) Gecko/201001', 1370403032, ''),
('70868156d3534545cd786efc74ef53d0', '0.0.0.0', 'Mozilla/5.0 (X11; Linux x86_64; rv:10.0.12) Gecko/', 1375311515, 'a:5:{s:9:"person_id";s:1:"1";s:4:"cart";a:0:{}s:9:"sale_mode";s:4:"sale";s:8:"customer";s:2:"-1";s:8:"payments";a:0:{}}'),
('91a0c1aa0de20880b7865b64eedd5557', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; rv:21.0) Gecko/201001', 1371049396, 'a:5:{s:9:"person_id";s:1:"1";s:4:"cart";a:0:{}s:9:"sale_mode";s:4:"sale";s:8:"customer";s:2:"-1";s:8:"payments";a:0:{}}'),
('96f8e4580c1b94d249eaa167621eeeaa', '64.76.78.179', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:20.0) G', 1367511897, 'a:1:{s:9:"person_id";s:1:"1";}'),
('9cb987988befdc7a4f7efca4b02ceb60', '69.171.247.112', 'facebookexternalhit/1.1 (+http://www.facebook.com/', 1367205021, ''),
('9f3c15b16319ab36f47aced8f816e2a7', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; rv:21.0) Gecko/201001', 1370403032, ''),
('a305065b526c2d927fc5ed13fe3a740e', '190.217.204.70', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_5) App', 1370217124, 'a:5:{s:9:"person_id";s:1:"1";s:4:"cart";a:1:{i:1;a:11:{s:7:"item_id";s:1:"2";s:4:"line";i:1;s:4:"name";s:7:"piscola";s:11:"item_number";N;s:11:"description";s:0:"";s:12:"serialnumber";s:0:"";s:21:"allow_alt_description";s:1:"0";s:13:"is_serialized";s:1:"0";s:8:"quantity";i:1;s:8:"discount";i:0;s:5:"price";s:7:"2000.00";}}s:9:"sale_mode";s:4:"sale";s:8:"customer";s:2:"-1";s:8:"payments";a:0:{}}'),
('ab6c67288911b06cba557798893606a3', '69.171.247.112', 'facebookexternalhit/1.1 (+http://www.facebook.com/', 1367205021, ''),
('b994072834bbcb43eb6b6dbe9b3a2fbf', '217.124.188.6', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31', 1369666151, 'a:1:{s:9:"person_id";s:1:"1";}'),
('bb49ff93ef61b202c07b1e84f3e5473a', '69.171.247.118', 'facebookexternalhit/1.1 (+http://www.facebook.com/', 1367205661, ''),
('c1d52fc724595330e87d46f91e900632', '0.0.0.0', 'Mozilla/5.0 (X11; Linux x86_64; rv:10.0.12) Gecko/', 1376350695, 'a:5:{s:9:"person_id";s:1:"1";s:4:"cart";a:0:{}s:9:"sale_mode";s:4:"sale";s:8:"customer";s:2:"-1";s:8:"payments";a:0:{}}'),
('ca21fbf63ea2aa849a4e80d8fe017eff', '0.0.0.0', 'Mozilla/5.0 (X11; Linux x86_64; rv:10.0.12) Gecko/', 1376085194, 'a:5:{s:9:"person_id";s:1:"1";s:4:"cart";a:0:{}s:9:"sale_mode";s:4:"sale";s:8:"customer";s:2:"-1";s:8:"payments";a:0:{}}'),
('cd94ea39f80ab9a58d561ecd17f8bb69', '190.217.192.47', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/53', 1367206022, 'a:1:{s:9:"person_id";s:1:"2";}'),
('d42dfbfbb3cd155508103736899475bb', '190.217.203.241', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/53', 1367475873, 'a:5:{s:9:"person_id";s:1:"1";s:4:"cart";a:0:{}s:9:"sale_mode";s:4:"sale";s:8:"customer";s:2:"-1";s:8:"payments";a:0:{}}'),
('dab06db43c2425bfedf6711309be0567', '190.217.230.46', 'Mozilla/5.0 (Windows NT 6.1; rv:21.0) Gecko/201001', 1369668663, 'a:5:{s:9:"person_id";s:1:"1";s:4:"cart";a:0:{}s:9:"sale_mode";s:4:"sale";s:8:"customer";s:2:"-1";s:8:"payments";a:0:{}}'),
('f02f61a2ae33debfed08a7bb106e15c5', '127.0.0.1', 'Mozilla/5.0 (Windows NT 6.1; rv:21.0) Gecko/201001', 1370403032, 'a:5:{s:9:"person_id";s:1:"1";s:4:"cart";a:2:{i:1;a:11:{s:7:"item_id";s:1:"5";s:4:"line";i:1;s:4:"name";s:14:"Cuaderno Colon";s:11:"item_number";s:13:"7806505570597";s:11:"description";s:0:"";s:12:"serialnumber";s:0:"";s:21:"allow_alt_description";s:1:"0";s:13:"is_serialized";s:1:"0";s:8:"quantity";i:5;s:8:"discount";i:0;s:5:"price";s:7:"1200.00";}i:2;a:11:{s:7:"item_id";s:1:"4";s:4:"line";i:2;s:4:"name";s:14:"Cuaderno Plomo";s:11:"item_number";s:13:"7807265039966";s:11:"description";s:0:"";s:12:"serialnumber";s:0:"";s:21:"allow_alt_description";s:1:"0";s:13:"is_serialized";s:1:"0";s:8:"quantity";i:9;s:8:"discount";i:0;s:5:"price";s:7:"1000.00";}}s:9:"sale_mode";s:4:"sale";s:8:"customer";s:2:"-1";s:8:"payments";a:0:{}}'),
('fbbbc71c68a4dd2752f62172b078b010', '190.217.230.46', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.31', 1370397906, 'a:5:{s:9:"person_id";s:1:"1";s:4:"cart";a:0:{}s:9:"sale_mode";s:4:"sale";s:8:"customer";s:2:"-1";s:8:"payments";a:0:{}}');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `suppliers`
--

CREATE TABLE IF NOT EXISTS `suppliers` (
  `person_id` int(10) NOT NULL,
  `rut` int(8) NOT NULL,
  `dv` tinyint(1) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `account_number` varchar(255) DEFAULT NULL,
  UNIQUE KEY `account_number` (`account_number`),
  KEY `rut` (`rut`),
  KEY `person_id` (`person_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `suppliers`
--

INSERT INTO `suppliers` (`person_id`, `rut`, `dv`, `company_name`, `account_number`) VALUES
(32, 99554560, 0, 'COMERCIAL CCU SA', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `type_doc`
--

CREATE TABLE IF NOT EXISTS `type_doc` (
  `id_type_doc` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`id_type_doc`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `type_doc`
--

INSERT INTO `type_doc` (`id_type_doc`, `nombre`) VALUES
(1, 'FACTURA'),
(2, 'GUIA DESPACHO'),
(3, 'BOLETA'),
(4, 'OTRO');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `people` (`person_id`);

--
-- Filtros para la tabla `document`
--
ALTER TABLE `document`
  ADD CONSTRAINT `document_ibfk_2` FOREIGN KEY (`person_id`) REFERENCES `people` (`person_id`);

--
-- Filtros para la tabla `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `people` (`person_id`);

--
-- Filtros para la tabla `items_taxes`
--
ALTER TABLE `items_taxes`
  ADD CONSTRAINT `items_taxes_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `items` (`item_id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `item_document`
--
ALTER TABLE `item_document`
  ADD CONSTRAINT `item_document_ibfk_1` FOREIGN KEY (`fk_item_id`) REFERENCES `items` (`item_id`),
  ADD CONSTRAINT `item_document_ibfk_2` FOREIGN KEY (`fk_id_document`) REFERENCES `document` (`id_document`);

--
-- Filtros para la tabla `permissions`
--
ALTER TABLE `permissions`
  ADD CONSTRAINT `permissions_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `employees` (`person_id`),
  ADD CONSTRAINT `permissions_ibfk_2` FOREIGN KEY (`module_id`) REFERENCES `modules` (`module_id`);

--
-- Filtros para la tabla `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`person_id`),
  ADD CONSTRAINT `sales_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`person_id`);

--
-- Filtros para la tabla `sales_items`
--
ALTER TABLE `sales_items`
  ADD CONSTRAINT `sales_items_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `items` (`item_id`),
  ADD CONSTRAINT `sales_items_ibfk_2` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`sale_id`);

--
-- Filtros para la tabla `sales_items_taxes`
--
ALTER TABLE `sales_items_taxes`
  ADD CONSTRAINT `sales_items_taxes_ibfk_1` FOREIGN KEY (`sale_id`) REFERENCES `sales_items` (`sale_id`),
  ADD CONSTRAINT `sales_items_taxes_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `sales_items` (`item_id`);

--
-- Filtros para la tabla `sales_payments`
--
ALTER TABLE `sales_payments`
  ADD CONSTRAINT `sales_payments_ibfk_1` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`sale_id`);

--
-- Filtros para la tabla `suppliers`
--
ALTER TABLE `suppliers`
  ADD CONSTRAINT `suppliers_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `people` (`person_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
