<?php

function getUpdates25_02_00(): array {
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
		'ptype_account_profile' => [
			'title' => 'Patron Type - Add Account Profile',
			'description' => 'Add Information about which account profile a patron type belongs to',
			'continueOnError' => true,
			'sql' => [
				'ALTER TABLE ptype ADD COLUMN accountProfileId INT',
				"UPDATE ptype set accountProfileId = (SELECT MIN(id) from account_profiles where ils <> 'na' and name <> 'admin')",
				"ALTER TABLE ptype DROP INDEX ptype",
				"ALTER TABLE ptype ADD UNIQUE INDEX ptype_profile(ptype, accountProfileId)",
			]
		], //ptype_account_profile
		'manage_local_administrators_permission' => [
			'title' => 'Manage Local Administrators Permission',
			'description' => 'Add new permission to manage local administrators',
			'continueOnError' => true,
			'sql' => [
				"INSERT INTO permissions (sectionName, name, requiredModule, weight, description) VALUES ('System Administration', 'Manage Local Administrators', '', 12, 'Allows an administrator to add, edit, and delete local administrators.')",
				"INSERT INTO role_permissions(roleId, permissionId) VALUES ((SELECT roleId from roles where name='userAdmin'), (SELECT id from permissions where name='Manage Local Administrators'))",
			],
		], //manage_local_administrators_permission
		'account_profile_admin_updates' => [
			'title' => 'Admin Account Profile Updates',
			'description' => 'Clean up default admin account profile',
			'continueOnError' => true,
			'sql' => [
				"UPDATE account_profiles set vendorOpacUrl = '', patronApiUrl = '', ils = 'na', driver = '', recordSource = '' where name = 'admin'",
			],
		], //account_profile_admin_updates
		'two_factor_authentication' => [
			'title' => 'Two Factor Authentication Updates',
			'description' => 'Remove unused settings and add new link to account profile for two factor authentication',
			'continueOnError' => true,
			'sql' => [
				'ALTER TABLE two_factor_auth_settings DROP COLUMN authMethods',
				'ALTER TABLE two_factor_auth_settings ADD COLUMN accountProfileId INT',
				"UPDATE two_factor_auth_settings set accountProfileId = (SELECT MIN(id) from account_profiles where ils <> 'na' and name <> 'admin')"
			]
		], //two_factor_authentication
		'indexing_profile_remove_unused_properties' => [
			'title' => 'Indexing Profile remove unused properties',
			'description' => 'Remove unused properties from indexing profiles',
			'sql' => [
				'ALTER TABLE indexing_profiles DROP column groupingClass',
				'ALTER TABLE indexing_profiles DROP column recordDriver',
			]
		], //indexing_profile_remove_unused_properties
		'sideload_remove_unused_properties' => [
			'title' => 'SideLoad remove unused properties',
			'description' => 'Remove unused properties from sideloads',
			'sql' => [
				'ALTER TABLE sideloads DROP column groupingClass',
				'ALTER TABLE sideloads DROP column recordDriver',
			]
		], //sideload_remove_unused_properties

		//katherine

		//kirstien - Grove

		//kodi

		//alexander - PTFS-Europe

		//chloe - PTFS-Europe

		//James Staub - Nashville Public Library

		//Lucas Montoya - Theke Solutions

		//other

	];
}
