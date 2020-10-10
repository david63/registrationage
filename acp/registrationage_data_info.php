<?php
/**
 *
 * @package Registration Age Check
 * @copyright (c) 2016 david63
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace david63\registrationage\acp;

class registrationage_data_info
{
	public function module()
	{
		return [
			'filename'	=> '\david63\registrationage\acp\registrationage_data_module',
			'title' 	=> 'REGISTRATION_AGE',
			'modes' 	=> [
				'main' => ['title' => 'REGISTRATION_AGE', 'auth' => 'ext_david63/registrationage && acl_a_user', 'cat' => ['ACP_CAT_USERS']],
			],
		];
	}
}
