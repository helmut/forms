<form action="{{ action }}" method="post">
	{{{ form }}}
</form>
<style>
	.error_message {
		display: inline-block;
		padding: 2px 5px;
		opacity: 0.7;
		border-radius: 3px;
		background-color: red;
		color: white;
	}
    .error_message a {
        color: white;
        text-decoration: underline;
    }    
</style>