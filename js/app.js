function displayActive(trackList){//displays only the clicked album
    $('.album').addClass('hide');
    $(trackList).removeClass('hide');
}
$('.albumList li a').click(function() {//prevents jumping down to h2 on the discography page (made it annoying to have to keep scrolling up to click another)
	return false;
});

function validateForm(){//form valiation stuff that wasn't working in most of the browsers I tested on
	var allowSubmit=true;
	//check if #agreetoterms is checked
	if(document.getElementById("agreetoterms").checked!==true){
		alert("You must agree to the terms of the website to continue");
		allowSubmit=false;
	}

	//check number of digits in zip code
	if(document.getElementById("zipcodeentry").value.length!==5){
		alert("Invalid zip code");
		allowSubmit=false;
	}

		if(allowSubmit){
			alert("Sign up successful");
		}
			return allowSubmit;
}
