//Thanks Jquiry UI Documentation
function split( val ) {
	return val.split( /;\s*/ );
}
function extractLast( term ) {
	return split( term ).pop();
}

function setupAutocomplete(id, script){
	var availableTags = [];
	$.ajax({
		url : script,
		type : 'post',
		data : {},
		success : function(answer){
			if(answer == "DB_CONNECT_FAILURE"){}
			else {
				availableTags = eval(answer);

				$(id)
					.bind( "keydown", function( event ) {
						if ( event.keyCode === $.ui.keyCode.TAB && $( this ).data( "ui-autocomplete" ).menu.active ) {
							event.preventDefault();
						}
					})
					.autocomplete({
						minLength: 4,
					
						source: function( request, response ) {

							var matches = $.map( availableTags, function(tag) {
								var lastTerm = extractLast(request.term);
								if (tag != null) {
									if ( tag.toUpperCase().indexOf(lastTerm.toUpperCase()) === 0 ) {
										return tag;
									}
								}
							});
							//alert(matches);
							response(matches.slice(0, 50));
							//response(matches);
						},
						focus: function() {
							// prevent value inserted on focus
							return false;
						},
						select: function( event, ui ) {
							var terms = split( this.value );
							// remove the current input
							terms.pop();
							// add the selected item
							terms.push( ui.item.value );
							// add placeholder to get the comma-and-space at the end
							terms.push( "" );
							this.value = terms.join( "; " );
							return false;
						}
					});


			}
		}
	});
}
