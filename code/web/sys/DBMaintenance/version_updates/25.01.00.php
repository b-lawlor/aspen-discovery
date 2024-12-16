<?php

function getUpdates25_01_00(): array {
	$curTime = time();
	return [
		/*'name' => [
			 'title' => '',
			 'description' => '',
			 'continueOnError' => false,
			 'sql' => [
				 ''
			 ]
		 ], //name*/

		//mark - Grove
		'add_middle_initial_support' => [
			'title' => 'Add Middle Initial Display Name support',
			'description' => 'Add support for middle names for users when creating display names',
			'continueOnError' => false,
			'sql' => [
				"ALTER TABLE library CHANGE COLUMN patronNameDisplayStyle patronNameDisplayStyle ENUM('firstinitial_lastname', 'lastinitial_firstname','firstinitial_middleinitial_lastname', 'firstname_middleinitial_lastinitial') DEFAULT 'firstinitial_lastname';",
			]
		], //add_middle_initial_support
		'link_syndetics_and_libraries' => [
			'title' => 'Link Syndetics and Libraries',
			'description' => 'Link syndetics and libraries so each library can have a different Syndetics subscription',
			'sql' => [
				"ALTER TABLE library ADD COLUMN syndeticsSettingId INT DEFAULT -1",
				"ALTER TABLE syndetics_settings ADD COLUMN name TINYTEXT default 'default' UNIQUE",
				"linkSyndeticsToLibraries",
			]
		], //link_syndetics_and_libraries
		'syndetics_add_instance_number' => [
			'title' => 'Add Syndetics Unbound Instance Number',
			'description' => 'Add Syndetics Unbound Instance Number',
			'sql' => [
				'ALTER TABLE syndetics_settings ADD COLUMN unboundInstanceNumber int(11) DEFAULT 0'
			]
		], //syndetics_add_instance_number

		//katherine

		//kirstien - Grove
        'sublocation_permissions' => [
            'title' => 'Sublocation Permissions',
            'description' => 'Add new permissions for sublocation functionality',
            'continueOnError' => true,
            'sql' => [
                "INSERT INTO permissions (sectionName, name, requiredModule, weight, description) VALUES ('Primary Configuration - Location Sublocations', 'Administer Sublocations for All Libraries', '', 10, 'Allows Sublocation functionality to be configured for all libraries.')",
                "INSERT INTO permissions (sectionName, name, requiredModule, weight, description) VALUES ('Primary Configuration - Location Sublocations', 'Administer Sublocations for Home Library', '', 20, 'Allows Sublocation functionality to be configured for the user\'s home library.')",
                "INSERT INTO role_permissions(roleId, permissionId) VALUES ((SELECT roleId from roles where name='opacAdmin'), (SELECT id from permissions where name='Administer Sublocations for All Libraries'))",
            ],
        ], //sublocation_permissions
        'sublocation_settings' => [
            'title' => 'Sublocation Settings',
            'description' => 'Add new settings for Sublocation functionality',
            'continueOnError' => true,
            'sql' => [
                "CREATE TABLE sublocation (
					id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
					name VARCHAR(50) NOT NULL UNIQUE,
					weight INT DEFAULT 0,
					ilsId VARCHAR(50),
					locationId INT(11) NOT NULL,
					isValidHoldPickupAreaILS TINYINT(1) DEFAULT 0,
					isValidHoldPickupAreaAspen TINYINT(1) DEFAULT 0
				) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_general_ci",
            ]
        ], //sublocation_settings
        'sublocation_user_preferences' => [
            'title' => 'Sublocation User Preferences',
            'description' => 'Add new user preferences for sublocation functionality',
            'continueOnError' => true,
            'sql' => [
                "ALTER TABLE user ADD COLUMN pickupSublocationId INT(11) DEFAULT 0",
            ],
        ], //sublocation_user_preferences
        'sublocation_hold_data' => [
            'title' => 'Sublocation Hold Data',
            'description' => 'Add new columns in holds for sublocation functionality',
            'continueOnError' => true,
            'sql' => [
                "ALTER TABLE user_hold ADD COLUMN pickupSublocationId VARCHAR(50)",
                "ALTER TABLE user_hold ADD COLUMN pickupSublocationName VARCHAR(100)",
            ],
        ], //sublocation_hold_data
        'sublocation_ptype_restriction' => [
            'title' => 'Sublocation Patron Type Restrictions',
            'description' => 'Add new table for restricting patron types to sublocations',
            'continueOnError' => true,
            'sql' => [
                "CREATE TABLE sublocation_ptype (
					id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
					sublocationId INT(11),
					patronTypeId INT(11)
				) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_general_ci",
            ]
        ], //sublocation_ptype_restriction

		//kodi

		//alexander - PTFS-Europe

		//chloe - PTFS-Europe

		//James Staub - Nashville Public Library

		//Lucas Montoya - Theke Solutions

		//other

	];
}

function linkSyndeticsToLibraries(&$update) : void {
	require_once ROOT_DIR . '/sys/Enrichment/SyndeticsSetting.php';
	$syndeticsSetting = new SyndeticsSetting();
	if ($syndeticsSetting->find(true)) {
		global $aspen_db;
		$aspen_db->query("UPDATE library set syndeticsSettingId = $syndeticsSetting->id");
	}
}
