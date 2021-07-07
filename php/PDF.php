<?php
	require("fpdf.php");
	
	class PDF extends FPDF{
		function BasicTable($header, $data){
			foreach($header as $col)
				$this->Cell(80,7,$col,1);
			$this->Ln();
			foreach($data as $row){
				$y = $this->GetY();
				$flag = false;
				$x = 0;
				foreach($row as $col){
					$this->SetY($y, false);
					if($flag) {
						$this->SetX(90);
					}
					$this->MultiCell(80,6,$col,1);
					$flag = true;
				}
				$this->Ln();
			}
		}
		
		function Table($data) {
			foreach($data as $row){
				$flag = false;
				foreach($row as $col){
					if(!$flag){
						$this->Cell(40,6,iconv('utf-8', 'ISO-8859-15', $col),1);
						$flag = true;
					} else {
						$this->Cell(0,6,iconv('utf-8', 'ISO-8859-15', $col),1);
					}
				}
				$this->Ln();
			}
			
		}
		
		function MultiCellMod($w, $h, $txt, $border=0, $align='J', $fill=false){
			// Output text with automatic or explicit line breaks
			if(!isset($this->CurrentFont))
				$this->Error('No font has been set');
			$cw = &$this->CurrentFont['cw'];
			if($w==0)
				$w = $this->w-$this->rMargin-$this->x;
			$wmax = ($w-2*$this->cMargin)*1000/$this->FontSize;
			$s = str_replace("\r",'',$txt);
			$nb = strlen($s);
			if($nb>0 && $s[$nb-1]=="\n")
				$nb--;
			$b = 0;
			if($border){
				if($border==1){
					$border = 'LTRB';
					$b = 'LRT';
					$b2 = 'LR';
				} else {
					$b2 = '';
					if(strpos($border,'L')!==false)
						$b2 .= 'L';
					if(strpos($border,'R')!==false)
						$b2 .= 'R';
					$b = (strpos($border,'T')!==false) ? $b2.'T' : $b2;
				}
			}
			$sep = -1;
			$i = 0;
			$j = 0;
			$l = 0;
			$ns = 0;
			$nl = 1;
			while($i<$nb){
				// Get next character
				$c = $s[$i];
				if($c=="\n"){
					// Explicit line break
					if($this->ws>0){
						$this->ws = 0;
						$this->_out('0 Tw');
					}
					$this->Cell($w,$h,substr($s,$j,$i-$j),$b,0,$align,$fill);
					$this->ln(6);
					$i++;
					$sep = -1;
					$j = $i;
					$l = 0;
					$ns = 0;
					$nl++;
					if($border && $nl==2)
						$b = $b2;
					continue;
				}
				if($c==' '){
					$sep = $i;
					$ls = $l;
					$ns++;
				}
				$l += $cw[$c];
				if($l>$wmax){
					// Automatic line break
					if($sep==-1){
						if($i==$j)
							$i++;
						if($this->ws>0){
							$this->ws = 0;
							$this->_out('0 Tw');
						}
						$this->Cell($w,$h,substr($s,$j,$i-$j),$b,0,$align,$fill);
						$this->ln(6);
					} else {
						if($align=='J') {
							$this->ws = ($ns>1) ? ($wmax-$ls)/1000*$this->FontSize/($ns-1) : 0;
							$this->_out(sprintf('%.3F Tw',$this->ws*$this->k));
						}
						$this->Cell($w,$h,substr($s,$j,$sep-$j),$b,0,$align,$fill);
						$this->ln(6);
						$i = $sep+1;
					}
					$sep = -1;
					$j = $i;
					$l = 0;
					$ns = 0;
					$nl++;
					if($border && $nl==2)
						$b = $b2;
				}
				else
					$i++;
			}
			// Last chunk
			if($this->ws>0) {
				$this->ws = 0;
				$this->_out('0 Tw');
			}
			if($border && strpos($border,'B')!==false)
				$b .= 'B';
			$this->Cell($w,$h,substr($s,$j,$i-$j),$b,0,$align,$fill);
			$this->ln(6);
			$this->x = $this->lMargin;
		}
	}
?>