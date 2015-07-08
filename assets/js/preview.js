$(document).ready(function(){
	var links = $('body a[href]');
	$.each(links,function preview_function(key,link){
		console.log(link);
		if(link.href.indexOf('?') > -1)
		{
			link.href = link.href+"&preview=true&theme=default";
		}
		else
			link.href = link.href+"?preview=true&theme=default";
		});
});