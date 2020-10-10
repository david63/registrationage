<?php
/**
 *
 * @package Registration Age Check
 * @copyright (c) 2016 david63
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace david63\registrationage\core;

use phpbb\config\config;
use phpbb\language\language;
use phpbb\user;

/**
 * ra_functions
 */
class ra_functions
{
	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\language\language */
	protected $language;

	/** @var \phpbb\user */
	protected $user;

	/**
	 * Constructor for ra_functions
	 *
	 * @param \phpbb\config\config      $config     Config object
	 * @param \phpbb\language\language  $language   Language object
	 * @param \phpbb\user               $user       User object
	 *
	 * @access public
	 */
	public function __construct(config $config, language $language, user $user)
	{
		$this->config   = $config;
		$this->language = $language;
		$this->user     = $user;
	}

	/**
	 * Convert birthdate to date format
	 *
	 * @return $birthdate
	 * @access public
	 */
	public function convert_birthdate($birthdate)
	{
		if ($birthdate)
		{
			if (!$this->config['registration_date_format'])
			{
				return $birthdate;
			}
			else if (!($timestamp = strtotime($birthdate)) === false) // Is the birthdate valid?
			{
				return $this->user->format_date($timestamp);
			}
			else
			{
				list($bday_day, $bday_month, $bday_year) = array_map('intval', explode('-', $birthdate));

				if ($bday_year)
				{
					$bday_day   = ($bday_day == 0) ? 1 : $bday_day; // Default to first day of the month if no day entered
					$bday_month = ($bday_month == 0) ? 1 : $bday_month; // Default to first month of the year if no month entered
					$timestamp  = strtotime($bday_day . '-' . $bday_month . '-' . $bday_year);

					return $this->user->format_date($timestamp) . $this->language->lang('APPROX_FLAG');
				}
				else
				{
					return ($this->config['registration_verbose']) ? $this->language->lang('INVALID_DATE') . ' (' . $birthdate . ')' : $birthdate;
				}
			}
		}
		else
		{
			return ($this->config['registration_verbose']) ? $this->language->lang('NO_DATE_ENTERED') : '';
		}
	}
}
