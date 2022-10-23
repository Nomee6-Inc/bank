<?php

if(strstr($_SERVER['HTTP_USER_AGENT'], "Nomee6 Bank Android Client")) { 
	header("Location: panel");
}

include_once 'config.php';
include 'api/SessionHandler.php';
$getsessioncookie = $_COOKIE['sess_id'];
if(sess_verify($getsessioncookie) == 1) {
$get_user_unique_id = get_sess_user($getsessioncookie);

$query = $db->query("SELECT * FROM users WHERE user_id = '{$get_user_unique_id}'",PDO::FETCH_ASSOC);
$dataquery = $query->fetch(PDO::FETCH_ASSOC);
$getusername = $dataquery['username'];
$getuserrole = $dataquery['role'];
$getusermoney = $dataquery['money'];
$getuserdolar = $dataquery['dolar'];
  
$get__user_sess_login_button = "<i class=\"fa-solid fa-user\"></i>  $getusername";
$get__user_sess_login_button__url = "panel";
$get__user_sess_register_button = "Paneli Aç";
} else {
  $get__user_sess_login_button = "Giriş Yap";
  $get__user_sess_login_button__url = "login";
  $get__user_sess_register_button = "Kayıt Ol";
}
?>

<!doctype html>
<html lang="tr">

<head>
<title>Nomee6 Bank</title>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="assets/css/owl.carousel.min.css" />
<link rel="stylesheet" href="assets/css/owl.carousel.css" />
<link rel="icon" href="https://nomee6.xyz/assets/pp.png">
<meta property="og:title" content="NOMEE6 BANK" />
<meta property="og:url" content="https://bank.nomee6.xyz" />
<meta property="og:image" content="https://nomee6.xyz/assets/pp.png" />
<meta property="og:description" content="E-Devlette ki eski klasik banka sistemi yeni modern ve gelimi bir sisteme taşındı." />
<link rel="stylesheet" href="style.responsive.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"/>
<body>
<div class="header-area wow fadeInDown header-absolate" id="nav" data-0="position:fixed;" data-top-top="position:fixed;top:0;" data-edge-strategy="set">
<div class="container">
<div class="row">
<div class="col-4 d-block d-lg-none">
<div class="mobile-menu"></div>
</div>
<div class="col-4 col-lg-2">
<div class="logo-area">
<a href="#"><img src="https://nomee6.xyz/assets/pp.png" alt=""></a>
</div>
</div>
<div class="col-4 col-lg-8 d-none d-lg-block">
<div class="main-menu text-center">
<nav>
<ul id="slick-nav">
<li><a class="scroll" href="#home">Ana Sayfa</a>
</li>
<li><a class="scroll" href="#about">Hakkımızda</a>
</li>
<li><a class="scroll" href="#team">Ekip</a></li>
<li><a class="scroll" href="#apps">Uygulama</a></li>
<li><a class="scroll" href="#contact">İletişim</a></li>
</ul>
</nav>
</div>
</div>
<div class="col-4 col-lg-2 text-right">
<a href="<?php echo $get__user_sess_login_button__url; ?>" class="logibtn gradient-btn"><?php echo $get__user_sess_login_button; ?></a>
</div>
</div>
</div>
</div>


<div class="welcome-area wow fadeInUp" id="home">
<div id="particles-js"></div>
<div class="container">
<div class="row">
<div class="col-12 col-md-6 align-self-center">
<div class="welcome-right">
<div class="welcome-text">
<h1>Yenilikçi Banka sistemimiz
ile rahat ve güvenli alışveriş yapın!</h1>
<h4>Bu web sitesi tamamen mizah amaçlıdır ve gerçek para birimleriyle herhangi bir ilişkisi bulunmamaktadır.</h4>
</div>
<div class="welcome-btn">
<a href="<?php echo $get__user_sess_login_button__url; ?>" class="gradient-btn v2 mr-20"><?php echo $get__user_sess_register_button; ?></a>
</div>
</div>
</div>
<div class="col-12 col-md-6">
<div class="welcome-img">
<img src="assets/img/welcomeimg.png" alt="">
</div>
</div>
</div>
</div>
</div>


<div class="about-area wow fadeInUp" id="about">
<div class="space-30"></div>
<div class="container">
<div class="row">
<div class="space-90"></div>
<div class="row">
<div class="col-12 col-md-6">
<div class="about-mid-img">
<img src="assets/img/about.png" alt="">
</div>
</div>
<div class="col-12 col-md-6 align-self-center">
<div class="heading">
<h5>Hakkımızda</h5>
</div>
<div class="about-mid-text">
<h1>Güçlü Altyapı Yeni nesil teknolojiler sizlerle!</h1>
<div class="space-10"></div>
<p>Nomee6 Inc. olarak 2020 yılından beridir eğlence sektöründe bir çok yatırımda bulunduk. Birçok alanda yeni nesil araçları kullanarak kullanıcı deneyimini en üst düzeyde tuttuk. %99 Uptime garantimiz ve son derece düşük gecikmeli API performansımız için bizi tercih etmelisiniz. Nomee6 Bank üzerinde ödeme alma, 3D Secure aracılığıyla ödeme alma gibi bir çok API opsiyonu sunuyoruz.</p>
</div>
<div class="space-30"></div>
<a href="developer/" class="gradient-btn v2 about-btn"> <i class="fas fa-code"></i> geliştirici konsolu</a>
</div>
</div>
</div>
</div>

<div class="team-bg">

<div class="team-area wow fadeInUp section-padding" id="team">
<div class="container">
<div class="row">
<div class="col-12 text-center">
<div class="heading">
<h5>EKİP</h5>
<div class="space-10"></div>
</div>
<div class="space-60"></div>
</div>
</div>
<div class="row text-center">
<div class="col-12 col-md-6 col-lg-3">
<div class="single-team">
<div class="single-team-img">
<img src="https://nomee6.xyz/assets/yakkl.jpg" alt="">
</div>
<div class="space-30"></div>
<div class="single-team-content">
<h3>Ali Yasin Yeşilyaprak</h3>
<div class="space-10"></div>
<h6>KURUCU & CEO</h6>
</div>
<div class="space-10"></div>
<div class="single-team-social">
<ul>
<li><a class="ico-1" href="https://twitter.com/aliyasiny65"><i class="fab fa-twitter"></i></a></li>
<li><a class="ico-2" href="https://github.com/aliyasiny65"><i class="fab fa-github"></i></a></li>
</ul>
</div>
</div>
</div>
</div>
</div>
<div class="space-30"></div>
</div>


<div class="apps-area wow fadeInUp section-padding" id="apps">
<div class="container">
<div class="row">
<div class="col-12 col-lg-5 offset-1 align-self-center">
<div class="heading">
<h5>MOBIL UYGULAMA</h5>
<div class="space-10"></div>
<h1>Mobil Üzerinden uygulamamıza erişebilirsiniz!</h1>
<div class="space-20"></div>
<p>Bütün bilgilerinize mobil uygulamamız üzerinden erişebilir, Nomee6 Bank ile internet alışverişi yaparken 3D Secure kod bildirimlerinizi telefonunuza alabilirsiniz.</p>
</div>
<div class="space-30"></div>
<a href="cdn/nomee6-bank-v1.0.apk" class="gradient-btn apps-btn"> <i class="fas fa-download"></i>APK İndir</a>
</div>
<div class="col-12 col-lg-5 offset-1">
<div class="apps-img">
<img src="assets/img/mobileapp.png" alt="">
</div>
</div>
</div>
</div>
</div>

</div>

</div>


<div class="community-area wow" id="contact">
<div class="container">
<div class="row">
<div class="col-12 text-center">
<div class="heading">
<div class="space-10"></div>
<h1>İletişim </h1>
</div>
<div class="space-60"></div>
</div>
</div>
<div class="row">
<div class="col-6 col-lg">
<div class="single-community">
<a class="github" href="https://github.com/Nomee6-Inc"><i class="fab fa-github"></i></a>
</div>
<div class="single-community">
<a class="email" href="mailto:torbacihuseyin@nomee6.xyz"><i class="fas fa-envelope"></i></a>
</div>
</div>
<div class="col-6 col-lg">
<div class="single-community mid-social">
<a class="twitter" href="https://twitter.com/Nomee6Inc"><i class="fab fa-twitter"></i></a>
</div>
</div>
</div>
</div>
</div>


<script src="assets/js/jquery-2.2.4.min.js"></script>

<script src="assets/js/popper.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/particles.min.js"></script>
</body>
</html>
