$(document).ready(function() {
    $(".choose-redirect").on("change", function() {
        if (this.value == 1) {
            $(".url_redirect").toggle();
        } else {
            $(".url_redirect").toggle();
        }
    });
});

//common functionalities for all the javascript featueres
var Backend = {}; // common variable used in all the files of the backend

(function () {

	Backend = {
        /**
         * for all datatables
         *
         */
        DataTableSearch: { //functionalities related to datable search at all the places
        	selector: {},

        	init: function (dataTable) {

        		this.setSelectors();

        		this.setSelectors.divAlerts.delay(2000).fadeOut(800);

        		this.addHandlers(dataTable);

        	},
        	setSelectors: function () {
        		this.selector.searchInput = document.querySelector("div.dataTables_filter input");
        		this.selector.columnSearchInput = document.querySelectorAll(".search-input-text");
        		this.selector.columnSelectInput = document.querySelectorAll(".search-input-select");
        		this.selector.restButton = document.querySelectorAll('.reset-data');
        		this.setSelectors.copyButton = document.getElementById("copyButton");
        		this.setSelectors.csvButton = document.getElementById("csvButton");
        		this.setSelectors.excelButton = document.getElementById("excelButton");
        		this.setSelectors.pdfButton = document.getElementById("pdfButton");
        		this.setSelectors.printButton = document.getElementById("printButton");
        		this.setSelectors.divAlerts = jQuery('div.alert').not('.alert-important');

        	},
        	cloneElement: function (element, callback) {
        		var clone = element.cloneNode();
        		while (element.firstChild) {
        			clone.appendChild(element.lastChild);
        		}
        		element.parentNode.replaceChild(clone, element);
        		Backend.DataTableSearch.setSelectors();
        		callback(this.selector.searchInput);
        	},
        	addHandlers: function (dataTable) {
                // get the datatable search input and on its key press check if we hit enter then search with datatable
                this.cloneElement(this.selector.searchInput, function (element) { //cloning done to remove any binding of the events
                	element.onkeypress = function (event) {
                		if (event.keyCode == 13) {
                			dataTable.fnFilter(this.value);
                		}
                	};
                }); // to remove all the listinerers

                // for text boxes
                //column input search if search box on the column of the datatable given with enter then search with datatable
                if (this.selector.columnSearchInput.length > 0) {
                	this.selector.columnSearchInput.forEach(function (element) {
                		element.onkeypress = function (event) {
                			if (event.keyCode == 13) {
                                var i = element.getAttribute("data-column"); // getting column index
                                var v = element.value; // getting search input value
                                dataTable.api().columns(i).search(v).draw();
                            }
                        };
                    });
                }


                // Individual columns search
                if (this.selector.columnSelectInput.length >> 0) {
                	this.selector.columnSelectInput.forEach(function (element) {
                		element.onchange = function (event) {
                            var i = element.getAttribute("data-column"); // getting column index
                            var v = element.value; // getting search input value
                            dataTable.api().columns(i).search(v).draw();
                        };
                    });
                }

                // Individual columns reset
                if (this.selector.restButton.length >> 0) {
                	this.selector.restButton.forEach(function (element) {
                		element.onclick = function (event) {
                			var inputelement = this.previousElementSibling;
                			var i = inputelement.getAttribute("data-column");
                			inputelement.value = "";
                			dataTable.api().columns(i).search("").draw();
                		};
                	});
                }

                // this.setSelectors.copyButton.onclick = function (element) {
                // 	document.querySelector(".copyButton").click();
                // };
                // this.setSelectors.csvButton.onclick = function (element) {
                // 	document.querySelector(".csvButton").click();
                // };
                // this.setSelectors.excelButton.onclick = function (element) {
                // 	document.querySelector(".excelButton").click();
                // };
                // this.setSelectors.pdfButton.onclick = function (element) {
                // 	document.querySelector(".pdfButton").click();
                // };
                // this.setSelectors.printButton.onclick = function (element) {
                // 	document.querySelector(".printButton").click();
                // };
            }

        },


    };

})();


$('.default_video').change(function(){

    // start by setting everything to enabled
    $('.default_video option').attr('disabled',false);

    // loop each select and set the selected value to disabled in all other selects
    $('.default_video').each(function(){
    	var $this = $(this);
    	$('.default_video').not($this).find('option').each(function(){
    		if($(this).attr('value') == $this.val() && $this.val()!='')
    			$(this).attr('disabled',true);
    	});
    });

});
