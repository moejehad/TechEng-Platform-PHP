<?php 

ob_start();

session_start();

$pageTitle = 'تواصل معنا';
 
include 'init.php';

include 'includes/templeats/nav.php';

/*
report();
*/

$formErrors = array();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
        $name     = $_POST['name'];
        $email    = $_POST['email'];
        $massage  = $_POST['massage'];
    


        if(empty($name)){

            $formErrors[] = 'يرجى كتابة اسمك';

        }

        if(empty($email)){

            $formErrors[] = 'يرجى كتابة بريدك الإلكتروني';

        }
    
        if(empty($massage)){

            $formErrors[] = 'يرجى كتابة الرسالة';

        }
    
        if(empty($formErros)){
                    
            $stmt = $con->prepare("INSERT INTO contact 
            (name,email, massage , date )
            VALUES(:zname, :zmail , :zmas , now() ) ");

            $stmt->execute(array(

                'zname'    => $name,
                'zmail'    => $email,
                'zmas'     => $massage

            ));

           $success = 'تم الارسال بنجاح ';
            
      }
    
}

?>

<section class="contact">
    <div class="container">
        <div class="row">
            
            <div class="col-md-1 hidden-xs hidden-sm"></div>
            <div class="col-xl-10 col-md-12">
                <div class="row">
                    <div class="contact-wrap col-lg-2 col-md-12">
                        <span>
                            <img src="layout/imgs/conversation.png" alt="Contact" />
                        </span>
                    </div>

                    <div class="contact-form col-lg-10 col-md-12">
                            <h3 class="title wow slideInUp" data-wow-delay="0.1s"> تواصل معنا </h3>
                            <h5 class="wow slideInUp" data-wow-delay="0.3s"> لديك أي استفسار ؟ هل تواجه بعض المشاكل ؟ يمكنك مراسلتنا في أي وقت تريد </h5>

                            <form action="contact" method="POST">
                                <div class="row">
                                    <div class="col-lg-6 col-md-12">
                                        <input class="form-control wow slideInUp" data-wow-delay="0.1s" type="text" name="name" placeholder="الاسم" required />
                                    </div>
                                    <div class="col-lg-6 col-md-12">
                                        <input class="form-control wow slideInUp" data-wow-delay="0.1s" type="email" name="email" placeholder="البريد الإلكتروني" required />
                                    </div>
                                    <div class="col-12">
                                        <textarea rows="5" class="form-control wow slideInUp" data-wow-delay="0.2s" name="massage" placeholder="الرسالة " required></textarea>
                                    </div>
                                </div>
                                <div class="but text-center">
                                    <input class="btn btn-primary form-control wow slideInUp" data-wow-delay="0.3s" type="submit" value="ارسال" />
                                </div>
                            </form>
                        
                        <?php 
                        if(isset($success)){
                            echo '<div class="alert alert-success">' . $success . '</div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-md-1 hidden-xs hidden-sm"></div>
        </div>
    </div>
</section>



<?php

include $tpl . 'footer.php';

ob_end_flush();

?>