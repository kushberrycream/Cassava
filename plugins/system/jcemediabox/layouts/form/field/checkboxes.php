<?php
/**
 * @package     JCE MediaBox
 * @subpackage  Layout
 * 
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @copyright   Copyright (C) 2023 Ryan Demmer. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

extract($displayData);

/**
 * Layout variables
 * -----------------
 * @var   string   $autocomplete    Autocomplete attribute for the field.
 * @var   boolean  $autofocus       Is autofocus enabled?
 * @var   string   $class           Classes for the input.
 * @var   string   $description     Description of the field.
 * @var   boolean  $disabled        Is this field disabled?
 * @var   string   $group           Group the field belongs to. <fields> section in form XML.
 * @var   boolean  $hidden          Is this field hidden in the form?
 * @var   string   $hint            Placeholder for the field.
 * @var   string   $id              DOM id of the field.
 * @var   string   $label           Label of the field.
 * @var   string   $labelclass      Classes to apply to the label.
 * @var   boolean  $multiple        Does this field support multiple values?
 * @var   string   $name            Name of the input field.
 * @var   string   $onchange        Onchange attribute for the field.
 * @var   string   $onclick         Onclick attribute for the field.
 * @var   string   $pattern         Pattern (Reg Ex) of value of the form field.
 * @var   boolean  $readonly        Is this field read only?
 * @var   boolean  $repeat          Allows extensions to duplicate elements.
 * @var   boolean  $required        Is this field required?
 * @var   integer  $size            Size attribute of the input.
 * @var   boolean  $spellcheck      Spellcheck state for the form field.
 * @var   string   $validate        Validation rules to apply.
 * @var   string   $value           Value attribute of the field.
 * @var   array    $checkedOptions  Options that will be set as checked.
 * @var   boolean  $hasValue        Has this field a value assigned?
 * @var   array    $options         Options available for this field.
 */

/**
 * The format of the input tag to be filled in using sprintf.
 *     %1 - id
 *     %2 - name
 *     %3 - value
 *     %4 = any other attributes
 */
$format = '<input type="checkbox" id="%1$s" name="%2$s" value="%3$s" %4$s />';

// The alt option for JText::alt
$alt = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $name);

?>
<style type="text/css">
	.checkboxes dl {max-height: 20rem;overflow-y: auto;}
</style>

<fieldset id="<?php echo $id; ?>" class="<?php echo trim($class . ' checkboxes'); ?>"
	<?php echo $required ? 'required aria-required="true"' : ''; ?>
	<?php echo $autofocus ? 'autofocus' : ''; ?>>

	<dl>
	<?php foreach ($groups as $group => $options) :?>
		<dt><?php echo $group;?></dt>
		
		<?php foreach ($options as $n => $option) : ?>
		<?php
			// Initialize some option attributes.
			$checked = in_array((string) $option->value, $checkedOptions, true) ? 'checked' : '';

            $optionClass    = !empty($option->class) ? 'class="form-check-input ' . $option->class . '"' : ' class="form-check-input"';
            $optionDisabled = !empty($option->disable) || $disabled ? 'disabled' : '';

			// Initialize some JavaScript option attributes.
			$onclick  = !empty($option->onclick) ? 'onclick="' . $option->onclick . '"' : '';
			$onchange = !empty($option->onchange) ? 'onchange="' . $option->onchange . '"' : '';

			$oid        = $id . $n;
			$value      = htmlspecialchars($option->value, ENT_COMPAT, 'UTF-8');
			$attributes = array_filter(array($checked, $optionClass, $optionDisabled, $onchange, $onclick));
		?>
		<dd class="form-check"
			<label for="<?php echo $oid; ?>" class="form-check-label">
				<?php echo sprintf($format, $oid, $name, $value, implode(' ', $attributes)); ?>
				<?php echo $option->text; ?>
			</label>
		</dd>
		<?php endforeach; ?>
	<?php endforeach; ?>

	</dl>

	<input type="hidden" name="<?php echo $name;?>" value="" />
</fieldset>