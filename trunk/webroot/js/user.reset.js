function scorePassword(pass) {
    var score = 0;
    if (!pass)
        return score;

    if (pass.length < 6)
    	return score;

    // award every unique letter until 5 repetitions
    var letters = new Object();
    for (var i=0; i<pass.length; i++) {
        letters[pass[i]] = (letters[pass[i]] || 0) + 1;
        score += 5.0 / letters[pass[i]];
    }

    // bonus points for mixing it up
    var variations = {
        digits: /\d/.test(pass),
        lower: /[a-z]/.test(pass),
        upper: /[A-Z]/.test(pass),
        nonWords: /\W/.test(pass),
    }

    variationCount = 0;
    for (var check in variations) {
        variationCount += (variations[check] == true) ? 1 : 0;
    }
    score += (variationCount - 1) * 10;

    return parseInt(score);
}

function checkPasswordStrength(elm) {
	$('.userpass .umsg').remove();
	$('.form-group.userpass').each(function(){ $(this).removeClass('has-error has-success has-warning'); });
	var score = scorePassword($('#UserPassword').val());
	if (score > 80) {
		elm.parent().parent().parent('.form-group').addClass('has-success');
		elm.after('<span class="input-group-addon umsg"><i class="fa fa-check"></i></span>');
		return;
	}
	if (score > 60) {
		elm.parent().parent().parent('.form-group').addClass('has-warning');
		elm.after('<span class="input-group-addon umsg"><i class="fa fa-check"></i></span>');
		return;
	}
	if (score >= 30) {
		elm.parent().parent().parent('.form-group').addClass('has-warning');
		elm.after('<span class="input-group-addon umsg"><i class="fa fa-exclamation"></i></span>');
		return;
	}
	if (score < 30) {
		elm.parent().parent().parent('.form-group').addClass('has-error');
		elm.after('<span class="input-group-addon umsg"><i class="fa fa-times-circle"></i></span>');
		return;
	}
	return;
}

function checkPasswordMatch(elm) {
	$('.confirmpass .umsg').remove();
	$('.form-group.confirmpass').each(function(){ $(this).removeClass('has-error has-success has-warning'); });
	if ($('#UserCpassword').val() != $('#UserPassword').val()) {
		elm.parent().parent().parent('.form-group').addClass('has-error');
		elm.after('<span class="input-group-addon umsg"><i class="fa fa-times-circle"></i></span>');
		return;
	} else {
		elm.parent().parent().parent('.form-group').addClass('has-success');
		elm.after('<span class="input-group-addon umsg"><i class="fa fa-check"></i></span>');
		return;
	}
}

$(document).ready(function(){

	$('#UserPassword').keyup(function(e){
		checkPasswordStrength($(this));
	});
	$('#UserPassword').focus(function(e){
		checkPasswordStrength($(this));
	});
	$('#UserCpassword').keyup(function(e){
		checkPasswordMatch($(this));
	});
	$('#UserCpassword').focus(function(e){
		checkPasswordMatch($(this));
	});

});