<div class="row">
	<div class="col-sm-12">
		<div class="form-group" style="margin-bottom:0px">
			<label>{{ label }}{{# required }} <span style="font-weight:normal" title="{{ lang.required }}">*</span>{{/ required}}</label>
		</div>
		<div class="checkbox" style="margin-top:0">
			{{# options }}
				<label style="font-weight:normal"><input name="{{ name }}" type="checkbox"{{# checked }} checked="checked"{{/ checked}}> {{ label }}</label><br />
			{{/ options }}
		</div>
	</div>
</div>
