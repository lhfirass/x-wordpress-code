<?php $fields = codexp()->settings->get('fields');?>
<div class="woodokan-inputs-editor wd_easyorder_sortable">
	<?php foreach($fields as $field): ?>
	<div class="woodokan-field-item">
		<div class="woodokan-field">
			<div class="field-toggle"><span class="dashicons dashicons-arrow-down-alt2"></span></div>
			<div class="field-heading"><?php echo esc_html($fieldAliases[$field->fieldType]) ?></div>
			<div class="field-activate">
				<label class="checkbox-ios">
					<input type="checkbox"  class="active_checkbox" <?php checked( $field->filedActive, true); ?>>
					<span class="checkbox-ios-switch"></span>
				</label>
			</div>
		</div>
		<div class="field-config-body" style="display:none">
			<div class="row">

				<div class="col-4">
					<div class="field-config">
						<label><?php _e('Placeholder Text','cod-express-checkout') ?> </label>
						<div class="field">
						<input type="hidden" class="field_type" value="<?php echo esc_html($field->fieldType);?>">
							<input type="text" name="" id="" class="placeholder_text" value="<?php echo esc_html($field->placeholderText); ?>">
						</div>
					</div>
				</div>
				<div class="col-4">
					<div class="field-config">
						<label ><?php _e('Required','cod-express-checkout') ?></label>
						<div class="field">
							<select class="is_required">
								<option value="1" <?php selected( $field->isRequired , 1 ); ?>><?php _e('Yes','cod-express-checkout') ?></option>
								<option value="0" <?php selected( $field->isRequired , 0 ); ?>><?php _e('No','cod-express-checkout') ?></option>
							</select>
						</div>
					</div>
				</div>
				<div class="col-4">
					<div class="field-config">
						<label><?php _e('Field size' , 'cod-express-checkout') ?></label>
						<div class="field">
						<select name="select_id" class="input_size">
							<option value="1" <?php selected( $field->fullSizing , 1 ); ?>>  <?php _e('Half Row' , 'cod-express-checkout') ?></option>
							<option value="0" <?php selected( $field->fullSizing , 0 ); ?>> <?php _e('Full Row' , 'cod-express-checkout') ?></option>
						</select>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php endforeach; ?>														
</div>