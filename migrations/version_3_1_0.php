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

class version_3_1_0 extends migration
{
	/**
	 * Assign migration file dependencies for this migration
	 *
	 * @return array Array of migration files
	 * @static
	 * @access public
	 */
	public static function depends_on()
	{
		return ['\david63\registrationage\migrations\version_2_1_0'];
	}

	public function update_data()
	{
		return [
			['config.add', ['registration_age_show', 0]],
			['config.add', ['registration_date_format', 0]],
			['config.add', ['registration_verbose', 1]],
		];
	}

}
