<?php
/**
 * @package artblamo_easy_form
 * @version 1.0
 */
/*
Plugin Name: Artblamo easy form
Plugin URI: https://art-blamo.ru
Description: <form class="form-inputs >
   * <input type="hidden" name="message[title]" value="Заявка на поиск товара">
    *<input type="hidden" name="fin" value="<span>Ваша заявка принята! Мы свяжимся с вами в ближайшее время!<span>">
    *<input type="hidden" name="message[test][title]" value="TEST">
    *<input type="text" name="message[test][val]">
    *<input type="submit" value="Отправить">
*</form>
Author: Artblamo
Version: 1.0
Author URI: https://art-blamo.ru
*/


add_action( 'wp_enqueue_scripts', 'theme_add_scripts' );
function theme_add_scripts() {
	wp_enqueue_script('send_m', '/artblamo_easy_form/send_m.js');
}