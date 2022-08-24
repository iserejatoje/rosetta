<?
class Lib_Matrix {
	public $representation = array();
	private $class = __CLASS__;

	public function Init($a) {
	    if ( is_array($a) )
			$this->representation = $a;
	}
	function __construct($a = null)
	{
		if ($a !== null)
			$this->Init($a);
	}
	
	// выполняет транспонирование < матрицы >
	function transposition( $self = true ) {
		$result = array();

		foreach ( $this->representation as $i => $line )
			foreach ( $line as $j => $value )
				$result[$j][$i] = $value;

		if ( $self ) {
			$this->representation = $result;
			return $this;
		} else 
			return new $this->class($result);
	}

	function sum_columns() {
		$result = array();

		foreach ( $this->representation as $i => $line )
			$result[$i] = array_sum($line);

		return new $this->class($result);
	}

	function sum_rows() {
		$transposed = $this->transposition(false);

		return $transposed->sum_columns();
	}

	function raise($power, $self = true) {
		$result = array();

		foreach ( $this->representation as $i => $line )
			if ( is_array($line) )
				foreach ( $line as $j => $value )
					$result[$i][$j] = pow($value, $power);
			else
				$result[$i] = pow($line, $power);

		if ( $self ) {
			$this->representation = $result;
			return $this;
		} else
			return new $this->class($result);
	}

// *****************************************
//
// Умножаем на число.
// Умножаем построчно на столбец. Не является операцией умножения матриц.
//
// *********************************************
	function multiple($factor, $self = true) {
		$result = array();

		foreach ( $this->representation as $i => $line ) {
			$f = is_numeric($factor)? $factor: $factor->representation[$i];

			if ( is_array($line) )
				foreach ( $line as $j => $value )
					$result[$i][$j] = $value * $f;
			else
				$result[$i] = $line * $f;
		}

		if ( $self ) {
			$this->representation = $result;
			return $this;
		} else
			return new $this->class($result);
	}

	// вывод < матрицы >
	function dump() {
		$result = '';

		foreach ( $this->representation as $i => $line ) {
			$result .= '[';
			if ( is_array($line) )
				foreach ( $line as $j => $value )
					$result .= number_format($value, 2, ',', '').'&nbsp;&nbsp;&nbsp;';
			else
				$result .= number_format($line, 2, ',', '').'&nbsp;&nbsp;&nbsp;';

			$result .= ']<br/>';
		}

		echo $result;
	}
};
?>