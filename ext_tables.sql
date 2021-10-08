#
# Table structure for table 'tx_gomapsext_domain_model_address'
#
CREATE TABLE tx_gomapsext_domain_model_address (
	map                 int(11) unsigned    DEFAULT '0'        NOT NULL,
	categories          int(11) unsigned    DEFAULT '0'        NOT NULL,

	title               varchar(255)        DEFAULT ''         NOT NULL,
	street              varchar(255)        DEFAULT ''         NOT NULL,
	zip                 varchar(20)         DEFAULT ''         NOT NULL,
	city                varchar(255)        DEFAULT ''         NOT NULL,
	configuration_map   varchar(255)        DEFAULT ''         NOT NULL,
	latitude            double(11, 6)       DEFAULT '0.000000' NOT NULL,
	longitude           double(11, 6)       DEFAULT '0.000000' NOT NULL,
	address             varchar(255)        DEFAULT ''         NOT NULL,
	marker              int(11) unsigned                       NOT NULL default '0',
	image_size          tinyint(1) unsigned DEFAULT '0'        NOT NULL,
	image_width         int(11)             DEFAULT '0'        NOT NULL,
	image_height        int(11)             DEFAULT '0'        NOT NULL,
	info_window_content text                DEFAULT ''         NOT NULL,
	info_window_link    int(11)             DEFAULT '0'        NOT NULL,
	info_window_images  int(11) unsigned                       NOT NULL default '0',
	close_by_click      tinyint(1) unsigned DEFAULT '0'        NOT NULL,
	open_by_click       tinyint(1) unsigned DEFAULT '0'        NOT NULL,
	opened              tinyint(1) unsigned DEFAULT '0'        NOT NULL
);

#
# Table structure for table 'tx_gomapsext_domain_model_map'
#
CREATE TABLE tx_gomapsext_domain_model_map (
	title                 varchar(255)        DEFAULT ''         NOT NULL,
	width                 varchar(11)         DEFAULT ''         NOT NULL,
	height                varchar(11)         DEFAULT ''         NOT NULL,
	zoom                  int(11)             DEFAULT '0'        NOT NULL,
	addresses             int(11) unsigned    DEFAULT '0'        NOT NULL,
	show_addresses        tinyint(1) unsigned DEFAULT '0'        NOT NULL,
	show_categories       tinyint(1) unsigned DEFAULT '0'        NOT NULL,
	kml_url               text                                   NOT NULL,
	kml_preserve_viewport tinyint(1) unsigned DEFAULT '0'        NOT NULL,
	kml_local             tinyint(1) unsigned DEFAULT '0'        NOT NULL,
	scroll_zoom           tinyint(1) unsigned DEFAULT '0'        NOT NULL,
	zoom_min              int(11)             DEFAULT '0'        NOT NULL,
	zoom_max              int(11)             DEFAULT '0'        NOT NULL,
	longitude             double(11, 6)       DEFAULT '0.000000' NOT NULL,
	latitude              double(11, 6)       DEFAULT '0.000000' NOT NULL,
	geolocation           tinyint(1) unsigned DEFAULT '0'        NOT NULL,
	preview_image         int(11) unsigned                       NOT NULL default '0',
	draggable             tinyint(1) unsigned DEFAULT '0'        NOT NULL,
	double_click_zoom     tinyint(1) unsigned DEFAULT '0'        NOT NULL,
	marker_cluster        tinyint(1) unsigned DEFAULT '0'        NOT NULL,
	marker_cluster_zoom   int(11)             DEFAULT '0'        NOT NULL,
	marker_cluster_size   int(11)             DEFAULT '0'        NOT NULL,
	marker_cluster_style  text                                   NOT NULL,
	marker_search         tinyint(1) unsigned DEFAULT '0'        NOT NULL,
	default_type          int(11)             DEFAULT '0'        NOT NULL,
	scale_control         tinyint(1) unsigned DEFAULT '0'        NOT NULL,
	streetview_control    tinyint(1) unsigned DEFAULT '0'        NOT NULL,
	fullscreen_control    tinyint(1) unsigned DEFAULT '0'        NOT NULL,
	zoom_control          tinyint(1) unsigned DEFAULT '0'        NOT NULL,
	map_type_control      tinyint(1) unsigned DEFAULT '0'        NOT NULL,
	map_types             varchar(255)        DEFAULT ''         NOT NULL,
	show_route            tinyint(1) unsigned DEFAULT '0'        NOT NULL,
	calc_route            tinyint(1) unsigned DEFAULT '0'        NOT NULL,
	travel_mode           int(11)             DEFAULT '0'        NOT NULL,
	unit_system           int(11)             DEFAULT '0'        NOT NULL,
	styled_map_name       varchar(255)        DEFAULT ''         NOT NULL,
	styled_map_code       text                                   NOT NULL
);

#
# Table structure for table 'tx_gomapsext_domain_model_key'
#
CREATE TABLE tx_gomapsext_domain_model_key (
	title   varchar(255) DEFAULT '' NOT NULL,
	api_key varchar(255) DEFAULT '' NOT NULL,
);

#
# Table structure for table 'tx_gomapsext_map_address_mm'
#
CREATE TABLE tx_gomapsext_map_address_mm (
	uid_local       int(11) unsigned DEFAULT '0' NOT NULL,
	uid_foreign     int(11) unsigned DEFAULT '0' NOT NULL,
	sorting         int(11) unsigned DEFAULT '0' NOT NULL,
	sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,

	KEY uid_local(uid_local),
	KEY uid_foreign(uid_foreign)
);

#
# Extend table structure of table 'sys_category'
#
CREATE TABLE sys_category (
	gme_marker       int(11) unsigned                NOT NULL default '0',
	gme_image_size   tinyint(1) unsigned DEFAULT '0' NOT NULL,
	gme_image_width  int(11)             DEFAULT '0' NOT NULL,
	gme_image_height int(11)             DEFAULT '0' NOT NULL,
);
