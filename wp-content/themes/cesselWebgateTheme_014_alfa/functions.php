<?php

/* Команда консоли для выгрузки дампа базы данных: "mysqldump -u cessel -p c9 > dump.sql" */
/* Команда консоли для установки PhpMyAdmin phpmyadmin-ctl install */

define('CES_IMG',get_template_directory_uri()."/img");

/* АВТОМАТИЧЕСКОЕ ПОДКЛЮЧЕНИЕ JS И CSS ФАЙЛОВ ИЗ ПАПКИ /js/ и /css/ СООТВЕТСТВЕННО */

function CWG_scripts()
	{
		$dir_js = get_template_directory().'/js/';
		$dir_css = get_template_directory().'/css/';
		$js_files=scandir($dir_js);
		$css_files=scandir($dir_css);
		$i=0;
		foreach ($js_files as $js)
			{
				$extension = explode('.',$js);
				if($extension[count($extension)-1]=='js')
					{
						wp_enqueue_script('script'.$i++, get_template_directory_uri() . '/js/' . $js);
					}
				
			}
			$i=0;
		foreach ($css_files as $css)
			{
				$extension = explode('.',$css);
				if($extension[count($extension)-1]=='css')
					{
						wp_enqueue_style('style'.$i++, get_template_directory_uri() . '/css/' . $css);
					}
			}
	}
add_action( 'wp_enqueue_scripts', 'CWG_scripts' );
	
	
	
function modal_toggle_link($link_text,$id_modal,$link_class='btn btn-default')
	{
		echo '<a href="'.$id_modal.'" data-toggle="modal" data-target="'.$id_modal.'" class="'.$link_class.'">'.$link_text.'</a>';
	}
function get_sitedata($varname)
	{
		$page = get_page_by_title('Главная');
		return get_metadata('post',$page->ID, $varname, true);
		
	}
 function get_sitedata_dy_page_id($varname,$id)
	{
		$page = get_post( $id );
		return get_metadata('post',$page->ID, $varname, true);
		
	}
function remove_opensans_font()
	{
			
	}
function add_responsive_class($string,$class='')
	{
		if (($string!='')&&($class!=''))
			{
				$class=str_replace(' ','-',$class); 
				$dim = array('lg','md','sm','xs');
				$class_insert=$class;
				
				$string=trim($string);
				$string=str_replace("\"",'\'',$string);
				$classpos=strpos($string,'class');
				$taglenght=strpos($string,' ');
				if (!$classpos&&!$taglenght)
					{
						$endtaglenght=strpos($string,'>');
						$return_string = '';
						foreach($dim as $d)
							{
								$return_string .= substr_replace($string," class='".$class." ".$class."-".$d." visible-".$d."' >",$endtaglenght,1);
							}
					}
				else if ($classpos)
					{
						$return_string = '';
						foreach($dim as $d)
							{
								$return_string .= substr_replace($string,"'".$class." ".$class."-".$d." visible-".$d." ",$classpos+strlen('class="')-1,1)."\n";
							}
					}
				else if ($taglenght)
					{
						$return_string = '';
						foreach($dim as $d)
							{
								$return_string .= substr_replace($string," class='".$class." ".$class."-".$d." visible-".$d."' ",$taglenght,1);
							}

					}
					
				return $return_string;
			}
		else
			{
				return false;
			}
	}


function list_hooked_functions($tag=false){
 global $wp_filter;
 if ($tag) {
  $hook[$tag]=$wp_filter[$tag];
  if (!is_array($hook[$tag])) {
  trigger_error("Nothing found for '$tag' hook", E_USER_WARNING);
  return;
  }
 }
 else {
  $hook=$wp_filter;
  ksort($hook);
 }
 echo '<pre>';
 foreach($hook as $tag => $priority){
  echo "<br />&gt;&gt;&gt;&gt;&gt;\t<strong>$tag</strong><br />";
  ksort($priority);
  foreach($priority as $priority => $function){
  echo $priority;
  foreach($function as $name => $properties) echo "\t$name<br />";
  }
 }
 echo '</pre>';
 return;
}

register_nav_menus(array(
	'top'    => 'Верхнее меню',    //Название месторасположения меню в шаблоне
	'bottom' => 'Нижнее меню'      //Название другого месторасположения меню в шаблоне
));

function wp_kama_theme_setup(){
	// Поддержка миниатюр
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-logo' );
	add_theme_support( 'custom-header' );
	add_theme_support( 'custom-background' );
}
add_action( 'after_setup_theme', 'wp_kama_theme_setup' );
register_sidebars(2);

function rus_date() {
// Перевод
 $translate = array(
 "am" => "дп",
 "pm" => "пп",
 "AM" => "ДП",
 "PM" => "ПП",
 "Monday" => "Понедельник",
 "Mon" => "Пн",
 "Tuesday" => "Вторник",
 "Tue" => "Вт",
 "Wednesday" => "Среда",
 "Wed" => "Ср",
 "Thursday" => "Четверг",
 "Thu" => "Чт",
 "Friday" => "Пятница",
 "Fri" => "Пт",
 "Saturday" => "Суббота",
 "Sat" => "Сб",
 "Sunday" => "Воскресенье",
 "Sun" => "Вс",
 "January" => "Января",
 "Jan" => "Янв",
 "February" => "Февраля",
 "Feb" => "Фев",
 "March" => "Марта",
 "Mar" => "Мар",
 "April" => "Апреля",
 "Apr" => "Апр",
 "May" => "Мая",
 "May" => "Мая",
 "June" => "Июня",
 "Jun" => "Июн",
 "July" => "Июля",
 "Jul" => "Июл",
 "August" => "Августа",
 "Aug" => "Авг",
 "September" => "Сентября",
 "Sep" => "Сен",
 "October" => "Октября",
 "Oct" => "Окт",
 "November" => "Ноября",
 "Nov" => "Ноя",
 "December" => "Декабря",
 "Dec" => "Дек",
 "st" => "ое",
 "nd" => "ое",
 "rd" => "е",
 "th" => "ое"
 );
 // если передали дату, то переводим ее
 if (func_num_args() > 1) {
 $timestamp = func_get_arg(1);
 return strtr(date(func_get_arg(0), $timestamp), $translate);
 } else {
// иначе текущую дату
 return strtr(date(func_get_arg(0)), $translate);
 }
 }
function phone_convert_to_link($tel)
	{
		echo "<a href='tel:".preg_replace('/[ \-()]/','',$tel)."'>".$tel."</a>";
	}
function email_convert_to_link($email)
	{
		echo "<a href='mailto:".$email."'>".$email."</a>";
	}
function generate_owl_from_post($cat_id,$numposts)
	{
		$args = array
			(
				'category' => $cat_id,
				'numberposts' => $numposts
			);
		$posts = get_posts($args);
		
		$return = "<div class='owl-carousel'>";
		
		foreach ($posts as $post)
			{
				
			}
			
		$return .= "</div>";
		return $return;
	}

?>