/**
 * Delete SQL
 *
 * Required if install.sql file present
 * - Delete profile exceptions
 * - Delete program config options if any (to every schools)
 * - Delete module specific tables
 * (and their eventual sequences & indexes) if any
 *
 * @package Example module
 */

--
-- Delete from profile_exceptions table
--

DELETE FROM profile_exceptions WHERE modname='Example/ExampleWidget.php';
DELETE FROM profile_exceptions WHERE modname='Example/Setup.php';
DELETE FROM profile_exceptions WHERE modname='Example/Resources.php';
DELETE FROM profile_exceptions WHERE modname='Example/ExampleResource.php';


--
-- Delete options from program_config table
--

DELETE FROM program_config WHERE program='example';
