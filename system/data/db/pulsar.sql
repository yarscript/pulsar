SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

DROP TABLE IF EXISTS `banner`;
CREATE TABLE IF NOT EXISTS `banner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `banner_image`;
CREATE TABLE IF NOT EXISTS `banner_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `banner_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `title` varchar(64) NOT NULL,
  `link` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `sort_order` int(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image` varchar(255) DEFAULT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `top` tinyint(1) NOT NULL,
  `sort_order` int(3) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `category` (`id`, `image`, `parent_id`, `top`, `sort_order`, `status`, `date_added`, `date_modified`) VALUES
  (1, '\/data\/photo\/photo6.jpg', 0, 1, 0, 1, '2018-02-11 00:06:49', '2018-02-18 08:54:03'),
  (2, '', 0, 1, 0, 1, '2018-02-11 00:07:35', '2018-02-18 05:50:42'),
  (3, '\/data\/photo\/photo17.jpg', 2, 0, 0, 1, '2018-02-11 00:08:12', '2018-02-18 08:54:30'),
  (4, '\/data\/photo\/photo5.jpg', 2, 0, 0, 1, '2018-02-18 08:59:00', '2018-02-18 09:04:33'),
  (5, '\/data\/photo\/photo8.jpg', 0, 1, 0, 1, '2018-02-18 09:03:52', '2018-02-18 09:04:09');

DROP TABLE IF EXISTS `category_description`;
CREATE TABLE IF NOT EXISTS `category_description` (
  `category_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `meta_keyword` varchar(255) NOT NULL,
  PRIMARY KEY (`category_id`,`language_id`),
  KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `category_description` (`category_id`, `language_id`, `name`, `description`, `meta_title`, `meta_description`, `meta_keyword`) VALUES
  (1, 2, 'Demo Cat 1', '<p>Demo Cat 1<br></p>', 'Demo Cat 1', 'Demo Cat 1', ''),
  (1, 1, 'Demo Cat 1', '<p>Demo Cat 1<br></p>', 'Demo Cat 1', 'Demo Cat 1', ''),
  (2, 2, 'Demo Cat 2', '<p>Demo Cat 2<br></p>', 'Demo Cat 2', '', ''),
  (2, 1, 'Demo Cat 2', '<p>Demo Cat 2<br></p>', 'Demo Cat 2', 'Demo Cat 2', ''),
  (3, 1, 'Demo Cat 3', '<p>Demo Cat 3<br></p>', 'Demo Cat 3', 'Demo Cat 3', ''),
  (3, 2, 'Demo Cat 3', '<p>Demo Cat 3<br></p>', 'Demo Cat 3', 'Demo Cat 3', ''),
  (4, 2, 'Demo Cat 4', '<p>Demo Cat 4<br></p>', 'Demo Cat 4', 'Demo Cat 4', ''),
  (4, 1, 'Demo Cat 4', '<p>Demo Cat 4<br></p>', 'Demo Cat 4', 'Demo Cat 4', ''),
  (5, 2, 'Demo Cat 5', '<p>Demo Cat 5<br></p>', 'Demo Cat 5', 'Demo Cat 5', ''),
  (5, 1, 'Demo Cat 5', '<p>Demo Cat 5<br></p>', 'Demo Cat 5', 'Demo Cat 5', '');

DROP TABLE IF EXISTS `category_path`;
CREATE TABLE IF NOT EXISTS `category_path` (
  `category_id` int(11) NOT NULL,
  `path_id` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  PRIMARY KEY (`category_id`,`path_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `category_path` (`category_id`, `path_id`, `level`) VALUES
  (1, 1, 0),
  (2, 2, 0),
  (3, 3, 1),
  (3, 2, 0),
  (4, 4, 1),
  (5, 5, 0),
  (4, 2, 0);

DROP TABLE IF EXISTS `cron`;
CREATE TABLE IF NOT EXISTS `cron` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(64) NOT NULL,
  `cycle` varchar(12) NOT NULL,
  `action` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `event`;
CREATE TABLE IF NOT EXISTS `event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(64) NOT NULL,
  `trigger` text NOT NULL,
  `action` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `extension`;
CREATE TABLE IF NOT EXISTS `extension` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(32) NOT NULL,
  `code` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `extension` (`id`, `type`, `code`) VALUES
  (1, 'dashboard', 'online'),
  (2, 'module', 'html'),
  (3, 'theme', 'default');

DROP TABLE IF EXISTS `language`;
CREATE TABLE IF NOT EXISTS `language` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `code` varchar(5) NOT NULL,
  `locale` varchar(255) NOT NULL,
  `image` varchar(64) NOT NULL,
  `directory` varchar(32) NOT NULL,
  `sort_order` int(3) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `language` (`id`, `name`, `code`, `locale`, `image`, `directory`, `sort_order`, `status`) VALUES
  (1, 'English', 'en-gb', 'en-US,en_US.UTF-8,en_US,en-gb,english', 'en-gb.png', 'en-gb', 1, 1),
  (2, 'Ukrainian', 'uk-ua', 'uk-UA,uk_UA,uk_UA.UTF-8,ukrainian', 'uk-ua.png', 'uk-ua', 2, 1);

DROP TABLE IF EXISTS `layout`;
CREATE TABLE IF NOT EXISTS `layout` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `layout` (`id`, `name`) VALUES
  (1, 'Home');

DROP TABLE IF EXISTS `layout_module`;
CREATE TABLE IF NOT EXISTS `layout_module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `layout_id` int(11) NOT NULL,
  `code` varchar(64) NOT NULL,
  `position` varchar(14) NOT NULL,
  `sort_order` int(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `layout_module` (`id`, `layout_id`, `code`, `position`, `sort_order`) VALUES
  (2, 1, 'html.1', 'content_top', 0),
  (3, 1, 'html.2', 'content_top', 1),
  (4, 1, 'html.3', 'content_top', 2);

DROP TABLE IF EXISTS `layout_route`;
CREATE TABLE IF NOT EXISTS `layout_route` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `layout_id` int(11) NOT NULL,
  `route` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `layout_route` (`id`, `layout_id`, `route`) VALUES
  (2, 1, '/');

DROP TABLE IF EXISTS `module`;
CREATE TABLE IF NOT EXISTS `module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `code` varchar(32) NOT NULL,
  `setting` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `module` (`id`, `name`, `code`, `setting`) VALUES
  (1, 'Hero Content', 'html', '{\"name\":\"Hero Content\",\"description\":{\"1\":{\"title\":\"\",\"description\":\"                <!-- Hero Content -->\\r\\n                <!-- jQuery Vide for video backgrounds, for more examples you can check out https:\\/\\/github.com\\/VodkaBears\\/Vide -->\\r\\n                <div class=\\\"bg-video\\\" data-vide-bg=\\\"img\\/data\\/video\\/hero_sunrise\\\" data-vide-options=\\\"posterType: jpg\\\">\\r\\n                    <div class=\\\"bg-black-op\\\">\\r\\n                        <!-- Header -->\\r\\n                        <section class=\\\"content content-full content-boxed\\\">\\r\\n                            <div class=\\\"push-200-t push-200 text-center\\\">\\r\\n                                <h1 class=\\\"font-s48 font-w700 text-uppercase text-white push-10 visibility-hidden\\\" data-toggle=\\\"appear\\\" data-class=\\\"animated fadeInDown\\\">Europe Travel Guide<\\/h1>\\r\\n                                <h2 class=\\\"h3 font-w400 text-white-op push-50 visibility-hidden\\\" data-toggle=\\\"appear\\\" data-class=\\\"animated fadeInDown\\\" data-timeout=\\\"500\\\">The best tips to experience the incredible.<\\/h2>\\r\\n                            <\\/div>\\r\\n                        <\\/section>\\r\\n                        <!-- END Header -->\\r\\n                    <\\/div>\\r\\n                <\\/div>\\r\\n                <!-- END Hero Content -->\"},\"2\":{\"title\":\"\",\"description\":\"                <!-- Hero Content -->\\r\\n                <!-- jQuery Vide for video backgrounds, for more examples you can check out https:\\/\\/github.com\\/VodkaBears\\/Vide -->\\r\\n                <div class=\\\"bg-video\\\" data-vide-bg=\\\"img\\/data\\/video\\/hero_sunrise\\\" data-vide-options=\\\"posterType: jpg\\\">\\r\\n                    <div class=\\\"bg-black-op\\\">\\r\\n                        <!-- Header -->\\r\\n                        <section class=\\\"content content-full content-boxed\\\">\\r\\n                            <div class=\\\"push-200-t push-200 text-center\\\">\\r\\n                                <h1 class=\\\"font-s48 font-w700 text-uppercase text-white push-10 visibility-hidden\\\" data-toggle=\\\"appear\\\" data-class=\\\"animated fadeInDown\\\">Europe Travel Guide<\\/h1>\\r\\n                                <h2 class=\\\"h3 font-w400 text-white-op push-50 visibility-hidden\\\" data-toggle=\\\"appear\\\" data-class=\\\"animated fadeInDown\\\" data-timeout=\\\"500\\\">The best tips to experience the incredible.<\\/h2>\\r\\n                            <\\/div>\\r\\n                        <\\/section>\\r\\n                        <!-- END Header -->\\r\\n                    <\\/div>\\r\\n                <\\/div>\\r\\n                <!-- END Hero Content -->\"}},\"status\":\"1\"}'),
  (2, 'Features Top', 'html', '{\"name\":\"Features Top\",\"description\":{\"1\":{\"title\":\"\",\"description\":\"    <!-- Classic Features #1 -->\\r\\n    <div class=\\\"bg-white\\\">\\r\\n        <section class=\\\"content content-boxed\\\">\\r\\n            <!-- Section Content -->\\r\\n            <div class=\\\"row items-push-3x push-50-t nice-copy\\\">\\r\\n                <div class=\\\"col-sm-4\\\">\\r\\n                    <div class=\\\"text-center push-30\\\">\\r\\n                                    <span class=\\\"item item-2x item-circle border\\\">\\r\\n                                        <i class=\\\"fa fa-rocket\\\"><\\/i>\\r\\n                                    <\\/span>\\r\\n                    <\\/div>\\r\\n                    <h3 class=\\\"h5 font-w600 text-uppercase text-center push-10\\\">Bootstrap Powered<\\/h3>\\r\\n                    <p>Bootstrap is a sleek, intuitive, and powerful mobile first front-end framework for faster and easier web development. OneUI was built on top, extending it to a large degree.<\\/p>\\r\\n                <\\/div>\\r\\n                <div class=\\\"col-sm-4\\\">\\r\\n                    <div class=\\\"text-center push\\\">\\r\\n                                    <span class=\\\"item item-2x item-circle border\\\">\\r\\n                                        <i class=\\\"fa fa-mobile\\\"><\\/i>\\r\\n                                    <\\/span>\\r\\n                    <\\/div>\\r\\n                    <h3 class=\\\"h5 font-w600 text-uppercase text-center push-10\\\">Fully Responsive<\\/h3>\\r\\n                    <p>The User Interface will adjust to any screen size. It will look great on mobile devices and desktops at the same time. No need to worry about the UI, just stay focused on the development.<\\/p>\\r\\n                <\\/div>\\r\\n                <div class=\\\"col-sm-4\\\">\\r\\n                    <div class=\\\"text-center push\\\">\\r\\n                                    <span class=\\\"item item-2x item-circle border\\\">\\r\\n                                        <i class=\\\"fa fa-clock-o\\\"><\\/i>\\r\\n                                    <\\/span>\\r\\n                    <\\/div>\\r\\n                    <h3 class=\\\"h5 font-w600 text-uppercase text-center push-10\\\">Save time<\\/h3>\\r\\n                    <p>OneUI will save you hundreds of hours of extra development. Start right away coding your functionality and watch your project come to life months sooner.<\\/p>\\r\\n                <\\/div>\\r\\n            <\\/div>\\r\\n            <div class=\\\"row items-push-3x nice-copy\\\">\\r\\n                <div class=\\\"col-sm-4\\\">\\r\\n                    <div class=\\\"text-center push\\\">\\r\\n                                    <span class=\\\"item item-2x item-circle border\\\">\\r\\n                                        <i class=\\\"fa fa-check\\\"><\\/i>\\r\\n                                    <\\/span>\\r\\n                    <\\/div>\\r\\n                    <h3 class=\\\"h5 font-w600 text-uppercase text-center push-10\\\">Frontend Pages<\\/h3>\\r\\n                    <p>Premium and fully responsive frontend pages are included in OneUI package, too. They use the same resources with the backend, so you can build your web application in one go, using all available components wherever you like.<\\/p>\\r\\n                <\\/div>\\r\\n                <div class=\\\"col-sm-4\\\">\\r\\n                    <div class=\\\"text-center push-30\\\">\\r\\n                        <span class=\\\"item item-2x item-circle border\\\">{less}<\\/span>\\r\\n                    <\\/div>\\r\\n                    <h3 class=\\\"h5 font-w600 text-center push-10\\\">LessCSS<\\/h3>\\r\\n                    <p>OneUI was built from scratch with LessCSS. Completely modular design with components, variables and mixins that will help you customize and extend your framework to the maximum.<\\/p>\\r\\n                <\\/div>\\r\\n                <div class=\\\"col-sm-4\\\">\\r\\n                    <div class=\\\"text-center push\\\">\\r\\n                                    <span class=\\\"item item-2x item-circle border\\\">\\r\\n                                        <i class=\\\"fa fa-github\\\"><\\/i>\\r\\n                                    <\\/span>\\r\\n                    <\\/div>\\r\\n                    <h3 class=\\\"h5 font-w600 text-uppercase text-center push-10\\\">Grunt Tasks<\\/h3>\\r\\n                    <p>Grunt tasks will make your life easier. You can use them to live-compile your Less files to CSS as you work or build your custom color themes and framework.<\\/p>\\r\\n                <\\/div>\\r\\n            <\\/div>\\r\\n            <!-- END Section Content -->\\r\\n        <\\/section>\\r\\n    <\\/div>\\r\\n    <!-- END Classic Features #1 -->\"},\"2\":{\"title\":\"\",\"description\":\"<p><br><\\/p>    <!-- Classic Features #1 -->\\r\\n    <div class=\\\"bg-white\\\">\\r\\n        <section class=\\\"content content-boxed\\\">\\r\\n            <!-- Section Content -->\\r\\n            <div class=\\\"row items-push-3x push-50-t nice-copy\\\">\\r\\n                <div class=\\\"col-sm-4\\\">\\r\\n                    <div class=\\\"text-center push-30\\\">\\r\\n                                    <span class=\\\"item item-2x item-circle border\\\">\\r\\n                                        <i class=\\\"fa fa-rocket\\\"><\\/i>\\r\\n                                    <\\/span>\\r\\n                    <\\/div>\\r\\n                    <h3 class=\\\"h5 font-w600 text-uppercase text-center push-10\\\">Bootstrap Powered<\\/h3>\\r\\n                    <p>Bootstrap is a sleek, intuitive, and powerful mobile first front-end framework for faster and easier web development. OneUI was built on top, extending it to a large degree.<\\/p>\\r\\n                <\\/div>\\r\\n                <div class=\\\"col-sm-4\\\">\\r\\n                    <div class=\\\"text-center push\\\">\\r\\n                                    <span class=\\\"item item-2x item-circle border\\\">\\r\\n                                        <i class=\\\"fa fa-mobile\\\"><\\/i>\\r\\n                                    <\\/span>\\r\\n                    <\\/div>\\r\\n                    <h3 class=\\\"h5 font-w600 text-uppercase text-center push-10\\\">Fully Responsive<\\/h3>\\r\\n                    <p>The User Interface will adjust to any screen size. It will look great on mobile devices and desktops at the same time. No need to worry about the UI, just stay focused on the development.<\\/p>\\r\\n                <\\/div>\\r\\n                <div class=\\\"col-sm-4\\\">\\r\\n                    <div class=\\\"text-center push\\\">\\r\\n                                    <span class=\\\"item item-2x item-circle border\\\">\\r\\n                                        <i class=\\\"fa fa-clock-o\\\"><\\/i>\\r\\n                                    <\\/span>\\r\\n                    <\\/div>\\r\\n                    <h3 class=\\\"h5 font-w600 text-uppercase text-center push-10\\\">Save time<\\/h3>\\r\\n                    <p>OneUI will save you hundreds of hours of extra development. Start right away coding your functionality and watch your project come to life months sooner.<\\/p>\\r\\n                <\\/div>\\r\\n            <\\/div>\\r\\n            <div class=\\\"row items-push-3x nice-copy\\\">\\r\\n                <div class=\\\"col-sm-4\\\">\\r\\n                    <div class=\\\"text-center push\\\">\\r\\n                                    <span class=\\\"item item-2x item-circle border\\\">\\r\\n                                        <i class=\\\"fa fa-check\\\"><\\/i>\\r\\n                                    <\\/span>\\r\\n                    <\\/div>\\r\\n                    <h3 class=\\\"h5 font-w600 text-uppercase text-center push-10\\\">Frontend Pages<\\/h3>\\r\\n                    <p>Premium and fully responsive frontend pages are included in OneUI package, too. They use the same resources with the backend, so you can build your web application in one go, using all available components wherever you like.<\\/p>\\r\\n                <\\/div>\\r\\n                <div class=\\\"col-sm-4\\\">\\r\\n                    <div class=\\\"text-center push-30\\\">\\r\\n                        <span class=\\\"item item-2x item-circle border\\\">{less}<\\/span>\\r\\n                    <\\/div>\\r\\n                    <h3 class=\\\"h5 font-w600 text-center push-10\\\">LessCSS<\\/h3>\\r\\n                    <p>OneUI was built from scratch with LessCSS. Completely modular design with components, variables and mixins that will help you customize and extend your framework to the maximum.<\\/p>\\r\\n                <\\/div>\\r\\n                <div class=\\\"col-sm-4\\\">\\r\\n                    <div class=\\\"text-center push\\\">\\r\\n                                    <span class=\\\"item item-2x item-circle border\\\">\\r\\n                                        <i class=\\\"fa fa-github\\\"><\\/i>\\r\\n                                    <\\/span>\\r\\n                    <\\/div>\\r\\n                    <h3 class=\\\"h5 font-w600 text-uppercase text-center push-10\\\">Grunt Tasks<\\/h3>\\r\\n                    <p>Grunt tasks will make your life easier. You can use them to live-compile your Less files to CSS as you work or build your custom color themes and framework.<\\/p>\\r\\n                <\\/div>\\r\\n            <\\/div>\\r\\n            <!-- END Section Content -->\\r\\n        <\\/section>\\r\\n    <\\/div>\\r\\n    <!-- END Classic Features #1 -->\"}},\"status\":\"1\"}'),
  (3, 'Features Bottom', 'html', '{\"name\":\"Features Bottom\",\"description\":{\"1\":{\"title\":\"\",\"description\":\"    <!-- Features Bottom -->\\r\\n    <div class=\\\"bg-image\\\" style=\\\"background-image: url(\'img\\/data\\/photo.jpg\');\\\">\\r\\n        <div class=\\\"bg-primary-dark-op\\\">\\r\\n            <section class=\\\"content content-full content-boxed\\\">\\r\\n                <!-- Section Content -->\\r\\n                <div class=\\\"row items-push-2x push-50-t text-center\\\">\\r\\n                    <div class=\\\"col-sm-4 visibility-hidden text-white-op\\\" data-toggle=\\\"appear\\\" data-offset=\\\"-150\\\">\\r\\n                        <div class=\\\"text-center push-30\\\">\\r\\n                                    <span class=\\\"item item-2x item-circle border\\\">\\r\\n                                        <i class=\\\"fa fa-wrench\\\"><\\/i>\\r\\n                                    <\\/span>\\r\\n                        <\\/div>\\r\\n                        <h3 class=\\\"h5 font-w600 text-warning  text-uppercase text-center push-10\\\">Components<\\/h3>\\r\\n                        <p>OneUI comes packed with so many unique components. Carefully picked and integrated to enhance and enrich your project with great functionality. Use them anywhere you want.<\\/p>\\r\\n\\r\\n                    <\\/div>\\r\\n                    <div class=\\\"col-sm-4 visibility-hidden  text-white-op\\\" data-toggle=\\\"appear\\\" data-offset=\\\"-150\\\" data-timeout=\\\"150\\\">\\r\\n                        <div class=\\\"text-center push\\\">\\r\\n                                    <span class=\\\"item item-2x item-circle border\\\">\\r\\n                                        <i class=\\\"fa fa-support\\\"><\\/i>\\r\\n                                    <\\/span>\\r\\n                        <\\/div>\\r\\n                        <h3 class=\\\"h5 font-w600  text-warning text-uppercase text-center push-10\\\">Support<\\/h3>\\r\\n                        <p>By purchasing a license of OneUI, you are eligible to email support. Should you get stuck somewhere or come accross any issue, don\\u2019t worry because I am here to provide assistance.<\\/p>\\r\\n                    <\\/div>\\r\\n                    <div class=\\\"col-sm-4 visibility-hidden  text-white-op\\\" data-toggle=\\\"appear\\\" data-offset=\\\"-150\\\" data-timeout=\\\"300\\\">\\r\\n                        <div class=\\\"text-center push\\\">\\r\\n                                    <span class=\\\"item item-2x item-circle border\\\">\\r\\n                                        <i class=\\\"fa fa-sitemap\\\"><\\/i>\\r\\n                                    <\\/span>\\r\\n                        <\\/div>\\r\\n                        <h3 class=\\\"h5 font-w600  text-warning text-uppercase text-center push-10\\\">Grunt Tasks<\\/h3>\\r\\n                        <p>Grunt tasks will make your life easier. You can use them to live-compile your Less files to CSS as you work or build your custom color themes and framework.<\\/p>\\r\\n                    <\\/div>\\r\\n                <\\/div>\\r\\n                <!-- END Section Content -->\\r\\n            <\\/section>\\r\\n        <\\/div>\\r\\n    <\\/div>\\r\\n    <!-- END Features Bottom -->\"},\"2\":{\"title\":\"\",\"description\":\"<p><br><\\/p>    <!-- Features Bottom -->\\r\\n    <div class=\\\"bg-image\\\" style=\\\"background-image: url(\'img\\/data\\/photo.jpg\');\\\">\\r\\n        <div class=\\\"bg-primary-dark-op\\\">\\r\\n            <section class=\\\"content content-full content-boxed\\\">\\r\\n                <!-- Section Content -->\\r\\n                <div class=\\\"row items-push-2x push-50-t text-center\\\">\\r\\n                    <div class=\\\"col-sm-4 visibility-hidden text-white-op\\\" data-toggle=\\\"appear\\\" data-offset=\\\"-150\\\">\\r\\n                        <div class=\\\"text-center push-30\\\">\\r\\n                                    <span class=\\\"item item-2x item-circle border\\\">\\r\\n                                        <i class=\\\"fa fa-wrench\\\"><\\/i>\\r\\n                                    <\\/span>\\r\\n                        <\\/div>\\r\\n                        <h3 class=\\\"h5 font-w600 text-warning  text-uppercase text-center push-10\\\">Components<\\/h3>\\r\\n                        <p>OneUI comes packed with so many unique components. Carefully picked and integrated to enhance and enrich your project with great functionality. Use them anywhere you want.<\\/p>\\r\\n\\r\\n                    <\\/div>\\r\\n                    <div class=\\\"col-sm-4 visibility-hidden  text-white-op\\\" data-toggle=\\\"appear\\\" data-offset=\\\"-150\\\" data-timeout=\\\"150\\\">\\r\\n                        <div class=\\\"text-center push\\\">\\r\\n                                    <span class=\\\"item item-2x item-circle border\\\">\\r\\n                                        <i class=\\\"fa fa-support\\\"><\\/i>\\r\\n                                    <\\/span>\\r\\n                        <\\/div>\\r\\n                        <h3 class=\\\"h5 font-w600  text-warning text-uppercase text-center push-10\\\">Support<\\/h3>\\r\\n                        <p>By purchasing a license of OneUI, you are eligible to email support. Should you get stuck somewhere or come accross any issue, don\\u2019t worry because I am here to provide assistance.<\\/p>\\r\\n                    <\\/div>\\r\\n                    <div class=\\\"col-sm-4 visibility-hidden  text-white-op\\\" data-toggle=\\\"appear\\\" data-offset=\\\"-150\\\" data-timeout=\\\"300\\\">\\r\\n                        <div class=\\\"text-center push\\\">\\r\\n                                    <span class=\\\"item item-2x item-circle border\\\">\\r\\n                                        <i class=\\\"fa fa-sitemap\\\"><\\/i>\\r\\n                                    <\\/span>\\r\\n                        <\\/div>\\r\\n                        <h3 class=\\\"h5 font-w600  text-warning text-uppercase text-center push-10\\\">Grunt Tasks<\\/h3>\\r\\n                        <p>Grunt tasks will make your life easier. You can use them to live-compile your Less files to CSS as you work or build your custom color themes and framework.<\\/p>\\r\\n                    <\\/div>\\r\\n                <\\/div>\\r\\n                <!-- END Section Content -->\\r\\n            <\\/section>\\r\\n        <\\/div>\\r\\n    <\\/div>\\r\\n    <!-- END Features Bottom -->\"}},\"status\":\"1\"}');

DROP TABLE IF EXISTS `page`;
CREATE TABLE IF NOT EXISTS `page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `top` tinyint(1) NOT NULL,
  `bottom` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `viewed` int(5) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `page` (`id`, `top`, `bottom`, `status`, `viewed`, `date_added`, `date_modified`) VALUES
  (1, 0, 1, 1, 3, '2018-02-10 23:58:23', '2018-02-10 23:58:23'),
  (2, 0, 1, 1, 4, '2018-02-11 00:00:49', '2018-02-11 00:00:49'),
  (3, 0, 1, 1, 0, '2018-02-11 00:01:55', '2018-02-11 00:02:09');

DROP TABLE IF EXISTS `page_description`;
CREATE TABLE IF NOT EXISTS `page_description` (
  `page_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` mediumtext NOT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `meta_keyword` varchar(255) NOT NULL,
  PRIMARY KEY (`page_id`,`language_id`),
  KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `page_description` (`page_id`, `language_id`, `name`, `description`, `meta_title`, `meta_description`, `meta_keyword`) VALUES
  (1, 1, 'About Us', '<p>About Us<br></p>', 'About Us', 'About Us', ''),
  (1, 2, 'About Us', '<p>About Us<br></p>', 'About Us', 'About Us', ''),
  (2, 1, 'Privacy Policy', '<p>Privacy Policy<br></p>', 'Privacy Policy', 'Privacy Policy', ''),
  (2, 2, 'Privacy Policy', '<p>Privacy Policy<br></p>', 'Privacy Policy', 'Privacy Policy', ''),
  (3, 2, 'Terms & Conditions', '<p>Terms & Conditions<br></p>', 'Terms & Conditions', 'Terms & Conditions', ''),
  (3, 1, 'Terms & Conditions', '<p>Terms & Conditions<br></p>', 'Terms & Conditions', 'Terms & Conditions', '');

DROP TABLE IF EXISTS `post`;
CREATE TABLE IF NOT EXISTS `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `date_available` date NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `viewed` int(5) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `post` (`id`, `user_id`, `image`, `date_available`, `sort_order`, `status`, `viewed`, `date_added`, `date_modified`) VALUES
  (1, 1, '\/data\/photo\/photo.jpg', '2018-02-11', 0, 1, 21, '2018-02-11 00:09:25', '2018-02-18 08:17:17'),
  (2, 1, '\/data\/photo\/photo1.jpg', '2018-02-11', 0, 1, 5, '2018-02-11 00:10:04', '2018-02-18 08:43:06'),
  (3, 1, '\/data\/photo\/photo10.jpg', '2018-02-11', 0, 1, 3, '2018-02-11 00:10:36', '2018-02-18 08:43:17'),
  (4, 1, '\/data\/photo\/photo11.jpg', '2018-02-18', 0, 1, 1, '2018-02-18 08:41:05', '2018-02-18 08:43:47'),
  (5, 1, '\/data\/photo\/photo12.jpg', '2018-02-18', 0, 1, 0, '2018-02-18 08:44:58', '2018-02-18 08:44:58'),
  (6, 1, '\/data\/photo\/photo13.jpg', '2018-02-18', 0, 1, 0, '2018-02-18 08:46:42', '2018-02-18 08:46:42'),
  (7, 1, '\/data\/photo\/photo14.jpg', '2018-02-18', 0, 1, 1, '2018-02-18 08:49:02', '2018-02-18 08:49:02'),
  (8, 1, '\/data\/photo\/photo15.jpg', '2018-02-18', 0, 1, 0, '2018-02-18 08:50:07', '2018-02-18 08:52:14'),
  (9, 1, '\/data\/photo\/photo16.jpg', '2018-02-18', 0, 1, 0, '2018-02-18 08:51:13', '2018-02-18 08:51:13'),
  (10, 1, '\/data\/photo\/photo17.jpg', '2018-02-18', 0, 1, 0, '2018-02-18 09:00:07', '2018-02-18 09:00:07'),
  (11, 1, '\/data\/photo\/photo18.jpg', '2018-02-18', 0, 1, 0, '2018-02-18 09:00:42', '2018-02-18 09:00:42'),
  (12, 1, '\/data\/photo\/photo19.jpg', '2018-02-18', 0, 1, 0, '2018-02-18 09:02:07', '2018-02-18 09:02:07'),
  (13, 1, '\/data\/photo\/photo2.jpg', '2018-02-18', 0, 1, 0, '2018-02-18 09:05:52', '2018-02-18 09:05:52'),
  (14, 1, '\/data\/photo\/photo20.jpg', '2018-02-18', 0, 1, 0, '2018-02-18 09:06:25', '2018-02-18 09:06:25'),
  (15, 1, '\/data\/photo\/photo21.jpg', '2018-02-18', 0, 1, 0, '2018-02-18 09:07:33', '2018-02-18 09:07:33'),
  (16, 1, '\/data\/photo\/photo22.jpg', '2018-02-18', 0, 1, 0, '2018-02-18 09:09:09', '2018-02-18 09:09:09'),
  (17, 1, '\/data\/photo\/photo23.jpg', '2018-02-18', 0, 1, 0, '2018-02-18 09:09:49', '2018-02-18 09:09:49'),
  (18, 1, '\/data\/photo\/photo24.jpg', '2018-02-18', 0, 1, 0, '2018-02-18 09:10:34', '2018-02-18 09:10:34');

DROP TABLE IF EXISTS `post_description`;
CREATE TABLE IF NOT EXISTS `post_description` (
  `post_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` mediumtext NOT NULL,
  `tag` text NOT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `meta_keyword` varchar(255) NOT NULL,
  PRIMARY KEY (`post_id`,`language_id`),
  KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `post_description` (`post_id`, `language_id`, `name`, `description`, `tag`, `meta_title`, `meta_description`, `meta_keyword`) VALUES
  (1, 1, 'Demo Post 1', '<p>Demo Post 1<br></p>', '', 'Demo Post 1', 'Demo Post 1', ''),
  (1, 2, 'Demo Post 1', '<p>Demo Post 1<br></p>', '', 'Demo Post 1', 'Demo Post 1', ''),
  (2, 1, 'Demo Post 2', '<p>Demo Post 2<br></p>', '', 'Demo Post 2', 'Demo Post 2', ''),
  (2, 2, 'Demo Post 2', '<p>Demo Post 2<br></p>', '', 'Demo Post 2', 'Demo Post 2', ''),
  (3, 2, 'Demo Post 3', '<p>Demo Post 3<br></p>', '', 'Demo Post 2', 'Demo Post 2', ''),
  (3, 1, 'Demo Post 3', '<p>Demo Post 3<br></p>', '', 'Demo Post 2', 'Demo Post 2', ''),
  (4, 1, 'Demo Post 4', '<p>Demo Post 4<br></p>', '', 'Demo Post 4', 'Demo Post 4', ''),
  (4, 2, 'Demo Post 4', '<p>Demo Post 4<br></p>', '', 'Demo Post 4', 'Demo Post 4', ''),
  (5, 1, 'Demo Post 5', '<p>Demo Post 5<br></p>', '', 'Demo Post 5', 'Demo Post 5', ''),
  (5, 2, 'Demo Post 5', '<p>Demo Post 5<br></p>', '', 'Demo Post 5', 'Demo Post 5', ''),
  (6, 1, 'Demo Post 6', '<p>Demo Post 6<br></p>', '', 'Demo Post 6', 'Demo Post 6', ''),
  (6, 2, 'Demo Post 6', '<p>Demo Post 6<br></p>', '', 'Demo Post 6', 'Demo Post 6', ''),
  (7, 1, 'Demo Post 7', '<p>Demo Post 7<br></p>', '', 'Demo Post 7', 'Demo Post 7', ''),
  (7, 2, 'Demo Post 7', '<p>Demo Post 7<br></p>', '', 'Demo Post 7', 'Demo Post 7', ''),
  (8, 2, 'Demo Post 8', '<p>Demo Post 8<br></p>', '', 'Demo Post 8', 'Demo Post 8', ''),
  (8, 1, 'Demo Post 8', '<p>Demo Post 8<br></p>', '', 'Demo Post 8', 'Demo Post 8', ''),
  (9, 1, 'Demo Post 9', '<p>Demo Post 9<br></p>', '', 'Demo Post 9', 'Demo Post 9', ''),
  (9, 2, 'Demo Post 9', '<p>Demo Post 9<br></p>', '', 'Demo Post 9', 'Demo Post 9', ''),
  (10, 1, 'Demo Post 10', '<p>Demo Post 10<br></p>', '', 'Demo Post 10', 'Demo Post 10', ''),
  (10, 2, 'Demo Post 10', '<p>Demo Post 10<br></p>', '', 'Demo Post 10', 'Demo Post 10', ''),
  (11, 1, 'Demo Post 11', '<p>Demo Post 11<br></p>', '', 'Demo Post 11', 'Demo Post 11', ''),
  (11, 2, 'Demo Post 11', '<p>Demo Post 11<br></p>', '', 'Demo Post 11', 'Demo Post 11', ''),
  (12, 1, 'Demo Post 12', '<p>Demo Post 12<br></p>', '', 'Demo Post 12', 'Demo Post 12', ''),
  (12, 2, 'Demo Post 12', '<p>Demo Post 12<br></p>', '', 'Demo Post 12', 'Demo Post 12', ''),
  (13, 1, 'Demo Post 13', '<p>Demo Post 13<br></p>', '', 'Demo Post 13', 'Demo Post 13', ''),
  (13, 2, 'Demo Post 13', '<p>Demo Post 13<br></p>', '', 'Demo Post 13', 'Demo Post 13', ''),
  (14, 1, 'Demo Post 14', '<p>Demo Post 14<br></p>', '', 'Demo Post 14', 'Demo Post 14', ''),
  (14, 2, 'Demo Post 14', '<p>Demo Post 14<br></p>', '', 'Demo Post 14', 'Demo Post 14', ''),
  (15, 1, 'Demo Post 15', '<p>Demo Post 15<br></p>', '', 'Demo Post 15', 'Demo Post 15', ''),
  (15, 2, 'Demo Post 15', '<p>Demo Post 15<br></p>', '', 'Demo Post 15', 'Demo Post 15', ''),
  (16, 1, 'Demo Post 16', '<p>Demo Post 16<br></p>', '', 'Demo Post 16', 'Demo Post 16', ''),
  (16, 2, 'Demo Post 16', '<p>Demo Post 16<br></p>', '', 'Demo Post 16', 'Demo Post 16', ''),
  (17, 1, 'Demo Post 17', '<p>Demo Post 17<br></p>', '', 'Demo Post 17', 'Demo Post 17', ''),
  (17, 2, 'Demo Post 17', '<p>Demo Post 17<br></p>', '', 'Demo Post 17', 'Demo Post 17', ''),
  (18, 1, 'Demo Post 18', '<p>Demo Post 18<br></p>', '', 'Demo Post 18', 'Demo Post 18', ''),
  (18, 2, 'Demo Post 18', '<p>Demo Post 18<br></p>', '', 'Demo Post 18', 'Demo Post 18', '');

DROP TABLE IF EXISTS `post_related`;
CREATE TABLE IF NOT EXISTS `post_related` (
  `post_id` int(11) NOT NULL,
  `related_id` int(11) NOT NULL,
  PRIMARY KEY (`post_id`,`related_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `post_to_category`;
CREATE TABLE IF NOT EXISTS `post_to_category` (
  `post_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`post_id`,`category_id`),
  KEY `category_id` (`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `post_to_category` (`post_id`, `category_id`) VALUES
  (1, 1),
  (2, 1),
  (3, 1),
  (4, 1),
  (5, 1),
  (6, 1),
  (7, 3),
  (8, 3),
  (9, 3),
  (10, 4),
  (11, 4),
  (12, 4),
  (13, 5),
  (14, 5),
  (15, 5),
  (16, 5),
  (17, 5),
  (18, 5);

DROP TABLE IF EXISTS `seo_url`;
CREATE TABLE IF NOT EXISTS `seo_url` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `language_id` int(11) NOT NULL,
  `query` varchar(255) NOT NULL,
  `keyword` varchar(255) NOT NULL,
  `push` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `query` (`query`),
  KEY `keyword` (`keyword`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `session`;
CREATE TABLE IF NOT EXISTS `session` (
  `id` varchar(32) NOT NULL,
  `name` varchar(32) NOT NULL,
  `data` text NOT NULL,
  `expire` datetime NOT NULL,
  PRIMARY KEY (`id`,`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `setting`;
CREATE TABLE IF NOT EXISTS `setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(32) NOT NULL,
  `key` varchar(64) NOT NULL,
  `value` text NOT NULL,
  `serialized` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `setting` (`id`, `code`, `key`, `value`, `serialized`) VALUES
  (1, 'config', 'config_mail_smtp_hostname', '', 0),
  (2, 'config', 'config_mail_parameter', '', 0),
  (3, 'config', 'config_mail_secure', '-- None --', 0),
  (4, 'config', 'config_mail_engine', 'mail', 0),
  (5, 'config', 'config_login_attempts', '5', 0),
  (6, 'config', 'config_user_group_display', '[\"1\"]', 1),
  (7, 'config', 'config_user_group', '1', 0),
  (8, 'config', 'config_user_search', '1', 0),
  (9, 'config', 'config_user_activity', '1', 0),
  (10, 'config', 'config_user_online', '1', 0),
  (11, 'config', 'config_theme', 'default', 0),
  (12, 'config', 'config_admin_language', 'en-gb', 0),
  (13, 'config', 'config_language', 'en-gb', 0),
  (14, 'config', 'config_limit', '20', 0),
  (15, 'config', 'config_meta_keyword', '', 0),
  (16, 'config', 'config_meta_description', '', 0),
  (17, 'config', 'config_meta_title', 'Pulsar', 0),
  (18, 'config', 'config_email', 'admin@admin.com', 0),
  (19, 'config', 'config_name', 'Pulsar', 0),
  (20, 'config', 'config_mail_smtp_port', '', 0),
  (21, 'config', 'config_mail_smtp_username', '', 0),
  (22, 'config', 'config_mail_smtp_password', '', 0),
  (23, 'config', 'config_mail_smtp_timeout', '', 0),
  (24, 'config', 'config_compression', '0', 0),
  (25, 'config', 'config_error_display', '1', 0),
  (26, 'config', 'config_error_log', '1', 0),
  (27, 'config', 'config_error_filename', 'error.log', 0),
  (35, 'theme_default', 'theme_default_theme', '', 0),
  (34, 'theme_default', 'theme_default_class', 'header-navbar-fixed sidebar-o sidebar-l', 0),
  (31, 'dashboard_online', 'dashboard_online_width', '3', 0),
  (32, 'dashboard_online', 'dashboard_online_sort_order', '1', 0),
  (33, 'dashboard_online', 'dashboard_online_status', '1', 0),
  (36, 'theme_default', 'theme_default_status', '1', 0);

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `firstname` varchar(32) NOT NULL,
  `lastname` varchar(32) NOT NULL,
  `email` varchar(96) NOT NULL,
  `image` varchar(255) NOT NULL,
  `ip` varchar(40) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `user` (`id`, `group_id`, `username`, `password`, `firstname`, `lastname`, `email`, `image`, `ip`, `status`, `date_added`) VALUES
  (1, 1, 'admin', '$2y$10$ioZ8GNFwM06/Drh8uWIqre2UkBvdDR/k8vZYzO1amy2K62gwkeGXu', 'John', 'Parker', 'admin@ionscript.com', '/data/avatar/avatar.png', '::1', 1, '2018-02-04 00:00:00');

DROP TABLE IF EXISTS `user_group`;
CREATE TABLE IF NOT EXISTS `user_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `approval` tinyint(1) NOT NULL,
  `permission` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `user_group` (`id`, `approval`, `permission`) VALUES
  (1, 1, '{\"access\":[\"banner\",\"extension\\/menu\\/menu\",\"extension\\/module\\/slideshow\",\"extension\\/module\\/html\",\"extension\\/module\\/category\",\"extension\\/module\\/banner\",\"extension\\/theme\\/default\",\"extension\\/dashboard\\/online\",\"extension\\/analytics\\/google\",\"extension\\/extension\\/theme\",\"extension\\/extension\\/report\",\"extension\\/extension\\/menu\",\"extension\\/extension\\/dashboard\",\"extension\\/extension\\/analytics\",\"extension\\/extension\\/module\",\"online\",\"language\",\"seo\",\"layout\",\"post\",\"page\",\"category\",\"user-group\",\"user\",\"backup\",\"log\",\"setting\",\"filemanager\",\"admin\\/extension\\/module\\/html\",\"admin\\/extension\\/dashboard\\/online\",\"admin\\/extension\\/module\\/html\",\"admin\\/extension\\/module\\/html\",\"admin\\/extension\\/theme\\/default\"],\"modify\":[\"banner\",\"extension\\/menu\\/menu\",\"extension\\/module\\/slideshow\",\"extension\\/module\\/html\",\"extension\\/module\\/category\",\"extension\\/module\\/banner\",\"extension\\/theme\\/default\",\"extension\\/dashboard\\/online\",\"extension\\/analytics\\/google\",\"extension\\/extension\\/theme\",\"extension\\/extension\\/report\",\"extension\\/extension\\/menu\",\"extension\\/extension\\/dashboard\",\"extension\\/extension\\/analytics\",\"extension\\/extension\\/module\",\"online\",\"language\",\"seo\",\"layout\",\"post\",\"page\",\"category\",\"user-group\",\"user\",\"backup\",\"log\",\"setting\",\"filemanager\",\"admin\\/extension\\/module\\/html\",\"admin\\/extension\\/dashboard\\/online\",\"admin\\/extension\\/module\\/html\",\"admin\\/extension\\/module\\/html\",\"admin\\/extension\\/theme\\/default\"]}'),
  (2, 1, '{\"access\":[],\"modify\":[]}');

DROP TABLE IF EXISTS `user_group_description`;
CREATE TABLE IF NOT EXISTS `user_group_description` (
  `group_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`group_id`,`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `user_group_description` (`group_id`, `language_id`, `name`, `description`) VALUES
  (1, 1, 'Administrator', ''),
  (2, 1, 'Demonstration', '');

DROP TABLE IF EXISTS `user_ip`;
CREATE TABLE IF NOT EXISTS `user_ip` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `ip` varchar(40) NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ip` (`ip`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `user_login`;
CREATE TABLE IF NOT EXISTS `user_login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(96) NOT NULL,
  `ip` varchar(40) NOT NULL,
  `total` int(4) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `email` (`email`),
  KEY `ip` (`ip`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `user_online`;
CREATE TABLE IF NOT EXISTS `user_online` (
  `ip` varchar(40) NOT NULL,
  `user_id` int(11) NOT NULL,
  `url` text NOT NULL,
  `referer` text NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`ip`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
