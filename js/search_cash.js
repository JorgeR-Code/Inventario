jQuery(document).ready(function ($) {
    var countryTags = [
        "Albania",
        "Algeria",
        "Andorra",
        "Angola",
        "Australia",
        "Austria",
        "Bahamas",
        "Bahrain",
        "Bangladesh",
        "Barbados",
        "Belarus",
        "Belgium",
        "Belize",
        "Benin",
        "Botswana",
        "Brazil",
        "Burma",
        "Burundi",
        "Cambodia",
        "Cameroon",
        "Canada",
        "Chad",
        "Chile",
        "China",
        "Colombia",
        "Comoros",
        "Congo"
    ];




    $("#busqueda").autocomplete({
        source: countryTags
    });



});