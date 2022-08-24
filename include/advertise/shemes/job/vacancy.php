<?
require_once $CONFIG['engine_path'].'include/advertise/shemes/job.php';

class AdvSheme_job_vacancy extends AdvSheme_job
{
	public function __construct($path, $prefix = '')
	{
		$this->sheme['tables'] = array(
			'master' => '_vacancy',
			'slaves' => array(
				'File' 	=> '_vacancy_files',
				'RubricID' 	=> '_vacancy_ref',
				'Favorite'	=> '_vacancy_favorites',
			)
		);

		// Описание скалярных полей
		$this->sheme['scalar_fields']['Firm']				= array( 'type' => 'char' );	// Фирма
		$this->sheme['scalar_fields']['SalaryMin']			= array( 'type' => 'int' );		// З/П мин
		$this->sheme['scalar_fields']['SalaryMax']			= array( 'type' => 'int' );		// З/П макс
		$this->sheme['scalar_fields']['SalaryForm']			= array( 'type' => 'int' );		// Форма оплаты
		$this->sheme['scalar_fields']['Terms']				= array( 'type' => 'char' );	// Условия работы
		$this->sheme['scalar_fields']['Requirements']		= array( 'type' => 'char' );	// Требования
		$this->sheme['scalar_fields']['Responsibilities']	= array( 'type' => 'char' );	// Обязанности
		$this->sheme['scalar_fields']['About']				= array( 'type' => 'char' );	// О компании
		$this->sheme['scalar_fields']['Languages']			= array( 'type' => 'char' );	// Знание языков
		$this->sheme['scalar_fields']['Computer']			= array( 'type' => 'char' );	// Знание компьютера
		$this->sheme['scalar_fields']['Business']			= array( 'type' => 'char' );	// Бизнес-образование
		$this->sheme['scalar_fields']['Fax']				= array( 'type' => 'char' );	// Номер факса

		parent::__construct($path, $prefix);
	}
}

class AdvIterator_job_vacancy extends AdvIterator_job
{
}

class Adv_job_vacancy extends Adv_job
{
	public function IsValid()
	{
		global $OBJECTS;

		$is_valid = true;

		return ( parent::IsValid() && $is_valid );
	}
}
?>