<?php
/*
Plugin Name: Adinpost
Plugin URI: https://github.com/vailalex/AV_Workshop
Description: devoir à rendre pour le 21/10
Version: 0.17
Author: Alexandre Vaillant 3adev
*/



/* Affichage du bas de contenu, protection contre faille xss avec wp_kses (autorisation des lien href) */

function av_ajout_texte($contenu){
		$mon_bas_de_contenu= "TEST";
		$bas_de_contenu = "<div id='bas_de_contenu'>" . $mon_bas_de_contenu . "</div> ";
		$nouveau_contenu = $contenu . $bas_de_contenu;
		return $nouveau_contenu;
	
}

add_filter( 'the_content', 'av_ajout_texte');


/*BO Admin*/

add_action('admin_menu', 'add_admin_menu');

function add_admin_menu()
{					/*titre de la page, titre du menu, droit, */
	    add_menu_page('Options Adinpost', 'Adinpost', 'manage_options', 'adinpost', 'menu_html');


	    add_action('admin_init', 'av_register_settings');

		
		
		/*valeur par défaut du champ de bas de page*/
		$valeur_option = get_option(av_bas_de_page);
		if($valeur_option==NULL){
		
			update_option ('av_bas_de_page', __('Text limited to 300 letters.', 'av_bas_de_contenu'));
		}
}


function av_register_settings()
{
    register_setting('av_groupe_options', 'av_bas_de_page');

}


/*BO formulaire*/

function menu_html()
{
	?>
	
	<div id="av_formu">
	<?php
    echo '<h1>'.get_admin_page_title().'</h1>';
    _e('Please write your text :', 'av_bas_de_contenu');
	
		?>
	
	 <form id="formulaire" method="post" action="options.php">
	 
		<?php settings_fields('av_groupe_options'); ?>
		<?php do_settings_sections('av_bas_de_page'); ?>
		<textarea maxlength="300" rows="4" cols="50" type="text" value="av_form" name="av_bas_de_page"><?php _e(get_option('av_bas_de_page', 'av_bas_de_contenu'));?></textarea>	
		<?php submit_button(); ?>
	
    </form>

	</div>



	<?php
	
}




/*bouton barre horizontale admin */

add_action('add_admin_bar_menus', 'av_admin_bar');

function av_admin_bar_down() {
	global $wp_admin_bar;
	$wp_admin_bar->add_menu( array( 'id' => 'bas_de_contenu', 'title' => __('Adinpost', 'av_bas_de_contenu'), 'href' => admin_url( 'admin.php?page=adinpost' ) ) );
}

function av_admin_bar() {
add_action( 'admin_bar_menu', 'av_admin_bar_down', 40 );	
}


?>