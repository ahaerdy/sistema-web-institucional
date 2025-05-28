jQuery.fn.highlight = function(b) {

	function a(e, j) {

		var l = 0;

		if (e.nodeType == 3) {

			var k = removeAcento(e.data.toUpperCase());
			var k = k.indexOf(j);
			
			if (k >= 0) {

				var h = document.createElement("span");
				h.className = "highlight";
				
				var f = e.splitText(k);
				var c = f.splitText(j.length);
				var d = f.cloneNode(true);
				
				h.appendChild(d);
				f.parentNode.replaceChild(h, f);
				
				l = 1
			}

		} else {

			if (e.nodeType == 1 && e.childNodes	&& !/(script|style)/i.test(e.tagName)) {
				for ( var g = 0; g < e.childNodes.length; ++g) {
					g += a(e.childNodes[g], j)
				}
			}

		}

		return l
	}

	return this.each(function() {
		a(this, removeAcento(b.toUpperCase()))
	})
};

jQuery.fn.removeHighlight = function() {
	return this.find("span.highlight").each(function() {
		this.parentNode.firstChild.nodeName;
		with (this.parentNode) {
			replaceChild(this.firstChild, this);
			normalize()
		}
	}).end()
};

function removeAcento(strToReplace) {
	var str_acento		= "áàãâäéèêëíìîïóòõôöúùûüçÁÀÃÂÄÉÈÊËÍÌÎÏÓÒÕÖÔÚÙÛÜÇ";
	var str_sem_acento 	= "aaaaaeeeeiiiiooooouuuucAAAAAEEEEIIIIOOOOOUUUUC";
	var nova			= "";

	for (var i = 0; i < strToReplace.length; i++) 
	{
		if (str_acento.indexOf(strToReplace.charAt(i)) != -1)
		{
			nova += str_sem_acento.substr(str_acento.search(strToReplace.substr(i,1)),1);
		}
		else 
		{
			nova += strToReplace.substr(i,1);
		}
	}

	return nova;
}