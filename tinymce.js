function init() {
	tinyMCEPopup.resizeToInnerSize();
}

function insertPostID() {
	var tagtext;
	
		var post = document.getElementById('post-id').value;
		if (post != '' )
			tagtext = "[embedpost id='" + post + "']";
		else
			tinyMCEPopup.close();
	if(window.tinyMCE) {
		//TODO: For QTranslate we should use here 'qtrans_textarea_content' instead 'content'
		var contentID = 'content';
		if(document.getElementById('content_window_id')){
		  contentID=document.getElementById('content_window_id').value;
		}
		window.tinyMCE.execInstanceCommand(contentID, 'mceInsertContent', false, tagtext);
		//Peforms a clean up of the current editor HTML. 
		//tinyMCEPopup.editor.execCommand('mceCleanup');
		//Repaints the editor. Sometimes the browser has graphic glitches. 
		tinyMCEPopup.editor.execCommand('mceRepaint');
		tinyMCEPopup.close();
	}
	return;
}
