<!DOCTYPE html>
<html lang="es">
<head><script>(function(w,i,g){w[g]=w[g]||[];if(typeof w[g].push=='function')w[g].push(i)})
(window,'GTM-WHH7CJ83','google_tags_first_party');</script><script>(function(w,d,s,l){w[l]=w[l]||[];(function(){w[l].push(arguments);})('set', 'developer_id.dYzg1YT', true);
		w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
		j=d.createElement(s);j.async=true;j.src='/wzrt/';
		f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer');</script>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Tabbed IFrames</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
<link rel="stylesheet" href="<?= base_url('assets/adminlte/plugins/fontawesome-free/css/all.min.css') ?>">  <!-- Theme style -->
<link rel="stylesheet" href="<?= base_url('assets/adminlte/dist/css/adminlte.min.css') ?>">  <!-- overlayScrollbars -->
<link rel="stylesheet" href="<?= base_url('assets/adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') ?>">
<script data-cfasync="false" nonce="6a45df40-64a5-4ec2-8649-9a137497b6fb">try{(function(w,d){!function(bH,bI,bJ,bK){if(bH.zaraz)console.error("zaraz is loaded twice");else{bH[bJ]=bH[bJ]||{};bH[bJ].executed=[];bH.zaraz={deferred:[],listeners:[]};bH.zaraz._v="5876";bH.zaraz._n="6a45df40-64a5-4ec2-8649-9a137497b6fb";bH.zaraz.q=[];bH.zaraz._f=function(bL){return async function(){var bM=Array.prototype.slice.call(arguments);bH.zaraz.q.push({m:bL,a:bM})}};for(const bN of["track","set","debug"])bH.zaraz[bN]=bH.zaraz._f(bN);bH.zaraz.init=()=>{var bO=bI.getElementsByTagName(bK)[0],bP=bI.createElement(bK),bQ=bI.getElementsByTagName("title")[0];bQ&&(bH[bJ].t=bI.getElementsByTagName("title")[0].text);bH[bJ].x=Math.random();bH[bJ].w=bH.screen.width;bH[bJ].h=bH.screen.height;bH[bJ].j=bH.innerHeight;bH[bJ].e=bH.innerWidth;bH[bJ].l=bH.location.href;bH[bJ].r=bI.referrer;bH[bJ].k=bH.screen.colorDepth;bH[bJ].n=bI.characterSet;bH[bJ].o=(new Date).getTimezoneOffset();if(bH.dataLayer)for(const bR of Object.entries(Object.entries(dataLayer).reduce((bS,bT)=>({...bS[1],...bT[1]}),{})))zaraz.set(bR[0],bR[1],{scope:"page"});bH[bJ].q=[];for(;bH.zaraz.q.length;){const bU=bH.zaraz.q.shift();bH[bJ].q.push(bU)}bP.defer=!0;for(const bV of[localStorage,sessionStorage])Object.keys(bV||{}).filter(bX=>bX.startsWith("_zaraz_")).forEach(bW=>{try{bH[bJ]["z_"+bW.slice(7)]=JSON.parse(bV.getItem(bW))}catch{bH[bJ]["z_"+bW.slice(7)]=bV.getItem(bW)}});bP.referrerPolicy="origin";bP.src="/cdn-cgi/zaraz/s.js?z="+btoa(encodeURIComponent(JSON.stringify(bH[bJ])));bO.parentNode.insertBefore(bP,bO)};["complete","interactive"].includes(bI.readyState)?zaraz.init():bH.addEventListener("DOMContentLoaded",zaraz.init)}}(w,d,"zarazData","script");window.zaraz._p=async bc=>new Promise(bd=>{if(bc){bc.e&&bc.e.forEach(be=>{try{const bf=d.querySelector("script[nonce]"),bg=bf?.nonce||bf?.getAttribute("nonce"),bh=d.createElement("script");bg&&(bh.nonce=bg);bh.innerHTML=be;bh.onload=()=>{d.head.removeChild(bh)};d.head.appendChild(bh)}catch(bi){console.error(`Error executing script: ${be}\n`,bi)}});Promise.allSettled((bc.f||[]).map(bj=>fetch(bj[0],bj[1])))}bd()});zaraz._p({"e":["(function(w,d){})(window,document)"]});})(window,document)}catch(e){throw fetch("/cdn-cgi/zaraz/t"),e;};</script>

<style>
    /* Estilo para el contenedor circular del icono */
    .user-icon-circle {
        width: 70px;           /* Ancho y alto iguales garantizan el círculo */
        height: 70px;
        background-color: #6c757d; /* Color de fondo gris (estilo AdminLTE) */
        border-radius: 50%;    /* Hace que sea un círculo perfecto */
        display: flex;
        align-items: center;   /* Centra el icono verticalmente */
        justify-content: center; /* Centra el icono horizontalmente */
        border: 2px solid #adb5bd;
        transition: all 0.3s ease;
    }

    /* Tamaño y color del icono */
    .user-icon-circle i {
        color: #ffffff;
        font-size: 30px;       /* Tamaño del icono dentro del círculo */
    }

    /* Efecto al pasar el mouse */
    .user-panel:hover .user-icon-circle {
        transform: scale(1.1);
        border-color: #ffffff;
        background-color: #495057; /* Se oscurece un poco al pasar el mouse */
    }

    /* Ajuste para que el nombre no se pegue al círculo */
    .user-panel .info a {
        color: #c2c7d0 !important;
        margin-top: 5px;
    }
</style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

   <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>

      
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          
        </a>
      
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
        
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
    
    </ul>
  </nav>

   <!-- Main Sidebar Container -->
 <aside class="main-sidebar sidebar-dark-primary elevation-4">
  <div class="sidebar">
  
  <div class="user-panel mt-3 pb-3 mb-3 d-flex flex-column align-items-center">
    <div class="image">
        <div class="user-icon-circle elevation-2">
            <i class="fas fa-user"></i>
        </div>
    </div>
    <div class="info mt-2 text-center">
        <a href="#" class="d-block font-weight-bold">
            <?= session()->get('nombre_usuario') ?? 'Nombre de Usuario' ?>
        </a>
        <span class="text-muted small">
            <i class="fas fa-circle text-success" style="font-size: 8px;"></i> En línea
        </span>
    </div>
</div>

  <nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column">
       <?= $this->renderSection('menu_options') ?>
    </ul>
  </nav>
</div>
</aside>

<div class="content-wrapper">
    <section class="content pt-3">
      <div class="container-fluid">
        <?= $this->renderSection('content') ?>
      </div>
    </section>
  </div>

<footer class="main-footer">
    <strong>Copyright &copy; 2026 Equipo Pasantías.</strong>
  </footer>
</div> <script src="<?= base_url('assets/adminlte/plugins/jquery/jquery.min.js') ?>"></script>
<script src="<?= base_url('assets/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('assets/adminlte/dist/js/adminlte.min.js') ?>"></script>
</body>


</html>