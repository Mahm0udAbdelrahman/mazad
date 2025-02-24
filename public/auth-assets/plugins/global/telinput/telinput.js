let telInput = $("#phone")

// initialize
telInput.intlTelInput({
    initialCountry: 'sa',
	hiddenInput: "full_phone",
	width: '100%',
    preferredCountries: ['sa', 'eg'],
    autoPlaceholder: 'aggressive',
    formatOnDisplay: false,
    separateDialCode: true,
    utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.1.6/js/utils.js",
});

let telInput1 = $("#phone1")

// initialize
telInput1.intlTelInput({
    initialCountry: 'eg',
	width: '100%',
    preferredCountries: ['eg'],
    autoPlaceholder: 'aggressive',
    formatOnDisplay: false,
    separateDialCode: true,
    utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.1.6/js/utils.js",
});

