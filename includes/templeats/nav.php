<header>
    
<nav class="navbar navbar-expand-lg navbar-light wow fadeIn" >
    <div class="container">
  <a class="navbar-brand" href="#"> <img src="./layout/imgs/TLogo.png" width="180" /> </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="index">الرئيسية</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="courses">كورسات</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="events">الفعاليات</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="society">المجتمع</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="blog">المدونة</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="contact">تواصل معنا</a>
      </li>
        <?php if(isset($_SESSION['user'])){ 
            $userID = $_SESSION['Uid'];
            $stmt1 = $con->prepare("SELECT * FROM users WHERE id LIKE '%$userID%' ");
            $stmt1->execute(array($userID));
            $userInfo = $stmt1->fetch();      
        ?>
        <div class="noti"><a class="noti" href="notification"> <span><?php echo countNotify('id', 'notifications' , 'receiver', $_SESSION['Uid']) ?></span><i class="fa fa-bell"></i> </a></div>
        <a href="member">
        <?php if(!empty($userInfo['photo'])){?>
        <div class="rounded-circle userImg" style="background: url('images/<?php echo $userInfo['photo']?>') center;background-size: cover;height: 40px;width: 40px;float: right;"></div>
        <?php }else { ?>
        <div class="rounded-circle userImg" style="background: url('layout/imgs/user.png') center;background-size: cover;height: 40px;width: 40px;float: right;"></div>
        <?php } ?>
        </a>
        <?php }else {?>
        <a href="login" class="login-link btn btn-info navbar-left"> دخول </a>
        <?php } ?>
    </ul>
  </div>
</div>
</nav>
</header>