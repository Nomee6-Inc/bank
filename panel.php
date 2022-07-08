<?php
session_start();
include_once 'config.php';
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
} else {
$result = mysqli_query($conn,"SELECT * FROM employee");
$getusername = $_SESSION['username'];
$getaccid = $_SESSION['accid'];
$query = mysqli_query($conn,"SELECT * FROM users WHERE baccid = '$getaccid'");
$result = $query->fetch_assoc();
$money = $result['money'];
$cardid = $result['cardid'];
$dolar = $result['dolar'];

$cardidarray = explode(",", $cardid);

if (isset($_POST['newcard'])) {
$newcardid = rand("10000", "99999");
if($cardid == "") {
    $newcardsarray = $newcardid;
} else {
    $newcardsarray = "$cardid,$newcardid";
}

$randcardnumber = rand(1000, 9999) . rand(1000, 9999) . rand(1000, 9999) . rand(1000, 9999);
$randcardcvv = rand(001, 999);
$randcardend = rand(01, 12) . "/" . rand(22, 30);
$createiban = "NM" . rand("10000", "99999") . rand("10000", "99999") . rand("10000", "99999") . rand("10000", "99999");

$sql1 = "INSERT INTO cards (cardid, cardnumber, cvv, end, money, owner, iban)
			VALUES ('$newcardid', '$randcardnumber', '$randcardcvv', '$randcardend', '0', '$getusername', '$createiban')";
$query1 = mysqli_query($conn, $sql1);

$sql2 = "UPDATE users SET cardid = '$newcardsarray' WHERE baccid = '$getaccid'";
$query2 = mysqli_query($conn, $sql2);
if($query1 && $query2) {
    header("Refresh:0");
    echo "Başarılı!";
} else {
    echo "Bir hata oluştu!";
}
};
}
?>

<!doctype html>
<html lang="tr">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>NOMEE6 BANK</title>
    <!-- CSS files -->
    <link href="https://devlet.nomee6.xyz/dist/css/tabler.min.css" rel="stylesheet"/>
    <link href="https://devlet.nomee6.xyz/dist/css/tabler-flags.min.css" rel="stylesheet"/>
    <link href="https://devlet.nomee6.xyz/dist/css/tabler-payments.min.css" rel="stylesheet"/>
    <link href="https://devlet.nomee6.xyz/dist/css/tabler-vendors.min.css" rel="stylesheet"/>
    <link href="https://devlet.nomee6.xyz/dist/css/demo.min.css" rel="stylesheet"/>
    <meta property="og:title" content="NOMEE6 BANK" />
    <meta property="og:url" content="https://bank.nomee6.xyz" />
    <meta property="og:image" content="https://nomee6.xyz/assets/A.png" />
    <meta property="og:description" content="E-Devlette ki eski klasik banka sistemi yeni modern ve gelişmiş bir sisteme taşındı." />
	<?php 
	$username = $_SESSION['username'];
	echo("
	<!-- Matomo -->
	  <script>
		var _paq = window._paq = window._paq || [];
		_paq.push(['trackPageView']);
		_paq.push(['enableLinkTracking']);
		_paq.push(['setUserId', '$username']);
		_paq.push(['enableHeartBeatTimer']);
		(function() {
			var u=\"https://matomo.aliyasin.org/\";
		  _paq.push(['setTrackerUrl', u+'matomo.php']);
		  _paq.push(['setSiteId', '16']);
		  var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
		  g.async=true; g.src=u+'matomo.js'; s.parentNode.insertBefore(g,s);
		})();
	  </script>
	  <!-- End Matomo Code -->
	");
	?>
	<style>
  .payment-title {
      width: 100%;
      text-align: center;
  }
  
  .form-container .field-container:first-of-type {
      grid-area: name;
  }
  
  .form-container .field-container:nth-of-type(2) {
      grid-area: number;
  }
  
  .form-container .field-container:nth-of-type(3) {
      grid-area: expiration;
  }
  
  .form-container .field-container:nth-of-type(4) {
      grid-area: security;
  }
  
  .field-container input {
      -webkit-box-sizing: border-box;
      box-sizing: border-box;
  }
  
  .field-container {
      position: relative;
  }
  
  .form-container {
      display: grid;
      grid-column-gap: 10px;
      grid-template-columns: auto auto;
      grid-template-rows: 90px 90px 90px;
      grid-template-areas: "name name""number number""expiration security";
      max-width: 400px;
      padding: 20px;
      color: #707070;
  }
  
  label {
      padding-bottom: 5px;
      font-size: 13px;
  }
  
  input {
      margin-top: 3px;
      padding: 15px;
      font-size: 16px;
      width: 100%;
      border-radius: 3px;
      border: 1px solid #dcdcdc;
  }
  
  .ccicon {
      height: 38px;
      position: absolute;
      right: 6px;
      top: calc(50% - 17px);
      width: 60px;
  }
  
  .preload * {
      -webkit-transition: none !important;
      -moz-transition: none !important;
      -ms-transition: none !important;
      -o-transition: none !important;
  }
  
  .container {
      width: 100%;
      max-width: 400px;
      max-height: 251px;
      height: 54vw;
      padding: 20px;
  }
  
  #ccsingle {
      position: absolute;
      right: 15px;
      top: 20px;
  }
  
  #ccsingle svg {
      width: 100px;
      max-height: 60px;
  }
  
  .creditcard svg#cardfront,
  .creditcard svg#cardback {
      width: 100%;
      -webkit-box-shadow: 1px 5px 6px 0px black;
      box-shadow: 1px 5px 6px 0px black;
      border-radius: 22px;
  }
  
  #generatecard{
      cursor: pointer;
      float: right;
      font-size: 12px;
      color: #fff;
      padding: 2px 4px;
      background-color: #909090;
      border-radius: 4px;
      cursor: pointer;
      float:right;
  }
  
  .creditcard .lightcolor,
  .creditcard .darkcolor {
      -webkit-transition: fill .5s;
      transition: fill .5s;
  }
  
  .creditcard .lightblue {
      fill: #03A9F4;
  }
  
  .creditcard .lightbluedark {
      fill: #0288D1;
  }
  
  .creditcard .red {
      fill: #ef5350;
  }
  
  .creditcard .reddark {
      fill: #d32f2f;
  }
  
  .creditcard .purple {
      fill: #ab47bc;
  }
  
  .creditcard .purpledark {
      fill: #7b1fa2;
  }
  
  .creditcard .cyan {
      fill: #26c6da;
  }
  
  .creditcard .cyandark {
      fill: #0097a7;
  }
  
  .creditcard .green {
      fill: #66bb6a;
  }
  
  .creditcard .greendark {
      fill: #388e3c;
  }
  
  .creditcard .lime {
      fill: #d4e157;
  }
  
  .creditcard .limedark {
      fill: #afb42b;
  }
  
  .creditcard .yellow {
      fill: #ffeb3b;
  }
  
  .creditcard .yellowdark {
      fill: #f9a825;
  }
  
  .creditcard .orange {
      fill: #ff9800;
  }
  
  .creditcard .orangedark {
      fill: #ef6c00;
  }
  
  .creditcard .grey {
      fill: #bdbdbd;
  }
  
  .creditcard .greydark {
      fill: #616161;
  }
  
  /* FRONT OF CARD */
  #svgname {
      text-transform: uppercase;
  }
  
  #cardfront .st2 {
      fill: #FFFFFF;
  }
  
  #cardfront .st3 {
      font-family: 'Source Code Pro', monospace;
      font-weight: 600;
  }
  
  #cardfront .st4 {
      font-size: 54.7817px;
  }
  
  #cardfront .st5 {
      font-family: 'Source Code Pro', monospace;
      font-weight: 400;
  }
  
  #cardfront .st6 {
      font-size: 33.1112px;
  }
  
  #cardfront .st7 {
      opacity: 0.6;
      fill: #FFFFFF;
  }
  
  #cardfront .st8 {
      font-size: 24px;
  }
  
  #cardfront .st9 {
      font-size: 36.5498px;
  }
  
  #cardfront .st10 {
      font-family: 'Source Code Pro', monospace;
      font-weight: 300;
  }
  
  #cardfront .st11 {
      font-size: 16.1716px;
  }
  
  #cardfront .st12 {
      fill: #4C4C4C;
  }
  
  #cardback .st0 {
      fill: none;
      stroke: #0F0F0F;
      stroke-miterlimit: 10;
  }
  
  #cardback .st2 {
      fill: #111111;
  }
  
  #cardback .st3 {
      fill: #F2F2F2;
  }
  
  #cardback .st4 {
      fill: #D8D2DB;
  }
  
  #cardback .st5 {
      fill: #C4C4C4;
  }
  
  #cardback .st6 {
      font-family: 'Source Code Pro', monospace;
      font-weight: 400;
  }
  
  #cardback .st7 {
      font-size: 27px;
  }
  
  #cardback .st8 {
      opacity: 0.6;
  }
  
  #cardback .st9 {
      fill: #FFFFFF;
  }
  
  #cardback .st10 {
      font-size: 24px;
  }
  
  #cardback .st11 {
      fill: #EAEAEA;
  }
  
  #cardback .st12 {
      font-family: 'Rock Salt', cursive;
  }
  
  #cardback .st13 {
      font-size: 37.769px;
  }
  
  .container {
      perspective: 1000px;
  }
  
  .creditcard {
      width: 100%;
      max-width: 400px;
      -webkit-transform-style: preserve-3d;
      transform-style: preserve-3d;
      transition: -webkit-transform 0.6s;
      -webkit-transition: -webkit-transform 0.6s;
      transition: transform 0.6s;
      transition: transform 0.6s, -webkit-transform 0.6s;
      cursor: pointer;
  }
  
  .creditcard .front,
  .creditcard .back {
      position: absolute;
      width: 100%;
      max-width: 400px;
      -webkit-backface-visibility: hidden;
      backface-visibility: hidden;
      -webkit-font-smoothing: antialiased;
      color: #47525d;
  }
  
  .creditcard .back {
      -webkit-transform: rotateY(180deg);
      transform: rotateY(180deg);
  }
  
  .creditcard.flipped {
      -webkit-transform: rotateY(180deg);
      transform: rotateY(180deg);
  }
  </style>
  </head>
  <body>
    <div class="wrapper">
      <header class="navbar navbar-expand-md navbar-light d-print-none">
        <div class="container-xl">
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
            <span class="navbar-toggler-icon"></span>
          </button>
          <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
            <a href=".">
              <img src="https://devlet.nomee6.xyz/static/logo.svg" width="150" height="35" alt="banka" class="navbar-brand-image">
            </a>
          </h1>
          <div class="navbar-nav flex-row order-md-last">
            <div class="nav-item d-none d-md-flex me-3">
              <div class="btn-list">
              </div>
            </div>
            <a href="?theme=dark" class="nav-link px-0 hide-theme-dark" title="Koyu Temayı Etkinleştir" data-bs-toggle="tooltip" data-bs-placement="bottom">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z" /></svg>
            </a>
            <a href="?theme=light" class="nav-link px-0 hide-theme-light" title="Açık Temayı Etkinleştir" data-bs-toggle="tooltip" data-bs-placement="bottom">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="4" /><path d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7" /></svg>
            </a>
            <div class="nav-item dropdown">
              <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                <div class="d-none d-xl-block ps-2">
                  <div><?php echo($_SESSION['username']) ?></div>
                </div>
              </a>
              <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
              <a href="logout.php" class="dropdown-item">Çıkış Yap</a>
              </div>
            </div>
          </div>
        </div>
      </header>
      <div class="navbar-expand-md">
        <div class="collapse navbar-collapse" id="navbar-menu">
          <div class="navbar navbar-light">
            <div class="container-xl">
              <ul class="navbar-nav">
                <li class="nav-item active">
                  <a class="nav-link" href="panel.php" >
                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="5 12 3 12 12 3 21 12 19 12" /><path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" /><path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" /></svg>
                    </span>
                    <span class="nav-link-title">
                      Kartlarım
                    </span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="exchange.php" >
                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-currency-dollar" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M16.7 8a3 3 0 0 0 -2.7 -2h-4a3 3 0 0 0 0 6h4a3 3 0 0 1 0 6h-4a3 3 0 0 1 -2.7 -2"></path>
                        <path d="M12 3v3m0 12v3"></path>
                      </svg>
                    </span>
                    <span class="nav-link-title">
                      Döviz
                    </span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="transfer_iban.php" >
                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-transfer-in" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M4 18v3h16v-14l-8 -4l-8 4v3"></path>
                        <path d="M4 14h9"></path>
                        <path d="M10 11l3 3l-3 3"></path>
                      </svg>
                    </span>
                    <span class="nav-link-title">
                      IBAN Para Transferi
                    </span>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="page-wrapper">
        <div class="container-xl">
          <div class="page-header d-print-none">
            <div class="row align-items-center">
              <div class="col">
                <h2 class="page-title">
                  Kartlarım
                </h2>
              </div>
            </div>
          </div>
        </div>
        <div class="page-body">
          <div class="container-xl">
              <div class="col-sm-6 col-lg-3">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex align-items-center">
                      <div class="subheader">Cüzdan</div>
                      <div class="ms-auto lh-1">
                      </div>
                    </div>
                    <div class="d-flex align-items-baseline">
                      <div class="h1 mb-0 me-2">₺<?php
                        if($money == "") {
                            $money = "0";
                        }
                        echo $money;
                        ?>
                        </div>
                      <div class="me-auto">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <br>
            <div class="row">
              <div class="col-md-6">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Kartlarım:</h3>
                  </div>
                  <div class="card-body">
                    <div id="carousel-captions" class="carousel slide" data-bs-ride="carousel">
                      <div class="carousel-inner">
                    <div class="carousel-item active" style="text-align:center;">
                        <form enctype="multipart/form-data" action="" method="POST">
                        <button name="newcard" type="submit" class="btn btn-primary" style="text-align:center;">Yeni Kart Oluştur</button>
                        </form>
                    </div>
                    <?php
                        foreach($cardidarray as $array) {
                            $query1 = mysqli_query($conn, "SELECT * FROM cards WHERE cardid = '$array'");
                            $result1 = $query1->fetch_assoc();
                            $cardowner = $result1['owner'];
                            $cardnumber = $result1['cardnumber'];
                            $cardexpiredate = $result1['end'];
                            $cardcvv = $result1['cvv'];
                            $cardmoney = $result1['money'];
                            $cardiban = $result1['iban'];
                            
                            echo "<div class=\"carousel-item\">
                          <div class=\"container preload\">
                            <div class=\"creditcard\">
                                <div class=\"front\">
                                    <div id=\"ccsingle\"></div>
                                    <svg version=\"1.1\" id=\"cardfront\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\"
                                        x=\"0px\" y=\"0px\" viewBox=\"0 0 750 471\" style=\"enable-background:new 0 0 750 471;\" xml:space=\"preserve\">
                                        <g id=\"Front\">
                                            <g id=\"CardBackground\">
                                                <g id=\"Page-1_1_\">
                                                    <g id=\"amex_1_\">
                                                        <path id=\"Rectangle-1_1_\" class=\"lightcolor grey\" d=\"M40,0h670c22.1,0,40,17.9,40,40v391c0,22.1-17.9,40-40,40H40c-22.1,0-40-17.9-40-40V40
                                                C0,17.9,17.9,0,40,0z\" />
                                                    </g>
                                                </g>
                                                <path class=\"darkcolor greydark\" d=\"M750,431V193.2c-217.6-57.5-556.4-13.5-750,24.9V431c0,22.1,17.9,40,40,40h670C732.1,471,750,453.1,750,431z\" />
                                            </g>
                                            <text transform=\"matrix(1 0 0 1 60.106 295.0121)\" id=\"svgnumber\" class=\"st2 st3 st4\">$cardnumber</text>
                                            <text transform=\"matrix(1 0 0 1 54.1064 428.1723)\" id=\"svgname\" class=\"st2 st5 st6\">$cardowner</text>
                                            <text transform=\"matrix(1 0 0 1 54.1074 389.8793)\" class=\"st7 st5 st8\">Kart Sahibi</text>
                                            <text transform=\"matrix(1 0 0 1 479.7754 388.8793)\" class=\"st7 st5 st8\">Bitiş Tarihi</text>
                                            <text transform=\"matrix(1 0 0 1 65.1054 241.5)\" class=\"st7 st5 st8\">Kart Numarası</text>
                                            <g>
                                                <text transform=\"matrix(1 0 0 1 574.4219 433.8095)\" id=\"svgexpire\" class=\"st2 st5 st9\">$cardexpiredate</text>
                                                <text transform=\"matrix(1 0 0 1 479.3848 417.0097)\" class=\"st2 st10 st11\">VALID</text>
                                                <text transform=\"matrix(1 0 0 1 479.3848 435.6762)\" class=\"st2 st10 st11\">THRU</text>
                                                <polygon class=\"st2\" points=\"554.5,421 540.4,414.2 540.4,427.9    \" />
                                            </g>
                                            <g id=\"cchip\">
                                                <g>
                                                    <path class=\"st2\" d=\"M168.1,143.6H82.9c-10.2,0-18.5-8.3-18.5-18.5V74.9c0-10.2,8.3-18.5,18.5-18.5h85.3
                                            c10.2,0,18.5,8.3,18.5,18.5v50.2C186.6,135.3,178.3,143.6,168.1,143.6z\" />
                                                </g>
                                                <g>
                                                    <g>
                                                        <rect x=\"82\" y=\"70\" class=\"st12\" width=\"1.5\" height=\"60\" />
                                                    </g>
                                                    <g>
                                                        <rect x=\"167.4\" y=\"70\" class=\"st12\" width=\"1.5\" height=\"60\" />
                                                    </g>
                                                    <g>
                                                        <path class=\"st12\" d=\"M125.5,130.8c-10.2,0-18.5-8.3-18.5-18.5c0-4.6,1.7-8.9,4.7-12.3c-3-3.4-4.7-7.7-4.7-12.3
                                                c0-10.2,8.3-18.5,18.5-18.5s18.5,8.3,18.5,18.5c0,4.6-1.7,8.9-4.7,12.3c3,3.4,4.7,7.7,4.7,12.3
                                                C143.9,122.5,135.7,130.8,125.5,130.8z M125.5,70.8c-9.3,0-16.9,7.6-16.9,16.9c0,4.4,1.7,8.6,4.8,11.8l0.5,0.5l-0.5,0.5
                                                c-3.1,3.2-4.8,7.4-4.8,11.8c0,9.3,7.6,16.9,16.9,16.9s16.9-7.6,16.9-16.9c0-4.4-1.7-8.6-4.8-11.8l-0.5-0.5l0.5-0.5
                                                c3.1-3.2,4.8-7.4,4.8-11.8C142.4,78.4,134.8,70.8,125.5,70.8z\" />
                                                    </g>
                                                    <g>
                                                        <rect x=\"82.8\" y=\"82.1\" class=\"st12\" width=\"25.8\" height=\"1.5\" />
                                                    </g>
                                                    <g>
                                                        <rect x=\"82.8\" y=\"117.9\" class=\"st12\" width=\"26.1\" height=\"1.5\" />
                                                    </g>
                                                    <g>
                                                        <rect x=\"142.4\" y=\"82.1\" class=\"st12\" width=\"25.8\" height=\"1.5\" />
                                                    </g>
                                                    <g>
                                                        <rect x=\"142\" y=\"117.9\" class=\"st12\" width=\"26.2\" height=\"1.5\" />
                                                    </g>
                                                </g>
                                            </g>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class=\"carousel-item-background d-none d-md-block\"></div>
                        <div class=\"card-body\">
                            <div class=\"card-title\">Kart Bilgileri</div>
                            <p>
                              Kart Sahibi: $cardowner <br>
                              Kart Numarası: $cardnumber <br>
                              Kart Bitiş Tarihi: $cardexpiredate <br>
                              Kart CVV: $cardcvv <br>
                              IBAN: $cardiban <br>
                              Kartta bulunan Para Miktarı: ₺$cardmoney
                            </p>
                          </div>
                          <div class=\"card-footer\">
                          <br>
                            <div class=\"card-title\">İşlemler</div>
                            <div class=\"col-6 col-sm-4 col-md-2 col-xl mb-3\" style=\"text-align:center;\">
                                <a href=\"delete-card.php?cardid=$array\" class=\"btn btn-danger w-100\" style=\"text-align:center;\">
                                  Kartı Sil
                                </a>
                            </div>
                            <div class=\"col-6 col-sm-4 col-md-2 col-xl mb-3\" style=\"text-align:center;\">
                                <a href=\"add-money.php?cardid=$array\" class=\"btn btn-blue w-100\" style=\"text-align:center;\">
                                  Para Yükle
                                </a>
                            </div>
                            <div class=\"col-6 col-sm-4 col-md-2 col-xl mb-3\" style=\"text-align:center;\">
                                <a href=\"withdraw-money.php?cardid=$array\" class=\"btn btn-blue w-100\" style=\"text-align:center;\">
                                  Para Çek
                                </a>
                            </div>
                          </div>
                        </div>";
                        }
                    ?>
                      <a class="carousel-control-prev" href="#carousel-captions" role="button" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Geri</span>
                      </a>
                      <a class="carousel-control-next" href="#carousel-captions" role="button" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">İleri</span>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <footer class="footer footer-transparent d-print-none">
          <div class="container-xl">
            <div class="row text-center align-items-center flex-row-reverse">
              <div class="col-lg-auto ms-lg-auto">
                <ul class="list-inline list-inline-dots mb-0">
                  </li>
                </ul>
              </div>
              <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                <ul class="list-inline list-inline-dots mb-0">
                  <li class="list-inline-item">
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </footer>
      </div>
    </div>
    <!-- Libs JS -->
    <script src="https://devlet.nomee6.xyz/dist/libs/apexcharts/dist/apexcharts.min.js"></script>
    <!-- Tabler Core -->
    <script src="https://devlet.nomee6.xyz/dist/js/tabler.min.js"></script>
    <script src="https://devlet.nomee6.xyz/dist/js/demo.min.js"></script>
  </body>
</html>
