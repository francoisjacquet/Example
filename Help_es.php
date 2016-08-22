<?php
/**
 * Spanish Help texts
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
	<i>Recurso de Ejemplo</i> le permite consultar <b>recursos</b> de ejemplo.
</p>
<p>
	Soy la ayuda en línea del programa <code>ExampleResource.php</code>, me encontrará en el archivo <code>Help_es.php</code>, nos vemos!
</p>

HTML;

	$help['Example/ExampleWidget.php'] = <<<HTML
<p>
	<i>Widget de Ejemplo</i> le permite usar un <b>widget</b> de ejemplo.
</p>
<p>
	Soy la ayuda en línea del programa <code>ExampleResource.php</code>, me encontrará en el archivo <code>Help_es.php</code>, nos vemos!
</p>

HTML;

	$help['Example/Setup.php'] = <<<HTML
<p>
	<i>Configuración</i> le permite <b>configurar</b> el módulo.
</p>
<p>
	Soy la ayuda en línea del programa <code>ExampleResource.php</code>, me encontrará en el archivo <code>Help_es.php</code>, nos vemos!
</p>

HTML;

endif;


// Teacher help.
if ( User( 'PROFILE' ) === 'teacher' ) :

	$help['Example/ExampleWidget.php'] = <<<HTML
<p>
	<i>Widget de Ejemplo</i> le permite usar un <b>widget</b> de ejemplo.
</p>
<p>
	Soy la ayuda en línea del programa <code>ExampleResource.php</code>, me encontrará en el archivo <code>Help_es.php</code>, nos vemos!
</p>
<p>
	Este texto debería ser visto por <b>docentes</b> solamente!
</p>

HTML;

endif;


// Parent & student help.
if ( User( 'PROFILE' ) === 'parent' ) :

	$help['Example/ExampleWidget.php'] = <<<HTML
<p>
	<i>Widget de Ejemplo</i> le permite usar un <b>widget</b> de ejemplo.
</p>
<p>
	Soy la ayuda en línea del programa <code>ExampleResource.php</code>, me encontrará en el archivo <code>Help_es.php</code>, nos vemos!
</p>
<p>
	Este texto debería ser visto por <b>padres y estudiantes</b> solamente!
</p>

HTML;

endif;
