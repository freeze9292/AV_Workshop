<?php
/*
Plugin Name: Adinpost
Plugin URI: https://github.com/vailalex/AV_Workshop
Description: devoir à rendre pour le 21/10
Version: 0.1
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


?>