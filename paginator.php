<?php
	class Paginator {
		private $currentPage, $lastPage;
		private $options = Array(
			'firstPage' => 1,
			'scope' => 3,
		);
		private $start, $goal, $maxrange;
		
		function __construct( $total, $present = 1, $options = Array() ) {
			$options = array_merge( $this->options, $options );
			$this->currentPage = $present;
			$this->lastPage = $total;
		}
		
		public function setOption( $literal, $value ) {
			if( isset($this->options[$literal]) ) {
				$this->options[$literal] = $value;
			}
		}
		
		public function Paginate() {
			$this->maxrange = $options['scope'] * 2 - 1;
			$this->currentPage = ($this->currentPage < $this->options['firstPage']) ? $this->options['firstPage'] : $this->currentPage;
			$this->start = ($this->lastPage > $this->maxrange) ? max($this->options['firstPage'], $this->currentPage - $this->options['scope']) : $this->options['firstPage'];
			$this->goal = ($this->lastPage > $this->maxrange) ? min($this->lastPage, $this->currentPage + $this->options['scope']) : $this->lastPage;
		}
		
		public function Generate() {
			$element = "<li style='display: inline; padding: 0px 2px;'><span>%d</span></li>";
			echo "<ul style='display: inline-block;'>";
			if( $this->start == $this->options['firstPage'] ) {
				for( $i = $this->start; $i <= $this->goal; $i++ ) {
					echo sprintf( $element, $i ) . "\n";
				}
				if( $this->goal != $this->lastPage ) {
					echo sprintf( $element, $this->lastPage ) . "\n";
				}
			}
			else {
				echo sprintf( $element, $this->options['firstPage'] ) . "\n";
				for( $i = $this->start; $i <= $this->goal; $i++ ) {
					echo sprintf( $element, $i ) . "\n";
				}
				if( $this->goal != $this->lastPage ) {
					echo sprintf( $element, $this->lastPage ) . "\n";
				}
			}
		}
	}
?>
