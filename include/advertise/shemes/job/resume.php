<?
require_once $CONFIG['engine_path'].'include/advertise/shemes/job.php';

class AdvSheme_job_resume extends AdvSheme_job
{
	public function __construct($path, $prefix = '')
	{
		$this->sheme['tables'] = array(
			'master' => '_resume',
			'slaves' => array(
				'File' 	=> '_resume_files',
				'RubricID' 	=> '_resume_ref',
				'Favorite'	=> '_resume_favorites',
			)
		);

		// Описание скалярных полей
		$this->sheme['scalar_fields']['LastName']				= array( 'type' => 'char' );	// Фамилия
		$this->sheme['scalar_fields']['FirstName']				= array( 'type' => 'char' );	// Имя
		$this->sheme['scalar_fields']['SecondName']				= array( 'type' => 'char' );	// Отчество
		$this->sheme['scalar_fields']['Birthday']				= array( 'type' => 'date' );	// Возраст
		$this->sheme['scalar_fields']['SalaryMin']				= array( 'type' => 'int' );		// Минимальная з/п
		$this->sheme['scalar_fields']['ProfessionalSkills']		= array( 'type' => 'char' );    // Профессиональные навыки
		$this->sheme['scalar_fields']['Places']					= array( 'type' => 'char' );	// Предыдущие места работы/учебы
		$this->sheme['scalar_fields']['SchoolsMore']			= array( 'type' => 'char' );	// Доп образование
		$this->sheme['scalar_fields']['Car']					= array( 'type' => 'int' );		// Наличие авто
		$this->sheme['scalar_fields']['Travel']					= array( 'type' => 'int' );		// Готов к командировкам
		$this->sheme['scalar_fields']['Children']				= array( 'type' => 'int' );		// Дети
		$this->sheme['scalar_fields']['Marriad']				= array( 'type' => 'int' );		// Семейное положение
		$this->sheme['scalar_fields']['Importance']				= array( 'type' => 'int' );		// Срочно
		$this->sheme['scalar_fields']['Photo']					= array( 'type' => 'char' );	// Фото соискателя

		parent::__construct($path, $prefix);
	}
}

class AdvIterator_job_resume extends AdvIterator_job
{
}

class Adv_job_resume extends Adv_job
{
	public function IsValid()
	{
		global $OBJECTS;

		$is_valid = true;

		if (empty($this->data['FirstName']))
		{
			UserError::AddError(ERR_L_JOB_FIRSTNAME);
			$is_valid = false;
		}

		return ( parent::IsValid() && $is_valid );
	}
}
?>