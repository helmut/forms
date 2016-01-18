<div class="row">
	<div class="medium-12 columns">
		<label>{{ label }}{{# required }} <span style="font-weight:normal" title="{{ lang.required }}">*</span>{{/ required}}<br />
			<select name="{{ name }}" style="width:auto">
				<option value=""></option>
				{{# options }}
					<option value="{{ value }}"{{# selected }} selected="selected"{{/ selected}}>{{ label }}</option>
				{{/ options }}
			</select>
		</label>
	</div>
</div>
