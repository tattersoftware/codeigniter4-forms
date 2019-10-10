/************* UTILITIES *************/

// Converts media query to boolean
function isMobile() {
	return window.matchMedia("only screen and (max-width: 760px)").matches;
}

/*
// WIP - https://forum.codeigniter.com/thread-71597.html
// https://github.com/js-cookie/js-cookie
$.ajaxSetup({
  data: {
    csrf_token_name: Cookies.get(csrf_cookie_name)
  }
})
const CSRF = [ "<?= csrf_token() ?>", "<?= csrf_hash() ?>" ];
*/

/************* FORMS *************/

// Desktop-only AJAX submit - passes through for mobile
function desktopSubmit(form, callback) {
	clearFormValidation(form);
	
 	if (isMobile()) {
 		return true;
 	}

 	return formSubmit(form, callback);
 }

// AJAX form submission with validation and optional success callback
function formSubmit(form, callback) {
	clearFormValidation(form);
	
	// Target the API endpoint; fallback to form URL
	url = (typeof apiUrl !== "undefined") ?  form.action.replace(siteUrl, apiUrl) : form.action;
	console.log("Posting " + form.name + " to " + url);
	
	$.ajax({
		type: "POST",
		url: url,
		data: $(form).serialize(),
		dataType: "json"
	})

	.done(function(data, textStatus, req) {
		clearFormValidation(form);
		$(form).find(".feedback").addClass("text-success").html(textStatus);
		if (typeof callback === "function") {
			callback();
		}
	})

	.fail(function(req, textStatus, errorThrown) {
		// Check for actual success
		if (req.status >= 200 && req.status < 300) {
			clearFormValidation(form);
			$(form).find(".feedback").addClass("text-success").html(req.statusText);
			if (typeof callback === "function") {
				callback();
			}

			return;
		}
		
		if (! req.hasOwnProperty('responseJSON')) {
			console.error('Invalid response type on form submit');

			console.log(req);
			console.log(textStatus);
			console.log(errorThrown);

			return;
		}

		$(form).find(".feedback").addClass("text-danger").html(req.statusText);
		
		// Check each element for a matching error
		[...form.elements].forEach(el => {
			if (! el.id) {
				return;
			}
			
			if (req.responseJSON.messages.hasOwnProperty(el.id)) {
				$("#" + el.id).addClass("is-invalid");
				$("#" + el.id).removeClass("is-valid");
				$("#" + el.id + "-feedback").addClass("invalid-feedback");
				$("#" + el.id + "-feedback").removeClass("valid-feedback");
				$("#" + el.id + "-feedback").html(req.responseJSON.messages[el.id]);
			}
			else {
				$("#" + el.id).addClass("is-valid");
				$("#" + el.id).removeClass("is-invalid");
				$("#" + el.id + "-feedback").addClass("valid-feedback");
				$("#" + el.id + "-feedback").removeClass("invalid-feedback");
				$("#" + el.id + "-feedback").html("");
			}
		});
	});
	
	return false;
}

function clearFormValidation(form) {
	$form = $(form);
	
	$form.find(".is-valid").removeClass("is-valid");
	$form.find(".is-invalid").removeClass("is-invalid");
	
	$form.find(".valid-feedback").html("").removeClass("valid-feedback");
	$form.find(".invalid-feedback").html("").removeClass("invalid-feedback");
	
	$form.find(".feedback").html("").removeClass("text-success").removeClass("text-danger");
}

/************* MODALS *************/

// Desktop-only modal - redirects to the URL for mobile
function desktopModal(url, options) {
 	if (isMobile()) {
 		window.location = url;
 		return;
 	}

 	loadModal(url, options);
 }
 
// Requests a URL and displays it in a modal
function loadModal(url, options) {
	// Check for an existing modal
	if (typeof options !== "undefined" && typeof options.id !== "undefined") {
		if ($("#" + options.id).length > 0) {
			$("#" + options.id).modal("show");
			return;
		}
	}
	
	// Create a new modal
	var modalId = addModal(options);
	
	console.log("Loading from " + url);
	
	// Load URL content into modal body, then open the modal
	$("#" + modalId + " .modal-body").load(url, function(responseText, textStatus, req) {
		$("#" + modalId).modal();
	});
}

// Inserts a Bootstrap 4 modal into <body> and returns its ID
function addModal(options) {
	// Set defaults
	let defaults = {
		id: "modal-" + Math.round(Date.now() / 1000),
		class: "modal-dynamic",
		title: "",
		body: "",
		footer: '<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button></div>',
	};
	options = Object.assign({}, defaults, options);

	var template = 
'		<div id="' + options.id + '" class="modal ' + options.class + '" tabindex="-1" role="dialog">' +
'			<div class="modal-dialog" role="document">' +
'				<div class="modal-content">' +
'					<div class="modal-header">' +
'						<h5 class="modal-title">' + options.title + '</h5>' +
'						<button type="button" class="close" data-dismiss="modal" aria-label="Close">' +
'							<span aria-hidden="true">&times;</span>' +
'						</button>' +
'					</div>' +
'					<div class="modal-body">' + options.body + '</div>' +
'					<div class="modal-footer">' + options.footer + '</div>' +
'				</div>' +
'			</div>' +
'		</div>';
	
	document.body.insertAdjacentHTML('beforeend', template);
	
	return options.id;
}

// Close any open modals (should be at most one)
function closeModal() {
	$(".modal").modal("hide");
}
