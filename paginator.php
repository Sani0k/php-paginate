<?php
	class Paginator {
		private $currentPage, $lastPage, $firstPage = 1, $scope = 3;
		private $start, $goal, $maxrange;
		
		private function Paginate() {
			$this->currentPage = ($this->currentPage < $this->firstPage) ? $this->firstPage : $this->currentPage;
			$this->start = ($this->lastPage > $this->maxrange) ? max($this->firstPage, $this->currentPage - $this->scope) : $this->firstPage;
			$this->goal = ($this->lastPage > $this->maxrange) ? min($this->lastPage, $this->currentPage + $this->scope) : $this->lastPage;
		}
		
		function __construct( $total, $present = 1 ) {
			$this->currentPage = $present;
			$this->lastPage = $total;
			$this->maxrange = $this->scope * 2 - 1;
			$this->Paginate();
		}
		
		public function Generate() {
			$element = "<li style='display: inline; padding: 0px 2px;'><span>%d</span></li>";
			echo "<ul style='display: inline-block;'>";
			if( $this->start == $this->firstPage ) {
				for( $i = $this->start; $i <= $this->goal; $i++ ) {
					echo sprintf( $element, $i ) . "\n";
				}
				if( $this->goal != $this->lastPage ) {
					echo sprintf( $element, $this->lastPage ) . "\n";
				}
			}
			else {
				echo sprintf( $element, $this->firstPage ) . "\n";
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
