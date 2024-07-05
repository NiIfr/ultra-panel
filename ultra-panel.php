<?php
/*
Plugin Name: Ultra Panel | اولترا پنل
Description: با اولترا وب محدودیت های وردپرس رو بشکن
Version: 1.0
Author: NilooFar VaFaei
Author URI: https://NilooFarVafaei.ir
*/


/* Copyright 2024  PLUGIN_AUTHOR_NAME (email : Miss.vafayi@gmail.com)

This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License

along with this program; if not, write to the Free Software

Foundation, Inc., ValieAsr St, Fifth Floor, Tehran ,6841224785 IRAN

*/




include plugin_dir_path(__FILE__) . 'settings-page.php';

// ایجاد منو در پنل پیشخوان
function caf_add_admin_menu() {
    add_menu_page(
        'Change Admin Font', // عنوان صفحه
        'اولترا پنل', // عنوان منو
        'manage_options', // قابلیت دسترسی
        'change-admin-font', // اسلاگ
        'caf_options_page', // تابع صفحه
        plugin_dir_url(__FILE__) . 'assets/image/icon.png' // آیکن منو
        ,
        4
    );
}
add_action('admin_menu', 'caf_add_admin_menu');


// ثبت تنظیمات
function caf_settings_init() {
    register_setting('caf_options_group', 'caf_options', 'caf_options_validate');

    add_settings_section(
        'caf_settings_section',
        __('تغییر فونت پنل پیشخوان', 'wordpress'),
        '',
        'change-admin-font'
    );

    add_settings_field(
        'caf_select_font',
        __('انتخاب فونت پنل', 'wordpress'),
        'caf_select_font_render',
        'change-admin-font',
        'caf_settings_section'
    );

    add_settings_field(
        'caf_select_bg_color',
        __('انتخاب رنگ پس زمینه', 'wordpress'),
        'caf_select_bg_color_render',
        'change-admin-font',
        'caf_settings_section'
    );
    add_settings_field(
        'caf_select_text_color',
        __('انتخاب رنگ دوم استایل', 'wordpress'),
        'caf_select_text_color_render',
        'change-admin-font',
        'caf_settings_section'
    );



    
}
add_action('admin_init', 'caf_settings_init');

// رندر کردن فیلد انتخاب فونت
function caf_select_font_render() {
    $options = get_option('caf_options');
    ?>
    <select name="caf_options[caf_select_font]">
        <option value="font1" <?php selected($options['caf_select_font'], 'font1'); ?>>فونت مربع</option>
        <option value="font2" <?php selected($options['caf_select_font'], 'font2'); ?>>فونت ایران یکان</option>
        <option value="font3" <?php selected($options['caf_select_font'], 'font3'); ?>>فونت میخک</option>
    </select>
    <?php
}

// رندر کردن فیلد انتخاب رنگ پس زمینه
function caf_select_bg_color_render() {
    $options = get_option('caf_options');
    ?>
    <input type="text" name="caf_options[caf_select_bg_color]" value="<?php echo isset($options['caf_select_bg_color']) ? esc_attr($options['caf_select_bg_color']) : '#ad59ad'; ?>" class="caf-color-field" />
    <?php
}

// رندر کردن فیلد انتخاب رنگ متن
function caf_select_text_color_render() {
    $options = get_option('caf_options');
    ?>
    <input type="text" name="caf_options[caf_select_text_color]" value="<?php echo isset($options['caf_select_text_color']) ? esc_attr($options['caf_select_text_color']) : '#611f61'; ?>" class="caf-color-field" />
    <?php
}





// بارگذاری استایل‌ها و اسکریپت‌ها
function caf_enqueue_admin_styles($hook_suffix) {
    $options = get_option('caf_options');
    $selected_font = isset($options['caf_select_font']) ? $options['caf_select_font'] : 'font1';
    $selected_bg_color = isset($options['caf_select_bg_color']) ? $options['caf_select_bg_color'] : '#ad59ad';
    $selected_text_color = isset($options['caf_select_text_color']) ? $options['caf_select_text_color'] : '#611f61';

    if ($selected_font == 'font1') {
        $font_url = plugins_url('fonts/font1.woff2', __FILE__);
    } elseif ($selected_font == 'font2') {
        $font_url = plugins_url('fonts/font2.woff2', __FILE__);
    } else {
        $font_url = plugins_url('fonts/font3.woff2', __FILE__);
    }

    wp_enqueue_style('caf-admin-style', plugins_url('ultra-style.css', __FILE__));
    wp_add_inline_style('caf-admin-style', ':root { --admin-bg-color: ' . esc_attr($selected_bg_color) . '; --admin-text-color: ' . esc_attr($selected_text_color) . '; }
     @font-face { font-family: "CustomAdminFont"; src: url("' . esc_url($font_url) . '") format("woff2"); font-weight: normal; font-style: normal; }');

    wp_enqueue_style('wp-color-picker');
    wp_enqueue_script('caf-script-handle', plugins_url('caf-script.js', __FILE__), array('wp-color-picker'), false, true);
}
add_action('admin_enqueue_scripts', 'caf_enqueue_admin_styles');





// شخصی‌سازی صفحه ورود
function caf_custom_login_styles() {
    $options = get_option('caf_options');
    $default_logo_url = plugins_url('assets/image/logo-w.png', __FILE__); // مسیر پیش‌فرض لوگو
    $default_bg_image_url = plugins_url('/assets/image/bg-main.jpg', __FILE__); // مسیر پیش‌فرض پس‌زمینه
    $logo_url = isset($options['caf_select_logo']) ? esc_url($options['caf_select_logo']) : $default_logo_url;
    $bg_image_url = isset($options['caf_select_bg_image']) ? esc_url($options['caf_select_bg_image']) : $default_bg_image_url;

    if ($options['caf_select_font'] == 'font1') {
        $font_url = plugins_url('fonts/font1.woff2', __FILE__);
    } elseif ($options['caf_select_font'] == 'font2') {
        $font_url = plugins_url('fonts/font2.woff2', __FILE__);
    } else {
        $font_url = plugins_url('fonts/font3.woff2', __FILE__);
    }

    wp_enqueue_style('caf-login-style', plugins_url('login-style.css', __FILE__));
    $custom_css = "
        @font-face {
            font-family: 'CustomAdminFont';
            src: url('{$font_url}') format('woff2');
            font-weight: normal;
            font-style: normal;
        }
        body.login {
            background-image: url('{$bg_image_url}');
            background-size: cover;
            background-position: center;
                
        }

        body.login .language-switcher{
         background-color: rgb(120 131 111 / 92%);
    border-radius: 12px;
    padding: 10px;
     border: 2px dashed #fff!important;
        }

       body.login .language-switcher .button {
            background-color: #2e3724;
            color:white;
    border-color: #2e3724;
        }
            body #login {
            background-color: rgb(120 131 111 / 92%);
    border-radius: 12px;
    padding: 0 10px;
    }
.login .message, .login .notice, .login .success {
    border-right:4px solid #68de7c;
    padding: 12px;
    margin-right: 0;
    margin-bottom: 20px;
    border-radius: 12px;
    background-color: #fff;
    box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
    word-wrap: break-word;
}
        .login.login-action-login.wp-core-ui{
            display: flex;
    justify-content: space-between;
    align-content: space-between;
    align-items: center;
        }

        #login #nav a, #login #backtoblog a{
        color:white;
        }
        .login h1 a {
            
     border: 2px dashed #fff!important;
     border-radius: 12px;
     margin-top:5px;
            background-image: url('{$logo_url}');
            background-size: contain;
            width: 320px;
            height: 84px;
        }
        .login form#loginform {
            background: rgb(120 131 111 / 82%);
    padding: 20px;
    border-radius: 10px;
    border: 2px dashed #fff!important;
        color: white;
    font-weight: 700;
    text-shadow: 2px 0px 4px #d4ebb4;
        }

        .login form .submit #wp-submit{
            background-color: #2e3724;
    border-color: #2e3724;
        }
        .login .button-primary {
            background: #0073aa;
            border-color: #006799;
            box-shadow: none;
            text-shadow: none;
        }
        body.login {
            font-family: 'CustomAdminFont', sans-serif !important;
        }
    ";
    wp_add_inline_style('caf-login-style', $custom_css);
}
add_action('login_enqueue_scripts', 'caf_custom_login_styles');


// بررسی نسخه وردپرس و نمایش پیام مناسب
function caf_check_wp_version() {
    global $wp_version;
    $required_wp_version = '5.0';

    if (version_compare($wp_version, $required_wp_version, '<')) {
        add_action('admin_notices', function() {
            echo '<div class="notice notice-error"><p>این پلاگین نیاز به نسخه 5.0 یا جدیدتر از وردپرس دارد. لطفاً وردپرس خود را به‌روزرسانی کنید.</p></div>';
        });
    }
}
add_action('admin_init', 'caf_check_wp_version');
