SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE `banner` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `banner_image` (
  `id` int(11) NOT NULL,
  `banner_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `title` varchar(64) NOT NULL,
  `link` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `sort_order` int(3) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `category` (`id`, `image`, `parent_id`, `status`, `date_added`, `date_modified`) VALUES
(1, '', 0, 1, '2018-02-11 00:06:49', '2018-02-11 00:06:49'),
(2, '', 0, 1, '2018-02-11 00:07:35', '2018-02-11 00:07:35'),
(3, '', 0, 1, '2018-02-11 00:08:12', '2018-02-11 00:08:12');

CREATE TABLE `category_description` (
  `category_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `meta_keyword` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `category_description` (`category_id`, `language_id`, `name`, `description`, `meta_title`, `meta_description`, `meta_keyword`) VALUES
(1, 1, 'Demo Cat 1', '<p>Demo Cat 1<br></p>', 'Demo Cat 1', 'Demo Cat 1', ''),
(1, 2, 'Demo Cat 1', '<p>Demo Cat 1<br></p>', 'Demo Cat 1', 'Demo Cat 1', ''),
(2, 1, 'Demo Cat 2', '<p>Demo Cat 2<br></p>', 'Demo Cat 2', 'Demo Cat 2', ''),
(2, 2, 'Demo Cat 2', '<p>Demo Cat 2<br></p>', 'Demo Cat 2', '', ''),
(3, 1, 'Demo Cat 3', '<p>Demo Cat 3<br></p>', 'Demo Cat 3', 'Demo Cat 3', ''),
(3, 2, 'Demo Cat 3', '<p>Demo Cat 3<br></p>', 'Demo Cat 3', 'Demo Cat 3', '');

CREATE TABLE `category_path` (
  `category_id` int(11) NOT NULL,
  `path_id` int(11) NOT NULL,
  `level` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `category_path` (`category_id`, `path_id`, `level`) VALUES
(1, 1, 0),
(2, 2, 0),
(3, 3, 0);

CREATE TABLE `cron` (
  `id` int(11) NOT NULL,
  `code` varchar(64) NOT NULL,
  `cycle` varchar(12) NOT NULL,
  `action` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `event` (
  `id` int(11) NOT NULL,
  `code` varchar(64) NOT NULL,
  `trigger` text NOT NULL,
  `action` text NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `extension` (
  `id` int(11) NOT NULL,
  `type` varchar(32) NOT NULL,
  `code` varchar(32) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `extension` (`id`, `type`, `code`) VALUES
(1, 'dashboard', 'online'),
(2, 'module', 'html'),
(3, 'theme', 'default');

CREATE TABLE `language` (
  `id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `code` varchar(5) NOT NULL,
  `locale` varchar(255) NOT NULL,
  `image` varchar(64) NOT NULL,
  `directory` varchar(32) NOT NULL,
  `sort_order` int(3) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `language` (`id`, `name`, `code`, `locale`, `image`, `directory`, `sort_order`, `status`) VALUES
(1, 'English', 'en-gb', 'en-US,en_US.UTF-8,en_US,en-gb,english', 'en-gb.png', 'en-gb', 1, 1),
(2, 'Ukrainian', 'uk-ua', 'uk-UA,uk_UA,uk_UA.UTF-8,ukrainian', 'uk-ua.png', 'uk-ua', 2, 1);

CREATE TABLE `layout` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `layout` (`id`, `name`) VALUES
(1, 'Home');

CREATE TABLE `layout_module` (
  `id` int(11) NOT NULL,
  `layout_id` int(11) NOT NULL,
  `code` varchar(64) NOT NULL,
  `position` varchar(14) NOT NULL,
  `sort_order` int(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `layout_module` (`id`, `layout_id`, `code`, `position`, `sort_order`) VALUES
(2, 1, 'html.1', 'content_top', 0),
(3, 1, 'html.2', 'content_top', 1),
(4, 1, 'html.3', 'content_top', 2);

CREATE TABLE `layout_route` (
  `id` int(11) NOT NULL,
  `layout_id` int(11) NOT NULL,
  `route` varchar(64) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `layout_route` (`id`, `layout_id`, `route`) VALUES
(2, 1, '/');

CREATE TABLE `module` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `code` varchar(32) NOT NULL,
  `setting` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `module` (`id`, `name`, `code`, `setting`) VALUES
(1, 'Hero Content', 'html', '{"name":"Hero Content","description":{"1":{"title":"","description":"                <!-- Hero Content -->\\r\\n                <!-- jQuery Vide for video backgrounds, for more examples you can check out https:\\/\\/github.com\\/VodkaBears\\/Vide -->\\r\\n                <div class=\\"bg-video\\" data-vide-bg=\\"img\\/data\\/demo\\/hero_sunrise\\" data-vide-options=\\"posterType: jpg\\">\\r\\n                    <div class=\\"bg-black-op\\">\\r\\n                        <!-- Header -->\\r\\n                        <section class=\\"content content-full content-boxed\\">\\r\\n                            <div class=\\"push-200-t push-200 text-center\\">\\r\\n                                <h1 class=\\"font-s48 font-w700 text-uppercase text-white push-10 visibility-hidden\\" data-toggle=\\"appear\\" data-class=\\"animated fadeInDown\\">Europe Travel Guide<\\/h1>\\r\\n                                <h2 class=\\"h3 font-w400 text-white-op push-50 visibility-hidden\\" data-toggle=\\"appear\\" data-class=\\"animated fadeInDown\\" data-timeout=\\"500\\">The best tips to experience the incredible.<\\/h2>\\r\\n                            <\\/div>\\r\\n                        <\\/section>\\r\\n                        <!-- END Header -->\\r\\n                    <\\/div>\\r\\n                <\\/div>\\r\\n                <!-- END Hero Content -->"},"2":{"title":"","description":"                <!-- Hero Content -->\\r\\n                <!-- jQuery Vide for video backgrounds, for more examples you can check out https:\\/\\/github.com\\/VodkaBears\\/Vide -->\\r\\n                <div class=\\"bg-video\\" data-vide-bg=\\"img\\/data\\/demo\\/hero_sunrise\\" data-vide-options=\\"posterType: jpg\\">\\r\\n                    <div class=\\"bg-black-op\\">\\r\\n                        <!-- Header -->\\r\\n                        <section class=\\"content content-full content-boxed\\">\\r\\n                            <div class=\\"push-200-t push-200 text-center\\">\\r\\n                                <h1 class=\\"font-s48 font-w700 text-uppercase text-white push-10 visibility-hidden\\" data-toggle=\\"appear\\" data-class=\\"animated fadeInDown\\">Europe Travel Guide<\\/h1>\\r\\n                                <h2 class=\\"h3 font-w400 text-white-op push-50 visibility-hidden\\" data-toggle=\\"appear\\" data-class=\\"animated fadeInDown\\" data-timeout=\\"500\\">The best tips to experience the incredible.<\\/h2>\\r\\n                            <\\/div>\\r\\n                        <\\/section>\\r\\n                        <!-- END Header -->\\r\\n                    <\\/div>\\r\\n                <\\/div>\\r\\n                <!-- END Hero Content -->"}},"status":"1"}'),
(2, 'Features Top', 'html', '{"name":"Features Top","description":{"1":{"title":"","description":"    <!-- Classic Features #1 -->\\r\\n    <div class=\\"bg-white\\">\\r\\n        <section class=\\"content content-boxed\\">\\r\\n            <!-- Section Content -->\\r\\n            <div class=\\"row items-push-3x push-50-t nice-copy\\">\\r\\n                <div class=\\"col-sm-4\\">\\r\\n                    <div class=\\"text-center push-30\\">\\r\\n                                    <span class=\\"item item-2x item-circle border\\">\\r\\n                                        <i class=\\"fa fa-rocket\\"><\\/i>\\r\\n                                    <\\/span>\\r\\n                    <\\/div>\\r\\n                    <h3 class=\\"h5 font-w600 text-uppercase text-center push-10\\">Bootstrap Powered<\\/h3>\\r\\n                    <p>Bootstrap is a sleek, intuitive, and powerful mobile first front-end framework for faster and easier web development. OneUI was built on top, extending it to a large degree.<\\/p>\\r\\n                <\\/div>\\r\\n                <div class=\\"col-sm-4\\">\\r\\n                    <div class=\\"text-center push\\">\\r\\n                                    <span class=\\"item item-2x item-circle border\\">\\r\\n                                        <i class=\\"fa fa-mobile\\"><\\/i>\\r\\n                                    <\\/span>\\r\\n                    <\\/div>\\r\\n                    <h3 class=\\"h5 font-w600 text-uppercase text-center push-10\\">Fully Responsive<\\/h3>\\r\\n                    <p>The User Interface will adjust to any screen size. It will look great on mobile devices and desktops at the same time. No need to worry about the UI, just stay focused on the development.<\\/p>\\r\\n                <\\/div>\\r\\n                <div class=\\"col-sm-4\\">\\r\\n                    <div class=\\"text-center push\\">\\r\\n                                    <span class=\\"item item-2x item-circle border\\">\\r\\n                                        <i class=\\"fa fa-clock-o\\"><\\/i>\\r\\n                                    <\\/span>\\r\\n                    <\\/div>\\r\\n                    <h3 class=\\"h5 font-w600 text-uppercase text-center push-10\\">Save time<\\/h3>\\r\\n                    <p>OneUI will save you hundreds of hours of extra development. Start right away coding your functionality and watch your project come to life months sooner.<\\/p>\\r\\n                <\\/div>\\r\\n            <\\/div>\\r\\n            <div class=\\"row items-push-3x nice-copy\\">\\r\\n                <div class=\\"col-sm-4\\">\\r\\n                    <div class=\\"text-center push\\">\\r\\n                                    <span class=\\"item item-2x item-circle border\\">\\r\\n                                        <i class=\\"fa fa-check\\"><\\/i>\\r\\n                                    <\\/span>\\r\\n                    <\\/div>\\r\\n                    <h3 class=\\"h5 font-w600 text-uppercase text-center push-10\\">Frontend Pages<\\/h3>\\r\\n                    <p>Premium and fully responsive frontend pages are included in OneUI package, too. They use the same resources with the backend, so you can build your web application in one go, using all available components wherever you like.<\\/p>\\r\\n                <\\/div>\\r\\n                <div class=\\"col-sm-4\\">\\r\\n                    <div class=\\"text-center push-30\\">\\r\\n                        <span class=\\"item item-2x item-circle border\\">{less}<\\/span>\\r\\n                    <\\/div>\\r\\n                    <h3 class=\\"h5 font-w600 text-center push-10\\">LessCSS<\\/h3>\\r\\n                    <p>OneUI was built from scratch with LessCSS. Completely modular design with components, variables and mixins that will help you customize and extend your framework to the maximum.<\\/p>\\r\\n                <\\/div>\\r\\n                <div class=\\"col-sm-4\\">\\r\\n                    <div class=\\"text-center push\\">\\r\\n                                    <span class=\\"item item-2x item-circle border\\">\\r\\n                                        <i class=\\"fa fa-github\\"><\\/i>\\r\\n                                    <\\/span>\\r\\n                    <\\/div>\\r\\n                    <h3 class=\\"h5 font-w600 text-uppercase text-center push-10\\">Grunt Tasks<\\/h3>\\r\\n                    <p>Grunt tasks will make your life easier. You can use them to live-compile your Less files to CSS as you work or build your custom color themes and framework.<\\/p>\\r\\n                <\\/div>\\r\\n            <\\/div>\\r\\n            <!-- END Section Content -->\\r\\n        <\\/section>\\r\\n    <\\/div>\\r\\n    <!-- END Classic Features #1 -->"},"2":{"title":"","description":"<p><br><\\/p>    <!-- Classic Features #1 -->\\r\\n    <div class=\\"bg-white\\">\\r\\n        <section class=\\"content content-boxed\\">\\r\\n            <!-- Section Content -->\\r\\n            <div class=\\"row items-push-3x push-50-t nice-copy\\">\\r\\n                <div class=\\"col-sm-4\\">\\r\\n                    <div class=\\"text-center push-30\\">\\r\\n                                    <span class=\\"item item-2x item-circle border\\">\\r\\n                                        <i class=\\"fa fa-rocket\\"><\\/i>\\r\\n                                    <\\/span>\\r\\n                    <\\/div>\\r\\n                    <h3 class=\\"h5 font-w600 text-uppercase text-center push-10\\">Bootstrap Powered<\\/h3>\\r\\n                    <p>Bootstrap is a sleek, intuitive, and powerful mobile first front-end framework for faster and easier web development. OneUI was built on top, extending it to a large degree.<\\/p>\\r\\n                <\\/div>\\r\\n                <div class=\\"col-sm-4\\">\\r\\n                    <div class=\\"text-center push\\">\\r\\n                                    <span class=\\"item item-2x item-circle border\\">\\r\\n                                        <i class=\\"fa fa-mobile\\"><\\/i>\\r\\n                                    <\\/span>\\r\\n                    <\\/div>\\r\\n                    <h3 class=\\"h5 font-w600 text-uppercase text-center push-10\\">Fully Responsive<\\/h3>\\r\\n                    <p>The User Interface will adjust to any screen size. It will look great on mobile devices and desktops at the same time. No need to worry about the UI, just stay focused on the development.<\\/p>\\r\\n                <\\/div>\\r\\n                <div class=\\"col-sm-4\\">\\r\\n                    <div class=\\"text-center push\\">\\r\\n                                    <span class=\\"item item-2x item-circle border\\">\\r\\n                                        <i class=\\"fa fa-clock-o\\"><\\/i>\\r\\n                                    <\\/span>\\r\\n                    <\\/div>\\r\\n                    <h3 class=\\"h5 font-w600 text-uppercase text-center push-10\\">Save time<\\/h3>\\r\\n                    <p>OneUI will save you hundreds of hours of extra development. Start right away coding your functionality and watch your project come to life months sooner.<\\/p>\\r\\n                <\\/div>\\r\\n            <\\/div>\\r\\n            <div class=\\"row items-push-3x nice-copy\\">\\r\\n                <div class=\\"col-sm-4\\">\\r\\n                    <div class=\\"text-center push\\">\\r\\n                                    <span class=\\"item item-2x item-circle border\\">\\r\\n                                        <i class=\\"fa fa-check\\"><\\/i>\\r\\n                                    <\\/span>\\r\\n                    <\\/div>\\r\\n                    <h3 class=\\"h5 font-w600 text-uppercase text-center push-10\\">Frontend Pages<\\/h3>\\r\\n                    <p>Premium and fully responsive frontend pages are included in OneUI package, too. They use the same resources with the backend, so you can build your web application in one go, using all available components wherever you like.<\\/p>\\r\\n                <\\/div>\\r\\n                <div class=\\"col-sm-4\\">\\r\\n                    <div class=\\"text-center push-30\\">\\r\\n                        <span class=\\"item item-2x item-circle border\\">{less}<\\/span>\\r\\n                    <\\/div>\\r\\n                    <h3 class=\\"h5 font-w600 text-center push-10\\">LessCSS<\\/h3>\\r\\n                    <p>OneUI was built from scratch with LessCSS. Completely modular design with components, variables and mixins that will help you customize and extend your framework to the maximum.<\\/p>\\r\\n                <\\/div>\\r\\n                <div class=\\"col-sm-4\\">\\r\\n                    <div class=\\"text-center push\\">\\r\\n                                    <span class=\\"item item-2x item-circle border\\">\\r\\n                                        <i class=\\"fa fa-github\\"><\\/i>\\r\\n                                    <\\/span>\\r\\n                    <\\/div>\\r\\n                    <h3 class=\\"h5 font-w600 text-uppercase text-center push-10\\">Grunt Tasks<\\/h3>\\r\\n                    <p>Grunt tasks will make your life easier. You can use them to live-compile your Less files to CSS as you work or build your custom color themes and framework.<\\/p>\\r\\n                <\\/div>\\r\\n            <\\/div>\\r\\n            <!-- END Section Content -->\\r\\n        <\\/section>\\r\\n    <\\/div>\\r\\n    <!-- END Classic Features #1 -->"}},"status":"1"}'),
(3, 'Features Bottom', 'html', '{"name":"Features Bottom","description":{"1":{"title":"","description":"    <!-- Features Bottom -->\\r\\n    <div class=\\"bg-image\\" style=\\"background-image: url(\'img\\/data\\/demo\\/photo.jpg\');\\">\\r\\n        <div class=\\"bg-primary-dark-op\\">\\r\\n            <section class=\\"content content-full content-boxed\\">\\r\\n                <!-- Section Content -->\\r\\n                <div class=\\"row items-push-2x push-50-t text-center\\">\\r\\n                    <div class=\\"col-sm-4 visibility-hidden text-white-op\\" data-toggle=\\"appear\\" data-offset=\\"-150\\">\\r\\n                        <div class=\\"text-center push-30\\">\\r\\n                                    <span class=\\"item item-2x item-circle border\\">\\r\\n                                        <i class=\\"fa fa-wrench\\"><\\/i>\\r\\n                                    <\\/span>\\r\\n                        <\\/div>\\r\\n                        <h3 class=\\"h5 font-w600 text-warning  text-uppercase text-center push-10\\">Components<\\/h3>\\r\\n                        <p>OneUI comes packed with so many unique components. Carefully picked and integrated to enhance and enrich your project with great functionality. Use them anywhere you want.<\\/p>\\r\\n\\r\\n                    <\\/div>\\r\\n                    <div class=\\"col-sm-4 visibility-hidden  text-white-op\\" data-toggle=\\"appear\\" data-offset=\\"-150\\" data-timeout=\\"150\\">\\r\\n                        <div class=\\"text-center push\\">\\r\\n                                    <span class=\\"item item-2x item-circle border\\">\\r\\n                                        <i class=\\"fa fa-support\\"><\\/i>\\r\\n                                    <\\/span>\\r\\n                        <\\/div>\\r\\n                        <h3 class=\\"h5 font-w600  text-warning text-uppercase text-center push-10\\">Support<\\/h3>\\r\\n                        <p>By purchasing a license of OneUI, you are eligible to email support. Should you get stuck somewhere or come accross any issue, don\\u2019t worry because I am here to provide assistance.<\\/p>\\r\\n                    <\\/div>\\r\\n                    <div class=\\"col-sm-4 visibility-hidden  text-white-op\\" data-toggle=\\"appear\\" data-offset=\\"-150\\" data-timeout=\\"300\\">\\r\\n                        <div class=\\"text-center push\\">\\r\\n                                    <span class=\\"item item-2x item-circle border\\">\\r\\n                                        <i class=\\"fa fa-sitemap\\"><\\/i>\\r\\n                                    <\\/span>\\r\\n                        <\\/div>\\r\\n                        <h3 class=\\"h5 font-w600  text-warning text-uppercase text-center push-10\\">Grunt Tasks<\\/h3>\\r\\n                        <p>Grunt tasks will make your life easier. You can use them to live-compile your Less files to CSS as you work or build your custom color themes and framework.<\\/p>\\r\\n                    <\\/div>\\r\\n                <\\/div>\\r\\n                <!-- END Section Content -->\\r\\n            <\\/section>\\r\\n        <\\/div>\\r\\n    <\\/div>\\r\\n    <!-- END Features Bottom -->"},"2":{"title":"","description":"<p><br><\\/p>    <!-- Features Bottom -->\\r\\n    <div class=\\"bg-image\\" style=\\"background-image: url(\'img\\/data\\/demo\\/photo.jpg\');\\">\\r\\n        <div class=\\"bg-primary-dark-op\\">\\r\\n            <section class=\\"content content-full content-boxed\\">\\r\\n                <!-- Section Content -->\\r\\n                <div class=\\"row items-push-2x push-50-t text-center\\">\\r\\n                    <div class=\\"col-sm-4 visibility-hidden text-white-op\\" data-toggle=\\"appear\\" data-offset=\\"-150\\">\\r\\n                        <div class=\\"text-center push-30\\">\\r\\n                                    <span class=\\"item item-2x item-circle border\\">\\r\\n                                        <i class=\\"fa fa-wrench\\"><\\/i>\\r\\n                                    <\\/span>\\r\\n                        <\\/div>\\r\\n                        <h3 class=\\"h5 font-w600 text-warning  text-uppercase text-center push-10\\">Components<\\/h3>\\r\\n                        <p>OneUI comes packed with so many unique components. Carefully picked and integrated to enhance and enrich your project with great functionality. Use them anywhere you want.<\\/p>\\r\\n\\r\\n                    <\\/div>\\r\\n                    <div class=\\"col-sm-4 visibility-hidden  text-white-op\\" data-toggle=\\"appear\\" data-offset=\\"-150\\" data-timeout=\\"150\\">\\r\\n                        <div class=\\"text-center push\\">\\r\\n                                    <span class=\\"item item-2x item-circle border\\">\\r\\n                                        <i class=\\"fa fa-support\\"><\\/i>\\r\\n                                    <\\/span>\\r\\n                        <\\/div>\\r\\n                        <h3 class=\\"h5 font-w600  text-warning text-uppercase text-center push-10\\">Support<\\/h3>\\r\\n                        <p>By purchasing a license of OneUI, you are eligible to email support. Should you get stuck somewhere or come accross any issue, don\\u2019t worry because I am here to provide assistance.<\\/p>\\r\\n                    <\\/div>\\r\\n                    <div class=\\"col-sm-4 visibility-hidden  text-white-op\\" data-toggle=\\"appear\\" data-offset=\\"-150\\" data-timeout=\\"300\\">\\r\\n                        <div class=\\"text-center push\\">\\r\\n                                    <span class=\\"item item-2x item-circle border\\">\\r\\n                                        <i class=\\"fa fa-sitemap\\"><\\/i>\\r\\n                                    <\\/span>\\r\\n                        <\\/div>\\r\\n                        <h3 class=\\"h5 font-w600  text-warning text-uppercase text-center push-10\\">Grunt Tasks<\\/h3>\\r\\n                        <p>Grunt tasks will make your life easier. You can use them to live-compile your Less files to CSS as you work or build your custom color themes and framework.<\\/p>\\r\\n                    <\\/div>\\r\\n                <\\/div>\\r\\n                <!-- END Section Content -->\\r\\n            <\\/section>\\r\\n        <\\/div>\\r\\n    <\\/div>\\r\\n    <!-- END Features Bottom -->"}},"status":"1"}');

CREATE TABLE `page` (
  `id` int(11) NOT NULL,
  `top` tinyint(1) NOT NULL,
  `bottom` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `viewed` int(5) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `page` (`id`, `top`, `bottom`, `status`, `viewed`, `date_added`, `date_modified`) VALUES
(1, 0, 1, 1, 3, '2018-02-10 23:58:23', '2018-02-10 23:58:23'),
(2, 0, 1, 1, 4, '2018-02-11 00:00:49', '2018-02-11 00:00:49'),
(3, 0, 1, 1, 0, '2018-02-11 00:01:55', '2018-02-11 00:02:09');

CREATE TABLE `page_description` (
  `page_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` mediumtext NOT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `meta_keyword` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `page_description` (`page_id`, `language_id`, `name`, `description`, `meta_title`, `meta_description`, `meta_keyword`) VALUES
(1, 1, 'About Us', '<p>About Us<br></p>', 'About Us', 'About Us', ''),
(1, 2, 'About Us', '<p>About Us<br></p>', 'About Us', 'About Us', ''),
(2, 1, 'Privacy Policy', '<p>Privacy Policy<br></p>', 'Privacy Policy', 'Privacy Policy', ''),
(2, 2, 'Privacy Policy', '<p>Privacy Policy<br></p>', 'Privacy Policy', 'Privacy Policy', ''),
(3, 2, 'Terms & Conditions', '<p>Terms & Conditions<br></p>', 'Terms & Conditions', 'Terms & Conditions', ''),
(3, 1, 'Terms & Conditions', '<p>Terms & Conditions<br></p>', 'Terms & Conditions', 'Terms & Conditions', '');

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `date_available` date NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `viewed` int(5) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `post` (`id`, `user_id`, `image`, `date_available`, `sort_order`, `status`, `viewed`, `date_added`, `date_modified`) VALUES
(1, 1, '', '2018-02-11', 0, 1, 0, '2018-02-11 00:09:25', '2018-02-11 00:09:25'),
(2, 1, '', '2018-02-11', 0, 1, 0, '2018-02-11 00:10:04', '2018-02-11 00:10:04'),
(3, 1, '', '2018-02-11', 0, 1, 0, '2018-02-11 00:10:36', '2018-02-11 00:10:36');

CREATE TABLE `post_description` (
  `post_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` mediumtext NOT NULL,
  `tag` text NOT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `meta_keyword` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `post_description` (`post_id`, `language_id`, `name`, `description`, `tag`, `meta_title`, `meta_description`, `meta_keyword`) VALUES
(1, 1, 'Demo Post 1', '<p>Demo Post 1<br></p>', '', 'Demo Post 1', 'Demo Post 1', ''),
(1, 2, 'Demo Post 1', '<p>Demo Post 1<br></p>', '', 'Demo Post 1', 'Demo Post 1', ''),
(2, 1, 'Demo Post 2', '<p>Demo Post 2<br></p>', '', 'Demo Post 2', 'Demo Post 2', ''),
(2, 2, 'Demo Post 2', '<p>Demo Post 2<br></p>', '', 'Demo Post 2', 'Demo Post 2', ''),
(3, 1, 'Demo Post 2', '<p>Demo Post 2<br></p>', '', 'Demo Post 2', 'Demo Post 2', ''),
(3, 2, 'Demo Post 2', '<p>Demo Post 2<br></p>', '', 'Demo Post 2', 'Demo Post 2', '');

CREATE TABLE `post_related` (
  `post_id` int(11) NOT NULL,
  `related_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `post_to_category` (
  `post_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `seo_url` (
  `id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `query` varchar(255) NOT NULL,
  `keyword` varchar(255) NOT NULL,
  `push` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `session` (
  `id` varchar(32) NOT NULL,
  `name` varchar(32) NOT NULL,
  `data` text NOT NULL,
  `expire` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `setting` (
  `id` int(11) NOT NULL,
  `code` varchar(32) NOT NULL,
  `key` varchar(64) NOT NULL,
  `value` text NOT NULL,
  `serialized` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `setting` (`id`, `code`, `key`, `value`, `serialized`) VALUES
(1, 'config', 'config_mail_smtp_hostname', '', 0),
(2, 'config', 'config_mail_parameter', '', 0),
(3, 'config', 'config_mail_secure', '-- None --', 0),
(4, 'config', 'config_mail_engine', 'mail', 0),
(5, 'config', 'config_login_attempts', '5', 0),
(6, 'config', 'config_user_group_display', '["1"]', 1),
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

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `firstname` varchar(32) NOT NULL,
  `lastname` varchar(32) NOT NULL,
  `email` varchar(96) NOT NULL,
  `image` varchar(255) NOT NULL,
  `ip` varchar(40) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `user` (`id`, `group_id`, `username`, `password`, `firstname`, `lastname`, `email`, `image`, `ip`, `status`, `date_added`) VALUES
(1, 1, 'admin', '$2y$10$ioZ8GNFwM06/Drh8uWIqre2UkBvdDR/k8vZYzO1amy2K62gwkeGXu', 'John', 'Parker', 'admin@localhost', '/data/avatar/avatar.png', '', 1, '2018-02-04 00:00:00');

CREATE TABLE `user_group` (
  `id` int(11) NOT NULL,
  `approval` tinyint(1) NOT NULL,
  `permission` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `user_group` (`id`, `approval`, `permission`) VALUES
(1, 1, '{"access":["banner","extension\\/menu\\/menu","extension\\/module\\/slideshow","extension\\/module\\/html","extension\\/module\\/category","extension\\/module\\/banner","extension\\/theme\\/default","extension\\/dashboard\\/online","extension\\/analytics\\/google","extension\\/extension\\/theme","extension\\/extension\\/report","extension\\/extension\\/menu","extension\\/extension\\/dashboard","extension\\/extension\\/analytics","extension\\/extension\\/module","online","language","seo","layout","post","page","category","user-group","user","backup","log","setting","filemanager","admin\\/extension\\/module\\/html","admin\\/extension\\/dashboard\\/online","admin\\/extension\\/module\\/html","admin\\/extension\\/module\\/html","admin\\/extension\\/theme\\/default"],"modify":["banner","extension\\/menu\\/menu","extension\\/module\\/slideshow","extension\\/module\\/html","extension\\/module\\/category","extension\\/module\\/banner","extension\\/theme\\/default","extension\\/dashboard\\/online","extension\\/analytics\\/google","extension\\/extension\\/theme","extension\\/extension\\/report","extension\\/extension\\/menu","extension\\/extension\\/dashboard","extension\\/extension\\/analytics","extension\\/extension\\/module","online","language","seo","layout","post","page","category","user-group","user","backup","log","setting","filemanager","admin\\/extension\\/module\\/html","admin\\/extension\\/dashboard\\/online","admin\\/extension\\/module\\/html","admin\\/extension\\/module\\/html","admin\\/extension\\/theme\\/default"]}'),
(2, 1, '{"access":[],"modify":[]}');

CREATE TABLE `user_group_description` (
  `group_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `description` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `user_group_description` (`group_id`, `language_id`, `name`, `description`) VALUES
(1, 1, 'Administrator', ''),
(2, 1, 'Demonstration', '');

CREATE TABLE `user_ip` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ip` varchar(40) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `user_login` (
  `id` int(11) NOT NULL,
  `email` varchar(96) NOT NULL,
  `ip` varchar(40) NOT NULL,
  `total` int(4) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `user_online` (
  `ip` varchar(40) NOT NULL,
  `user_id` int(11) NOT NULL,
  `url` text NOT NULL,
  `referer` text NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


ALTER TABLE `banner`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `banner_image`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_id` (`parent_id`);

ALTER TABLE `category_description`
  ADD PRIMARY KEY (`category_id`,`language_id`),
  ADD KEY `name` (`name`);

ALTER TABLE `category_path`
  ADD PRIMARY KEY (`category_id`,`path_id`);

ALTER TABLE `cron`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `event`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `extension`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `language`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`);

ALTER TABLE `layout`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `layout_module`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `layout_route`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `module`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `page`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `page_description`
  ADD PRIMARY KEY (`page_id`,`language_id`),
  ADD KEY `name` (`name`);

ALTER TABLE `post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

ALTER TABLE `post_description`
  ADD PRIMARY KEY (`post_id`,`language_id`),
  ADD KEY `name` (`name`);

ALTER TABLE `post_related`
  ADD PRIMARY KEY (`post_id`,`related_id`);

ALTER TABLE `post_to_category`
  ADD PRIMARY KEY (`post_id`,`category_id`),
  ADD KEY `category_id` (`category_id`);

ALTER TABLE `seo_url`
  ADD PRIMARY KEY (`id`),
  ADD KEY `query` (`query`),
  ADD KEY `keyword` (`keyword`);

ALTER TABLE `session`
  ADD PRIMARY KEY (`id`,`name`);

ALTER TABLE `setting`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `user_group`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `user_group_description`
  ADD PRIMARY KEY (`group_id`,`language_id`);

ALTER TABLE `user_ip`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ip` (`ip`);

ALTER TABLE `user_login`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`),
  ADD KEY `ip` (`ip`);

ALTER TABLE `user_online`
  ADD PRIMARY KEY (`ip`);


ALTER TABLE `banner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `banner_image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `cron`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `extension`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `language`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `layout`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `layout_module`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `layout_route`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `module`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `page`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `seo_url`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `user_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `user_ip`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `user_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
