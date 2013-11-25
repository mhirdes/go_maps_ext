#
# Table structure for table 'tx_gomapsext_domain_model_address'
#
CREATE TABLE tx_gomapsext_domain_model_address (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	map int(11) unsigned DEFAULT '0' NOT NULL,
	categories int(11) unsigned DEFAULT '0' NOT NULL,
	
	title varchar(255) DEFAULT '' NOT NULL,
	configuration_map varchar(255) DEFAULT '' NOT NULL,
	latitude double(11,6) DEFAULT '0.000000' NOT NULL,
	longitude double(11,6) DEFAULT '0.000000' NOT NULL,
	address varchar(255) DEFAULT '' NOT NULL,
	marker text NOT NULL,
	image_size tinyint(1) unsigned DEFAULT '0' NOT NULL,
	image_width int(11) DEFAULT '0' NOT NULL,
	image_height int(11) DEFAULT '0' NOT NULL,
	shadow text NOT NULL,
	shadow_size tinyint(1) unsigned DEFAULT '0' NOT NULL,
	shadow_width int(11) DEFAULT '0' NOT NULL,
	shadow_height int(11) DEFAULT '0' NOT NULL,
	info_window_content text NOT NULL,
	info_window_link int(11) DEFAULT '0' NOT NULL,
	close_by_click tinyint(1) unsigned DEFAULT '0' NOT NULL,
	open_by_click tinyint(1) unsigned DEFAULT '0' NOT NULL,
	opened tinyint(1) unsigned DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	t3_origuid int(11) DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_gomapsext_domain_model_map'
#
CREATE TABLE tx_gomapsext_domain_model_map (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	title varchar(255) DEFAULT '' NOT NULL,
	tooltip_title varchar(255) DEFAULT '' NOT NULL,
	class varchar(255) DEFAULT '' NOT NULL,
	width varchar(11) DEFAULT '' NOT NULL,
	height varchar(11) DEFAULT '' NOT NULL,
	zoom int(11) DEFAULT '0' NOT NULL,
	addresses int(11) unsigned DEFAULT '0' NOT NULL,
	show_categories tinyint(1) unsigned DEFAULT '0' NOT NULL,
	kml_url text NOT NULL,
	kml_preserve_viewport tinyint(1) unsigned DEFAULT '0' NOT NULL,
	kml_local tinyint(1) unsigned DEFAULT '0' NOT NULL,
	scroll_zoom tinyint(1) unsigned DEFAULT '0' NOT NULL,
	draggable tinyint(1) unsigned DEFAULT '0' NOT NULL,
	double_click_zoom tinyint(1) unsigned DEFAULT '0' NOT NULL,
	marker_cluster tinyint(1) unsigned DEFAULT '0' NOT NULL,
	marker_cluster_zoom int(11) DEFAULT '0' NOT NULL,
	marker_cluster_size int(11) DEFAULT '0' NOT NULL,
	marker_search tinyint(1) unsigned DEFAULT '0' NOT NULL,
	default_type int(11) DEFAULT '0' NOT NULL,
	pan_control tinyint(1) unsigned DEFAULT '0' NOT NULL,
	scale_control tinyint(1) unsigned DEFAULT '0' NOT NULL,
	streetview_control tinyint(1) unsigned DEFAULT '0' NOT NULL,
	zoom_control tinyint(1) unsigned DEFAULT '0' NOT NULL,
	zoom_control_type int(11) DEFAULT '0' NOT NULL,
	map_type_control tinyint(1) unsigned DEFAULT '0' NOT NULL,
	map_types varchar(255) DEFAULT '' NOT NULL,
	show_route tinyint(1) unsigned DEFAULT '0' NOT NULL,
	calc_route tinyint(1) unsigned DEFAULT '0' NOT NULL,
	travel_mode int(11) DEFAULT '0' NOT NULL,
	unit_system int(11) DEFAULT '0' NOT NULL,
	styled_map_name varchar(255) DEFAULT '' NOT NULL,
	styled_map_code text NOT NULL,
	
	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	t3_origuid int(11) DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_gomapsext_domain_model_category'
#
CREATE TABLE tx_gomapsext_domain_model_category (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	name varchar(255) DEFAULT '' NOT NULL,
	addresses int(11) unsigned DEFAULT '0' NOT NULL,
	
	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	t3_origuid int(11) DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_gomapsext_map_address_mm'
#
CREATE TABLE tx_gomapsext_map_address_mm (
	uid_local int(11) unsigned DEFAULT '0' NOT NULL,
	uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,
	sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,

	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign)
);

#
# Table structure for table 'tx_gomapsext_address_category_mm'
#
CREATE TABLE tx_gomapsext_address_category_mm (
	uid_local int(11) unsigned DEFAULT '0' NOT NULL,
	uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,
	sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,

	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign)
);