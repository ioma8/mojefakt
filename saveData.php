<?php
include 'config.php';
$cislofak=getRequest('cislofak');
$vystaveni=getRequest('vystaveni');
$splatnost=getRequest('splatnost');
$varsym=getRequest('varsym');
$odberatel=getRequest('odberatel');
$odbic=getRequest('odbic');
$cenacelkem=getRequest('cenacelkem');
$mena=getRequest('mena');
$query="INSERT INTO faktur_faktury (cisloFaktury,odberatel,odberatelIco,zpusobPlatby,variabilniSymbol,datumVystaveni,datumSplatnosti,cenaCelkem,dataCreated,mena) VALUES ('$cislofak','$odberatel','$odbic','prevodem','$varsym','$vystaveni','$splatnost','$cenacelkem',NOW(),'$mena')";
mysql_query($query);
$fakturaId=mysql_insert_id();
if (isset($_REQUEST['polozkaKs']))
{
	foreach ($_REQUEST['polozkaKs'] as $key => $polozkaKs)
	{
		$jednotkaKs=$_REQUEST['polozkaJedn'][$key];
		$polozkaPopis=$_REQUEST['polozkaPopis'][$key];
		$polozkaCena=$_REQUEST['polozkaCena'][$key];
		$polozkaCelkem=$_REQUEST['polozkaCelkem'][$key];
		$query="INSERT INTO faktur_polozky (idFaktury,pocetKs,jednotkaKs,popis,cenaKs,cenaCelkem) VALUES ('$fakturaId','$polozkaKs','$jednotkaKs','$polozkaPopis','$polozkaCena','$polozkaCelkem')";
		mysql_query($query);
	}
}
echo 'Uloženo.';

function getRequest($name)
{
  return (isset($_REQUEST[$name]))?$_REQUEST[$name]:'';
}
?>