<?php
//header('Content-Type','text/html; charset=windows-1250');
require('fpdf.php');

$mena=getRequest('mena');
$polozky=array();
if (isset($_REQUEST['polozkaKs']))
{
	foreach ($_REQUEST['polozkaKs'] as $key => $polozkaKs)
	{
		$polozky[]=array($polozkaKs.' '.$_REQUEST['polozkaJedn'][$key],$_REQUEST['polozkaPopis'][$key],$_REQUEST['polozkaCena'][$key],$_REQUEST['polozkaCelkem'][$key]);	
	}
}
//$polozky[1]=array('1 ks','Progamátorské práce na webu značkomanie.cz','6 000,00 CZK','6 000,00 CZK');
makeFaktura(getRequest('cislofak'),getRequest('vystaveni'),getRequest('splatnost'),getRequest('varsym'),getRequest('odberatel'),getRequest('odbic'),$polozky,getRequest('cenacelkem'),$mena,getRequest('stahnout'),getRequest('ulozit'));

function makeFaktura($cisloFaktury,$datumVystaveni,$datumSplatnosti,$variabilniSymbol,$odberatel,$icOdberatele='',$polozky,$cenaCelkem,$mena,$stahnout,$ulozit)
{
	$pdf = new FPDF();
	$pdf->AddPage();
	$pdf->SetAutoPageBreak(false);
	$pdf->AddFont('ls', '', 'ca6d1ed48ef8058b75ca0372927c83ab_liberationsans-regular.php');
	$pdf->AddFont('ls', 'b', '153fce9a1077044fd42bca27c90df607_liberationsans-bold.php');
	$pdf->SetFont('ls','',18);
	$pdf->Cell(0,10,cesky('FAKTURA č. '.$cisloFaktury),0,1,'R');
	$pdf->Cell(0,4,'',0,1,'R');
	
	$pdf->SetFont('ls','',9);
	$pdf->Cell(110,4,'',0,0,'R');
	$pdf->Cell(40,4,cesky('Datum vystavení:'),0,0,'L');
	$pdf->Cell(0,4,cesky($datumVystaveni),0,1,'R');
	$pdf->SetFont('ls','b',9);
	$pdf->Cell(110,4,'',0,0,'R');
	$pdf->Cell(40,4,cesky('Datum splatnosti:'),0,0,'L');
	$pdf->Cell(0,4,cesky($datumSplatnosti),0,1,'R');
	$pdf->Cell(0,2,'',0,1,'R');
	$pdf->SetFont('ls','',9);
	$pdf->Cell(110,4,'',0,0,'R');
	$pdf->Cell(40,4,cesky('Forma úhrady:'),0,0,'L');
	$pdf->Cell(0,4,cesky('Bankovním převodem:'),0,1,'R');
	$pdf->Cell(110,4,'',0,0,'R');
	$pdf->Cell(40,4,cesky('Variabilní symbol:'),0,0,'L');
	$pdf->Cell(0,4,cesky($variabilniSymbol),0,1,'R');
	$pdf->Cell(110,4,'',0,0,'R');
	$pdf->Cell(40,4,cesky('Číslo bankovního účtu:'),0,0,'L');
	$pdf->Cell(0,4,cesky('221373126 / 0300'),0,1,'R');
	$pdf->Cell(0,8,'',0,1,'R');

	$pdf->SetFont('ls','b',12);
	$pdf->Cell(100,5,cesky("ODBĚRATEL"),0,0,'L');
	$pdf->Cell(0,5,cesky("DODAVATEL"),0,1,'L');

	$pdf->SetFont('ls','',9);
	$x = $pdf->GetX();$y = $pdf->GetY();
	$pdf->MultiCell(100,4,cesky($odberatel),0,'L');
	$pdf->SetXY($x + 100, $y);
	$pdf->MultiCell(0,4,cesky("Jakub Kolčář\nCihelní 575\n73801, Frýdek-Místek\nČeská republika"),0,'L');
	$pdf->Cell(0,2,'',0,1,'R');
	$x = $pdf->GetX();$y = $pdf->GetY();
	$pdf->MultiCell(100,4,cesky(($icOdberatele!='')?('IČ: '.$icOdberatele):''),0,'L');
	$pdf->SetXY($x + 100, $y);
	$pdf->MultiCell(0,4,cesky("IČ: 88724166\nNeplátce DPH"),0,'L');

	$pdf->SetFont('ls','b',10);
	$pdf->Cell(0,5,'',0,1,'R');
	$pdf->SetFillColor(200,200,200);
	$pdf->Cell(18,6,cesky('Počet'),0,0,'L',true);
	$pdf->Cell(120,6,cesky('Popis'),0,0,'L',true);
	$pdf->Cell(24,6,cesky('Cena'),0,0,'R',true);
	$pdf->Cell(0,6,cesky('Celkem'),0,0,'R',true);
	$pdf->Ln();

	foreach ($polozky as $jednaPolozka)
	{
		addTableLine($pdf,$jednaPolozka[0],$jednaPolozka[1],$jednaPolozka[2],$jednaPolozka[3],$mena);
	}
	
	//addTableLine($pdf,1,'Ukázková položka',1500,1500);

	$pdf->SetFont('ls','b',12);
	$pdf->Cell(140,6,cesky('Celkem k úhradě:'),0,0,'R',true);
	$pdf->Cell(0,6,getCena($cenaCelkem,$mena),0,1,'R',true);

	$pdf->SetY(-15);
	$pdf->SetFont('ls','b',8);
	$pdf->Cell(0,6,cesky('Vystavil: Jakub Kolčář'),0,1,'L');

	if ($stahnout=='true')
	{
		$pdf->Output('faktura_'.$cisloFaktury.'.pdf','D');	
	}
	if ($ulozit=='true')
	{
		$pdf->Output('faktury/faktura_'.$cisloFaktury.'.pdf','F');
	}
	$pdf->Output();
}

function cesky($text)
{
	return iconv("UTF-8", "WINDOWS-1250", $text);
}

function addTableLine(&$pdf,$pocet,$popis,$cena,$celkem,$mena)
{
$pdf->SetFont('ls','',10);
$pdf->SetFillColor(200,200,200);
$pdf->Cell(18,8,cesky($pocet),0,0,'L');
$pdf->Cell(120,8,cesky($popis),0,0,'L');
$pdf->Cell(24,8,getCena($cena,$mena),0,0,'R');
$pdf->Cell(0,8,getCena($celkem,$mena),0,0,'R');
$pdf->Ln();
}
function getCena($cislo,$mena)
{	
	$cena=$cislo;
	if (strtolower($mena)=='czk' || strtolower($mena)=='kč')
	{
		$cena=number_format((float)$cislo,2,',',' ');
	}
	$cena=$cena.' '.$mena;
	return $cena;
}
function getRequest($name)
{
  return (isset($_REQUEST[$name]))?$_REQUEST[$name]:'';
}
?>