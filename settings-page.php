<?php
// نمایش صفحه تنظیمات
function caf_options_page() {
    ?>

<div class="wpbody-content">
    <div class="top-info">
        <p>
            پلاگین کاربردی و بهینه اولترا پنل جهت راحتی کار طراحان و بالا بردن جذابیت کار با وردپرس با افتخار و احترام برای شما عزیزان طراحی شده است.
            برای اطلاع از آپدیت ها در شبکه های اجتماعی همراه ما باشید!
        </p>
        <ul>
            <li><a href="https://instagram.com/niloofarvafaei.ir/">اینستاگرام</a></li>
            <li><a href="https://t.me/niloofarvafaei">تلگرام</a></li>
            <li><a href="https://github.com/NiIfr">گیت هاب</a></li>
            <li><a href="https://niloofarvafaei.ir/">وب سایت</a></li>
            <li><a href="https://www.youtube.com/@Nillotus">یوتیوب</a></li>
            <li><a href="https://www.aparat.com/Nillotus">آپارات</a></li>
        </ul>
    </div>

    <div class="wrap">

    

        <div class="ultra-section">
        <h1><?php _e('Ultra Panel | اولترا پنل 🌷', 'wordpress'); ?></h1>
        <form action="options.php" method="post" enctype="multipart/form-data">
        
            <?php
            settings_fields('caf_options_group');
            do_settings_sections('change-admin-font');
            submit_button();
            ?>
        </form>


        
        <p style="text-align: end;">
            طراحی و پیاده سازی شده توسط 
            <a href="https://niloofarvafaei.ir">نیلوفر وفایی</a>
        </p>
        </div>
    </div>

    </div>
<?php
}
    ?>