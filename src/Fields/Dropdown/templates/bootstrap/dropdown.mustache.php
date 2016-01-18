<div class="row">
	<div class="col-sm-12">
		<div class="form-group" style="margin-bottom:10px">
			<label>{{ label }}{{# required }} <span style="font-weight:normal" title="{{ lang.required }}">*</span>{{/ required}}</label>
			<select name="{{ name }}" class="form-control" style="width:auto">
				<option value=""></option>
				{{# options }}
					<option value="{{ value }}"{{# selected }} selected="selected"{{/ selected}}>{{ label }}</option>
				{{/ options }}
			</select>
		</div>
	</div>
</div>
