function getUrlVars(){
	var vars = [], hash, value;
	var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
	for(var i = 0; i < hashes.length; i++)
	{
		hash = hashes[i].split('=');
		vars.push(hash[0]);		
		// vars[hash[0]] = hash[1];
		
		if(hash[1] != null){
			value = hash[1].split("#");
			vars[hash[0]] = value[0];
		}
	}
	return vars;

}