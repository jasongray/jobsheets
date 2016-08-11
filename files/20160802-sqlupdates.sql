
CREATE TABLE IF NOT EXISTS `plans` (
  `id` int(11) NOT NULL,
  `billing_plan_id` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `userlimit` int(11) NOT NULL,
  `type` varchar(10) NOT NULL,
  `billing` decimal(10,2) NOT NULL,
  `period` int(3) DEFAULT NULL,
  `active` int(1) NOT NULL,
  `d_order` int(10) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

INSERT INTO `plans` (`id`, `billing_plan_id`, `name`, `description`, `userlimit`, `type`, `billing`, `period`, `active`, `d_order`, `created`, `modified`) VALUES
(1, NULL, 'Trial', NULL, 4, 'try', '0.00', 1, 1, 1, '2016-02-27 18:39:12', '2016-02-27 18:39:12'),
(2, NULL, 'SME', '<p><strong>Small Business</strong></p>\r\n<ul>\r\n<li>Up to 4 users</li>\r\n<li>Multi level access</li>\r\n<li>Perfect for small businesses</li>\r\n</ul>', 4, 'sme', '29.00', 1, 1, 2, '2016-02-27 18:39:12', '2016-02-27 18:39:12'),
(3, NULL, 'Enterprise Tier 1', NULL, 10, 'ent', '49.00', 1, 1, 3, '2016-02-27 18:39:12', '2016-02-27 18:39:12'),
(4, NULL, 'Enterprise Tier 2', NULL, 20, 'ent', '89.00', 1, 1, 4, '2016-02-27 18:39:12', '2016-02-27 18:39:12');

ALTER TABLE `clients` ADD `plan_id` INT(11) NULL AFTER `acc_days`;
ALTER TABLE `clients` ADD `subscription_id` VARCHAR(255) NULL AFTER `plan_id`;