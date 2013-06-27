<?php
	class Paginator {
		private $currentPage, $lastPage, $start, $goal, $maxrange;
		private $options = Array(
			'firstPage' => 1,
			'scope' => 3,
		);
		private $isPaginated = FALSE;
		
		function __construct( $total, $present = 1, $options = Array() ) {
			$this->options = array_merge( $this->options, $options );
			$this->currentPage = (int) $present;
			$this->lastPage = (int) $total;
		}
		
		private function Logic() {
			$this->maxrange = (int) ($this->options['scope'] * 2 - 1);
			$this->options['firstPage'] = (int) ($this->options['firstPage'] < $this->lastPage) ? $this->options['firstPage'] : 1;
			$this->currentPage = (int) ($this->currentPage < $this->options['firstPage']) ? $this->options['firstPage'] : $this->currentPage;
		}
		
		public function setOption( $literal, $value ) {
			if( isset($this->options[$literal]) ) {
				$this->options[$literal] = $value;
			}
			$this->isPaginated = FALSE;
			return $this;
		}
		
		public function setScope( $value ) {
			return $this->setOption( 'scope', $value );
		}
		
		public function setFirstPage( $value ) {
			return $this->setOption( 'firstPage', $value );
		}
		
		public function Paginate() {
			$this->Logic();
			$this->start = (int) ($this->lastPage > $this->maxrange) ? max($this->options['firstPage'], $this->currentPage - $this->options['scope']) : $this->options['firstPage'];
			$this->goal = (int) ($this->lastPage > $this->maxrange) ? min($this->lastPage, $this->currentPage + $this->options['scope']) : $this->lastPage;
			$this->isPaginated = TRUE;
			return $this;
		}
		
		public function Generate() {
			if( $this->isPaginated !== TRUE ) {
				throw new Exception( "You need to call Paginator::Paginate() before generating results." );
			}
			$doc = new DOMDocument();
			$u = $doc->createElement( 'ul' );
			$u->setAttribute( 'style', 'display: inline-block;' );
			if( $this->start == $this->options['firstPage'] ) {
				for( $i = $this->start; $i <= $this->goal; $i++ ) {
					$l = $doc->createElement( 'li' );
					$l->setAttribute( 'style', 'display: inline; padding: 0px 2px;' );
					$l->appendChild( $doc->createElement( 'span', $i ) );
					$u->appendChild( $l );
				}
				if( $this->goal != $this->lastPage ) {
					$l = $doc->createElement( 'li' );
					$l->setAttribute( 'style', 'display: inline; padding: 0px 2px;' );
					$l->appendChild( $doc->createElement( 'span', $this->lastPage ) );
					$u->appendChild( $l );
				}
			}
			else {
				$l = $doc->createElement( 'li' );
				$l->setAttribute( 'style', 'display: inline; padding: 0px 2px;' );
				$l->appendChild( $doc->createElement( 'span', $this->options['firstPage'] ) );
				$u->appendChild( $l );
				for( $i = $this->start; $i <= $this->goal; $i++ ) {
					$l = $doc->createElement( 'li' );
					$l->setAttribute( 'style', 'display: inline; padding: 0px 2px;' );
					$l->appendChild( $doc->createElement( 'span', $i ) );
					$u->appendChild( $l );
				}
				if( $this->goal != $this->lastPage ) {
					$l = $doc->createElement( 'li' );
					$l->setAttribute( 'style', 'display: inline; padding: 0px 2px;' );
					$l->appendChild( $doc->createElement( 'span', $this->lastPage ) );
					$u->appendChild( $l );
				}
			}
			$doc->appendChild( $u );
			$doc->formatOutput = TRUE;
			echo $doc->saveHTML();
		}
	}
?>
