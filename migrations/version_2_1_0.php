<?php
/**
 *
 * @package Registration Age Check
 * @copyright (c) 2016 david63
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace david63\registrationage\migrations;

use phpbb\db\migration\migration;

class version_2_1_0 extends migration
{
	public function update_data()
	{
		$update_data = [];

		$update_data[] = ['config.add', ['registration_age', 18]];
		$update_data[] = ['config.add', ['registration_age_admin', 0]];
		$update_data[] = ['config.add', ['registration_age_ban_length', 0]];
		$update_data[] = ['config.add', ['registration_age_ban_reason', 'Under age']];
		$update_data[] = ['config.add', ['registration_age_copy', 0]];
		$update_data[] = ['config.add', ['registration_age_display', 0]];
		$update_data[] = ['config.add', ['registration_age_ip', 0]];
		$update_data[] = ['config.add', ['registration_age_log', 1]];
		$update_data[] = ['config.add', ['registration_age_store', 1]];

		// Add the ACP module
		$update_data[] = ['module.add', ['acp', 'ACP_CAT_DOT_MODS', 'REGISTRATION_AGE']];

		$update_data[] = ['module.add', [
			'acp', 'REGISTRATION_AGE', [
				'module_basename' => '\david63\registrationage\acp\registrationage_module',
				'modes' => ['main'],
			],
		]];

		if ($this->module_check())
		{
			$update_data[] = ['module.add', ['acp', 'ACP_CAT_USERGROUP', 'ACP_USER_UTILS']];
		}

		$update_data[] = ['module.add', [
			'acp', 'ACP_USER_UTILS', [
				'module_basename' => '\david63\registrationage\acp\registrationage_data_module',
				'modes' => ['main'],
			],
		]];

		return $update_data;
	}

	public function update_schema()
	{
		return [
			'add_columns' => [
				$this->table_prefix . 'users' => [
					'user_registration_birthdate' => ['VCHAR:10', ''],
				],
			],
		];
	}

	/**
	 * Drop the columns schema from the tables
	 *
	 * @return array Array of table schema
	 * @access public
	 */
	public function revert_schema()
	{
		return [
			'drop_columns' => [
				$this->table_prefix . 'users' => [
					'user_registration_birthdate',
				],
			],
		];
	}

	protected function module_check()
	{
		$sql = 'SELECT module_id
                FROM ' . $this->table_prefix . "modules
                WHERE module_class = 'acp'
                    AND module_langname = 'ACP_USER_UTILS'
                    AND right_id - left_id > 1";

		$result    = $this->db->sql_query($sql);
		$module_id = (int) $this->db->sql_fetchfield('module_id');
		$this->db->sql_freeresult($result);

		// return true if module is empty, false if has children
		return (bool) !$module_id;
	}
}
