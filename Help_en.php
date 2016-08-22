<?php
/**
 * English Help texts
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
	<i>Example Resource</i> lets you consult an example <b>resource</b>.
</p>
<p>
	I am the inline help for the <code>ExampleResource.php</code> program, you will find me in the <code>Help_en.php</code> file, see you!
</p>

HTML;

	$help['Example/ExampleWidget.php'] = <<<HTML
<p>
	<i>Example Widget</i> lets you use an example <b>widget</b>.
</p>
<p>
	I am the inline help for the <code>ExampleWidget.php</code> program, you will find me in the <code>Help_en.php</code> file, see you!
</p>

HTML;

	$help['Example/Setup.php'] = <<<HTML
<p>
	<i>Setup</i> lets you <b>configure</b> the module.
</p>
<p>
	I am the inline help for the <code>Setup.php</code> program, you will find me in the <code>Help_en.php</code> file, see you!
</p>

HTML;

endif;


// Teacher help.
if ( User( 'PROFILE' ) === 'teacher' ) :

	$help['Example/ExampleWidget.php'] = <<<HTML
<p>
	<i>Example Widget</i> lets you use an example <b>widget</b>.
</p>
<p>
	I am the inline help for the <code>ExampleWidget.php</code> program, you will find me in the <code>Help_en.php</code> file, see you!
</p>
<p>
	This text should be readable by <b>teachers</b> only!
</p>

HTML;

endif;


// Parent & student help.
if ( User( 'PROFILE' ) === 'parent' ) :

	$help['Example/ExampleWidget.php'] = <<<HTML
<p>
	<i>Example Widget</i> lets you use an example <b>widget</b>.
</p>
<p>
	I am the inline help for the <code>ExampleWidget.php</code> program, you will find me in the <code>Help_en.php</code> file, see you!
</p>
<p>
	This text should be readable by <b>parents or students</b> only!
</p>

HTML;

endif;
