function initGuestbook() {
	
	var curRow = 0;
	
	var urlVars = getUrlVars();
	if( urlVars["row"] != undefined )
	{
		curRow = urlVars["row"];
	}
	
	$.ajax({
      url: '/guestbook/readbook.php',
      type: 'get',
      data: {'row': curRow},
      success: function(data, status) {
        $('#guestbook').html(data);
      },
      error: function(xhr, desc, err) {
        console.log(xhr);
        console.log("Details: " + desc + "\nError:" + err);
      }
    }); // end ajax call
}

function getUrlVars()
{
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}