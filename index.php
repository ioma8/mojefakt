<!DOCTYPE html>
<html lang="cs">
<head>
	<meta charset="utf-8">
	<title>Faktur</title>
	<meta name="description" content="">
	<link href="css/normalize.css" rel="stylesheet" media="all">
	<!--[if lt IE 9]><script src="js/html5shiv-printshiv.js" media="all"></script><![endif]-->
<script src="//code.jquery.com/jquery-1.9.1.min.js"></script> 
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.1/css/bootstrap.min.css"  rel="stylesheet" media="all"> 
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.1/js/bootstrap.min.js"></script> 
<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css"  rel="stylesheet" media="all">
<link href="css/styles.css" rel="stylesheet" media="all">
</head>
<body>
	<div class="container wrap">
		<header role="banner">			
      <nav class="navbar navbar-inverse" role="navigation">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="sr-only">Zobrazit menu</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Faktur</a>
          </div>
          <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li class="active"><a href="#">Vytvořit fakturu</a></li>
              <li><a href="price.html">Vydané faktury</a></li>
              <li><a href="contact.html">Nastavení</a></li>
            </ul>
          </div>
        </div>
      </nav>
		</header>
    <div class="row">
<div class="col-lg-6">
      <div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title">Údaje fakutry</h3>
            </div>
            <div class="panel-body">
				<form method="post" action="fakturamake.php" class="submitForm form-horizontal" role="form" target="nahledIframe" autocomplete="off">
					<div class="form-group">
            <label class="control-label col-sm-2" for="cislofak">Číslo:</label>
            <div class="col-sm-8"><input type="text" name="cislofak" id="cislofak" value="x1403001" placeholder="číslo faktury" class="form-control"/></div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="vystaveni">Vystavení:</label>
            <div class="col-sm-8"><input type="text" name="vystaveni" id="vystaveni" value="<?php echo date("j.n.Y"); ?>" placeholder="datum vystavení" class="form-control"/></div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="splatnost">Splatnost:</label>
            <div class="col-sm-8"><input type="text" name="splatnost" id="splatnost" value="<?php echo date("j.n.Y",time()+60*60*24*15); ?>" placeholder="datum splatnosti" class="form-control"/></div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="varsym">Var.sym.:</label>
            <div class="col-sm-8"><input type="text" name="varsym" id="varsym" value="" placeholder="variabilní symbol" class="form-control"/></div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="odberatel">Odběratel:</label>
            <div class="col-sm-8">
              <textarea name="odberatel" id="odberatel" value="" placeholder="odběratel" class="form-control" rows="4"/></textarea>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="odbic">IČ:</label>
            <div class="col-sm-8"><input type="text" name="odbic" id="odbic" value="" placeholder="IČ odběratele" class="form-control"/></div>
          </div>
          <div class="form-group">
            <h4 class="col-sm-9">Položky</h4>
            <div class="col-sm-2 btn btn-success" id="pridatPolozku"><span class="glyphicon glyphicon-plus-sign"></span> Přidat</div>
          </div>
          <div id="polozka1">
            <div class="form-group">
              <label class="col-sm-2">Popis</label>
              <div class="col-sm-8"><input type="text" name="polozkaPopis[]" value="" placeholder="popis" class="form-control"/></div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-1">Ks</label>
              <div class="col-sm-2"><input type="text" name="polozkaKs[]" value="1" placeholder="1" class="form-control polozkaPrepocist polozkaKs"/></div>
              <label class="control-label col-sm-1">Jedn.</label>
              <div class="col-sm-2"><input type="text" name="polozkaJedn[]" value="ks" placeholder="ks" class="form-control"/></div>
              <label class="control-label col-sm-1">Cena</label>
              <div class="col-sm-2"><input type="text" name="polozkaCena[]" value="" placeholder="cena" class="form-control polozkaPrepocist polozkaCena"/></div>
              <label class="control-label col-sm-1">=<span class="cenaPolozkyCelkem">0</span></label>
              <input type="hidden" name="polozkaCelkem[]" class="cenaPolozkyCelkemVal" value="0"/>
            </div>
          </div>
          <div id="dalsiPolozky"></div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="cenacelkem">Celkem:</label>
            <div class="col-sm-8"><input type="text" name="cenacelkem" id="cenacelkem" value="" placeholder="Cena celkem" class="form-control"/></div>
            <div class="col-sm-2"><input type="text" name="mena" value="CZK" placeholder="měna" class="form-control"/></div>
          </div>
          <input type="hidden" name="stahnout" value="false"/>
          <input type="hidden" name="ulozit" value="false"/>
					<button class="btn btn-xs btn-danger" id="stahnoutButton"/><span class="glyphicon glyphicon-save"></span> stáhnout PDF</button>
          <button class="btn btn-xs btn-warning" id="ulozitButton"/><span class="glyphicon glyphicon-floppy-disk"></span> uložit</button>
				</form>
            </div>
          </div>
</div>
<div class="col-lg-6">
<div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">Náhled</h3>
            </div>
            <div class="panel-body">
              <iframe src="fakturamake.php" width="100%" height="720" seamless="seamless" name="nahledIframe">
              </iframe>
            </div>
          </div>
        </div>
      </div>
		<footer role="contentinfo">
			<small>Copyright &copy; <time datetime="2013">2013</time></small>
		</footer>
	</div>
	<script>
		var _gaq=[['_setAccount','UA-XXXX-XX'],['_trackPageview']];(function(a,b){var c=a.createElement(b),d=a.getElementsByTagName(b)[0];c.src=("https:"==location.protocol?"//ssl":"//www")+".google-analytics.com/ga.js";d.parentNode.insertBefore(c,d)})(document,"script");
	</script>
<script type="text/javascript">

$(function (){
  $('.submitForm').submit();

  $("#pridatPolozku").click(function(){
    $("#dalsiPolozky").before($('#polozka1').html());
  });
  $('.submitForm').on('change','.polozkaPrepocist',function(){
    var ks = $(this).parent().parent().find('.polozkaKs').val()*1;
    var cena = $(this).parent().parent().find('.polozkaCena').val()*1;
    console.log(ks);
    console.log(cena);
    var celkem = ks*cena;
    $(this).parent().parent().find('.cenaPolozkyCelkem').html(celkem);
    $(this).parent().parent().find('.cenaPolozkyCelkemVal').val(celkem);
    var scot=0;
    $('.submitForm .cenaPolozkyCelkemVal').each(function(){
      scot+=parseFloat($(this).val());
    });
    $('#cenacelkem').val(scot);
  });

  $('.submitForm').on('change','input,textarea',function()
  {
    $('.submitForm').submit();
  });
  $('#ulozitButton').click(function(e){
    e.preventDefault();
    $('input[name=ulozit]').val('true');
    $('.submitForm').submit();
    $('input[name=ulozit]').val('false');

    var data = $('.submitForm').serialize();
    $.post('saveData.php', data,function(result){
      alert(result);
    });
  });
  $('#stahnoutButton').click(function(e){
      e.preventDefault();
      $('input[name=stahnout]').val('true');
      $('.submitForm').submit();
      $('input[name=stahnout]').val('false');
  });

});

</script>
</body>
</html>
