<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"/>
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="<?php echo $css;?>bootstrap.min.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo $css;?>style.css" type="text/css" />
    <link rel="icon" type="image/png" href="../layout/imgs/logo.png">
    <script src="https://kit.fontawesome.com/8dea92e7be.js"></script>
    
</head>
    
    <body>
<div class="wrapper">
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3>لوحة التحكم</h3>
            </div>            
            <ul class="navbar-nav list-unstyled components">
                <li class="nav-item">
                    <a class="nav-link" href="../admin/dashboard"><i class="fa fa-home"></i> لوحة التحكم </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../admin/members"><i class="fa fa-users"></i> الأعضاء </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../admin/courses"><i class="fa fa-video"></i> الكورسات </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../admin/events"><i class="fa fa-calendar"></i> الفعاليات </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../admin/blog"><i class="fa fa-blog"></i> المدونة </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../admin/sosiety"><i class="fa fa-question"></i> المجتمع </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../admin/contact"><i class="fa fa-at"></i> التواصل </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./setting"><i class="fa fa-cog"></i> الإعدادت </a>
                </li>
                
            </ul>
        </nav>
    
        <div id="content">
                <div class="navbar">
                    <a class="btn btn-light nav-link float-right" target="_blank" href="../index">زيارة المنصة <i class="fa fa-arrow-left"></i></a>
                    <a class="btn btn-light nav-link float-left" href="logout"> تسجيل خروج </a>
                </div>
              