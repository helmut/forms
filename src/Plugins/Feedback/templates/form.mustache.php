<div id="feedback_form_{{ id }}">
	{{{ form }}}
</div>
<script>
	function feedback_{{ id }}_debounce(f,w,i){var t;return function(){var c=this,a=arguments;var l=function(){t=null;if(!i)f.apply(c,a);};var cn=i&&!t;clearTimeout(t);t=setTimeout(l,w);if(cn)f.apply(c,a);};};
	function feedback_{{ id }}_param(o){var es='';for(var p in o) {if(o.hasOwnProperty(p)){if(es.length > 0) es += '&';es+=encodeURI(p+'='+o[p]);}}return es;}
	function feedback_{{ id }}_serialize(fm) {
	    var f, s = [];
	    if (typeof fm == 'object' && fm.nodeName == "FORM") {
	        var len = fm.elements.length;
	        for (i=0; i<len; i++) {
	            f = fm.elements[i];
	            if (f.name && !f.disabled && f.type != 'file' && f.type != 'reset' && f.type != 'submit' && f.type != 'button') {
	                if (f.type == 'select-multiple') {
	                    for (j=fm.elements[i].options.length-1; j>=0; j--) {
	                        if(f.options[j].selected)
	                            s[s.length] = encodeURIComponent(f.name) + "=" + encodeURIComponent(f.options[j].value);
	                    }
	                } else if ((f.type != 'checkbox' && f.type != 'radio') || f.checked) {
	                    s[s.length] = encodeURIComponent(f.name) + "=" + encodeURIComponent(f.value);
	                }
	            }
	        }
	    }
	    return s.join('&').replace(/%20/g, '+');
	}	
	function feedback_{{ id }}(name) {
		var form_container = document.getElementById('feedback_form_{{ id }}');
		var form = form_container.getElementsByTagName('form')[0];
		if(form != null) {
			params = []; params['feedback_trigger_{{ id }}'] = true; params['name'] = name;
			{{# csrf }}params['{{ csrf.name }}'] = '{{ csrf.value }}';{{/ csrf }}
			xhr = new XMLHttpRequest();
			xhr.open('POST', encodeURI(form.getAttribute('action') || ''));
			xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			xhr.onload = function() {
				if(xhr.status == '200') {
					try {
						response = JSON.parse(xhr.responseText); 
						if(response.id) document.getElementById(response.error_id).innerHTML = response.error;
					} catch(e) {}
				}
			}
			xhr.send(feedback_{{ id }}_param(params) + '&' + feedback_{{ id }}_serialize(form));
		}
	}
	function feedback_{{ id }}_listen(field, name) {
		var field_{{ id }} = document.getElementById(field);
		if(field_{{ id }} != null) {
			var field_{{ id }}_inputs = field_{{ id }}.getElementsByTagName('input');
			for(var i=0; i<field_{{ id }}_inputs.length; i++) {
				input = field_{{ id }}_inputs[i];
				if(input.getAttribute('type') == 'checkbox' || input.getAttribute('type') == 'radio') {
				 	input.addEventListener('change', feedback_{{ id }}_debounce(function() { feedback_{{ id }}(name) }, 250, true), false);
				} else {
					if(input.getAttribute('type') != 'submit') {
						input.addEventListener('blur', feedback_{{ id }}_debounce(function() { feedback_{{ id }}(name) }, 250, true), false);
						input.addEventListener('keyup', feedback_{{ id }}_debounce(function() { feedback_{{ id }}(name) }, 500, false), false);
					}
				}
			}
			var field_{{ id }}_textareas = field_{{ id }}.getElementsByTagName('textarea');
			for(var i=0; i<field_{{ id }}_textareas.length; i++) {
				field_{{ id }}_textareas[i].addEventListener('blur', feedback_{{ id }}_debounce(function() { feedback_{{ id }}(name) }, 250, true), false);
				field_{{ id }}_textareas[i].addEventListener('keyup', feedback_{{ id }}_debounce(function() { feedback_{{ id }}(name) }, 500, false), false);
			}
			var field_{{ id }}_selects = field_{{ id }}.getElementsByTagName('select');
			for(var i=0; i<field_{{ id }}_selects.length; i++) {
				field_{{ id }}_selects[i].addEventListener('blur', feedback_{{ id }}_debounce(function() { feedback_{{ id }}(name) }, 250, true), false);
				field_{{ id }}_selects[i].addEventListener('change', feedback_{{ id }}_debounce(function() { feedback_{{ id }}(name) }, 250, true), false);
			}
		}
	}
	{{# fields }}
	feedback_{{ form_id }}_listen('feedback_field_{{ id }}', '{{ name }}');
	{{/ fields }}
</script>
