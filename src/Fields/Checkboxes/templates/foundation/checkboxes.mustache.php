<div class="row">
	<div class="medium-12 columns">
    	<legend>{{ label }}{{# required }} <span style="font-weight:normal" title="{{ lang.required }}">*</span>{{/ required}}</legend>
		{{# options }}
			<input name="{{ name }}" type="checkbox"{{# checked }} checked="checked"{{/ checked}} id="{{ id }}_{{ name }}"><label for="{{ id }}_{{ name }}">{{ label }}</label><br />
		{{/ options }}
	</div>
</div>
