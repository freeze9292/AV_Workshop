<?php
/*
Plugin Name: Adinpost
Plugin URI: https://github.com/vailalex/AV_Workshop
Description: devoir à rendre pour le 21/10
Version: 0.25
Author: Alexandre Vaillant 3adev
*/


/*traduction fr*/

add_action( 'plugins_loaded', 'av_traduction' );


function av_traduction() {
  load_plugin_textdomain( 'av_bas_de_contenu', false, plugin_basename( dirname( __FILE__ ) ) . '/languages/' ); 
}


/* Affichage du bas de contenu, protection contre faille xss avec wp_kses (autorisation des lien href) */

function av_ajout_texte($contenu){
		$mon_bas_de_contenu= wp_kses( get_option("av_bas_de_page"), array( 'a' => array( 'href' => array() ) ) );
		$bas_de_contenu = "<div id='bas_de_contenu'>" . $mon_bas_de_contenu . "</div> ";
		$nouveau_contenu = $contenu . $bas_de_contenu;
		return $nouveau_contenu;
	
}

function av_ajout_texte2($contenu){
		$mon_haut_de_contenu= wp_kses( get_option("av_haut_de_page"), array( 'a' => array( 'href' => array() ) ) );
		$haut_de_contenu = "<div id='haut_de_contenu'>" . $mon_haut_de_contenu . "</div><br> ";
		$nouveau_contenu = $haut_de_contenu . $contenu;
		return $nouveau_contenu;
		
}

add_filter( 'the_content', 'av_ajout_texte2');
add_filter( 'the_content', 'av_ajout_texte');


/*BO Admin*/

add_action('admin_menu', 'add_admin_menu');

function add_admin_menu()
{					
	/*titre de la page, titre du menu, droit, */
	    add_menu_page('Options Adinpost', 'Adinpost', 'manage_options', 'adinpost', 'menu_html');


	    add_action('admin_init', 'av_register_settings');
	     
	
		
		/*valeur par défaut du champ de bas de page*/
		/*
		$valeur_option = get_option(av_bas_de_page);
		if($valeur_option==NULL){
		
			update_option ('av_bas_de_page', __('Text limited to 300 letters.', 'av_bas_de_contenu'));
		}*/
}


function av_register_settings()
{
    register_setting('av_groupe_options', 'av_bas_de_page');
    register_setting('av_groupe_options', 'av_haut_de_page');

}
/*Bloc category ne marche pas



	$cats= get_categories();


	if ($cats) 
	{
    foreach ( $cats as $cat ) 
    	{
    		$p = 'av_bas_de_page_'+$cat->name;
    	var_dump($p);
    		register_setting('av_groupe_options', 'av_bas_de_page_'+$cat->name);
    		register_setting('av_groupe_options', 'av_haut_de_page_'+$cat->name);
    	}
	}
}
*/

/*bouton barre horizontale admin */

add_action('add_admin_bar_menus', 'av_admin_bar');

function av_admin_bar_down() 
{
	global $wp_admin_bar;
	$wp_admin_bar->add_menu( array( 'id' => 'bas_de_contenu', 'title' => __('Adinpost', 'av_bas_de_contenu'), 'href' => admin_url( 'admin.php?page=adinpost' ) ) );
}

function av_admin_bar() 
{
add_action( 'admin_bar_menu', 'av_admin_bar_down', 40 );	
}

/*admin icon*/

add_action( 'admin_head', 'av_admin_menu_icon' );
function av_admin_menu_icon() 
{
?>

	<style type="text/css">
	.dashicons-admin-generic:before {
	content: "\f209";
}
</style>

<?php } ?>

<?php

/*BO formulaire*/

function menu_html()
{
	?>
	<div id="av_formu">
	<?php
	echo '<h1>'.get_admin_page_title().'</h1><br>';
	?>
          
	<form id="formulaire" method="post" action="options.php" enctype="multipart/form-data">
	 

	<select class="form-control" id="sel1" name="filtre">

	<option>Total</option>
	<?php
	$args = array( 'numberposts' => -1); 
	$cats= get_categories();


	if ($cats) 
	{
    	foreach ( $cats as $cat ) 
    	{
    		echo "<option>".$cat->name."</option>";
    	}
	}
	
	?>
	</select>


    <input type="file" name="fileToUpload" id="fileToUpload"><br>

	<?php
	settings_fields('av_groupe_options'); 
	do_settings_sections('av_haut_de_page', 'av_bas_de_page'); 
	?>

		<textarea maxlength="300" rows="4" cols="50" type="text" placeholder="Please write your header content" value="av_form" name="av_haut_de_page"><?php _e(get_option('av_haut_de_page', 'av_haut_de_contenu'));?></textarea>	
		 
		<textarea maxlength="300" rows="4" cols="50" type="text" placeholder="Please write your footer content" value="av_form" name="av_bas_de_page"><?php _e(get_option('av_bas_de_page', 'av_bas_de_contenu'));?></textarea>	


		<br><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"  />
    </form>


	</div>

	<?php

}

/*confirmation */

add_action('admin_notices', 'av_admin_notice');

function av_admin_notice() 
{
   if( isset($_GET['settings-updated']) ) 
   	{ ?>
    	<div id="message" class="updated notice notice-success is-dismissible below-h2"> <!-- Css établis en dehors du Plugin et par Wordpress --> 
		<p><?php _e('Updated', 'av_bas_de_contenu')?> <a href="/wordpress/index.php/"><?php _e('Back to the site', 'av_bas_de_contenu')?></a></p>
		<button type="button" class="notice-dismiss"></button>
    </div>
   <?php
   }
}


/* css site */

/*Appel Style wordpress (ne marche pas)
function av_appel_style() {
        wp_register_style( 'prefix-style', plugins_url('style/style.css', __FILE__) );
        wp_enqueue_style( 'prefix-style' );
}

add_action( 'wp_enqueue_scripts', 'av_appel_style' );
*/


?>


<style>


#haut_de_contenu{
	text-align:center;
	color: gray;
	font-style: italic;
	font-size: 12px;
}

#bas_de_contenu{
	text-align:center;
	color: gray;
	font-style: italic;
	font-size: 12px;
}

</style>
