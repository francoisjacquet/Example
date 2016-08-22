<?php
/**
 * French Help texts
 *
 * Texts are organized by:
 * - Module
 * - Profile
 *
 * Please use this file as a model to translate the texts to your language
 * The new resulting Help file should be named after the following convention:
 * Help_[two letters language code].php
 *
 * @author François Jacquet
 *
 * @uses Heredoc syntax
 * @see  http://php.net/manual/en/language.types.string.php#language.types.string.syntax.heredoc
 *
 * @package Example module
 * @subpackage Help
 */

// EXAMPLE ---.
if ( User( 'PROFILE' ) === 'admin' ) :

	$help['Example/ExampleResource.php'] = <<<HTML
<p>
	<i>Ressource Exemple</i> vous permet de consulter un exemple de <b>ressource</b>.
</p>
<p>
	Je suis l'aide en ligne du programme <code>ExampleResource.php</code>, vous me trouverez dans le fichier <code>Help_fr.php</code>, à tout de suite!
</p>

HTML;

	$help['Example/ExampleWidget.php'] = <<<HTML
<p>
	<i>Widget Exemple</i> vous permet d'utiliser un <b>widget</b> d'exemple.
</p>
<p>
	Je suis l'aide en ligne du programme <code>ExampleResource.php</code>, vous me trouverez dans le fichier <code>Help_fr.php</code>, à tout de suite!
</p>

HTML;

	$help['Example/Setup.php'] = <<<HTML
<p>
	<i>Paramétrage</i> vous permet de <b>configurer</b> le module.
</p>
<p>
	Je suis l'aide en ligne du programme <code>ExampleResource.php</code>, vous me trouverez dans le fichier <code>Help_fr.php</code>, à tout de suite!
</p>

HTML;

endif;


// Teacher help.
if ( User( 'PROFILE' ) === 'teacher' ) :

	$help['Example/ExampleWidget.php'] = <<<HTML
<p>
	<i>Widget Exemple</i> vous permet d'utiliser un <b>widget</b> d'exemple.
</p>
<p>
	Je suis l'aide en ligne du programme <code>ExampleResource.php</code>, vous me trouverez dans le fichier <code>Help_fr.php</code>, à tout de suite!
</p>
<p>
	Ce texte devrait pouvoir être vu seulement par les <b>professeurs</b>!
</p>

HTML;

endif;


// Parent & student help.
if ( User( 'PROFILE' ) === 'parent' ) :

	$help['Example/ExampleWidget.php'] = <<<HTML
<p>
	<i>Widget Exemple</i> vous permet d'utiliser un <b>widget</b> d'exemple.
</p>
<p>
	Je suis l'aide en ligne du programme <code>ExampleResource.php</code>, vous me trouverez dans le fichier <code>Help_fr.php</code>, à tout de suite!
</p>
<p>
	Ce texte devrait pouvoir être vu seulement par les <b>parents et élèves</b>!
</p>

HTML;

endif;
