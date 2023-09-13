<?php

    /**
     * JCH Optimize - Performs several front-end optimizations for fast downloads
     *
     * @package   jchoptimize/joomla-platform
     * @author    Samuel Marshall <samuel@jch-optimize.net>
     * @copyright Copyright (c) 2020 Samuel Marshall / JCH Optimize
     * @license   GNU/GPLv3, or later. See LICENSE file
     *
     * If LICENSE file missing, see <http://www.gnu.org/licenses/>.
     */

    use JchOptimize\Core\SystemUri;use Joomla\CMS\Language\Text;

    defined( '_JEXEC' ) or die( 'Restricted Access' );

    $options = [
            'task' => 'importsettings'
];
    $data = json_encode($options);
    $maxFileSize = ini_get('upload_max_filesize');
    $confirmDelete = Text::_('COM_JCHOPTIMIZE_CONFIRM_DELETE_SETTINGS');

use function _JchOptimizeVendor\e;

?>
<form id="bulk-settings-form" action="<?php echo e(SystemUri::basePath()); ?>index.php" name="bulk-settings-form"
      method="post"
      enctype="multipart/form-data">
    <p class="alert alert-warning"><?php echo e(Text::_('COM_JCHOPTIMIZE_BULK_SETTINGS_WARNING')); ?></p>
    <p class="text-center">
        <button id="export-settings-file-button" type="submit" class="btn btn-secondary" name="task"
                value="exportsettings">
            <span class="icon-download"></span>
            <?php echo e(Text::_('COM_JCHOPTIMIZE_EXPORT_SETTINGS')); ?>

        </button>
        <button id="reset-settings-button" type="submit" class="btn btn-warning"
                name="task" value="setdefaultsettings" onclick="return confirm('<?php echo e($confirmDelete); ?>')">
            <span class="icon-redo-2"></span>
            <?php echo e(Text::_('COM_JCHOPTIMIZE_RESET_DEFAULT_SETTINGS')); ?>

        </button>
        <button id="import-settings-file-button" type="button" class="btn btn-primary"
                onclick="getSettingsFileUpload()" name="task" value="importsettings">
            <span class="icon-upload"></span>
            <?php echo e(Text::_('COM_JCHOPTIMIZE_IMPORT_SETTINGS')); ?>

        </button>
    <div class="hidden">
        <!--  <input type="hidden" name="MAX_FILE_SIZE" value="4000"> -->
        <input id="bulk-settings-file-input" type="file" name="file" accept="application/json">
    </div>
    </p>
    <input type="hidden" name="option" value="com_jchoptimize">
    <input type="hidden" name="view" value="Utility">
</form>

<?php /**PATH C:\MAMP\htdocs\cassava.nri.org\administrator\components\com_jchoptimize\lib\tmpl/bulk_settings.blade.php ENDPATH**/ ?>