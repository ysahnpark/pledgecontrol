/**
 * Imports a collection from uploaded CSV file
 *
 * @param fileInputId  - Eg. 'file_importItems'
 * @param addEntryFunc - Function that adds the entries. 
 *                       Signature: fn(array)
 */
function df_importCollection(fileInputId, addEntryFunc) {
	// Check for the various File API support.
	if (window.File && window.FileReader && window.FileList && window.Blob) {
	  // Great success! All the File APIs are supported.
	} else {
	  alert('The File APIs are not fully supported in this browser.');
	}

	var files = document.getElementById(fileInputId).files;
    if (!files.length) {
		alert('Please select a file!');
		return false;
    }
    var file = files[0];
	var start = 0;
    var stop = file.size - 1;

    var reader = new FileReader();

    // If we use onloadend, we need to check the readyState.
	reader.onloadend = function(evt) {
		if (evt.target.readyState == FileReader.DONE) { // DONE == 2
			var csvText = evt.target.result;
			var csv_arrs = $.csv.toArrays(csvText);

			for(var i=0; i < csv_arrs.length; i ++)
			{
				addEntryFunc(csv_arrs[i]);
			}
		}
	};

	var blob = file.slice(start, stop + 1);
    reader.readAsText(blob);
}

/**
 * Intercepts form submission.
 * Piggybacks the collection element's indices to the form as a
 * hidden input with name "<collection-name>-indices"
 *
 * @param $form to form which contains the content and is being submitted
 */
function df_piggybackCollectionIndices($form)
{
	// select list of all elemeentis in this form which as 'data-collection' attribute
	var dataCollection = $form.find('[data-collection]');

	// Map<string, Array<number>>, where [key] = collection name, and
	//                                   [value] is an array of indexes
	var collectionIndicesMap = {};

	// Iteratee over data-collection and create a map of indices
	dataCollection.each(function( index ) {	
		var coll = $( this ).data('collection');
		var collIdx = $( this ).data('collectionIdx');

		if (!collectionIndicesMap.hasOwnProperty(coll)) {
			collectionIndicesMap[coll] = [];
		}

		var inArray = $.inArray(collIdx, collectionIndicesMap[coll]);
		if (inArray === -1) {
			collectionIndicesMap[coll].push(collIdx)
		}
		
		console.log( index + ": " + coll + "[" + collIdx + "]" );
	});

	console.log( "indexes " + JSON.stringify(collectionIndicesMap) );

	// append hidden input with the indices
	for (var key in collectionIndicesMap) {
		var collectionIndices = collectionIndicesMap[key];
		var indicesInput = document.createElement( 'input' );
		indicesInput.setAttribute('name', key + '-indices');
		indicesInput.setAttribute('type', 'hidden');
		indicesInput.setAttribute('value', collectionIndices.join(','));
		$form.prepend(indicesInput);
	}
}