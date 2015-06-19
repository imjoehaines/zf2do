(function doFilters() {
    'use strict';

    var filters = document.querySelectorAll('input[name="filters"]');

    for(var i = 0; i < filters.length; i++) {
        filters[i].onclick = function() {
            console.log(this.dataset.filter);
            this.parentNode.parentNode.submit();
        };
    }


})();
