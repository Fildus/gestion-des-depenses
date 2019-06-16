const autoComplete = require('./autocomplete')
const $ = require('jquery')

const arr = [
    {html: 'expenditure_title', server: 'title'},
    {html: 'expenditure_society', server: 'society'},
    {html: 'expenditure_category', server: 'category'},
    {html: 'expenditure_type', server: 'type'},
    {html: 'expenditure_sourceAccount', server: 'sourceAccount'}
]

arr.forEach(function (e) {
    const elt = document.querySelector('#' + e.html)
    if (null != elt) {
        new autoComplete({
            selector: `input[id="${e.html}"]`,
            minChars: 1,
            delay: 500,
            source: function (term, response) {
                $.getJSON(`/autocomplete/${e.server}/${elt.value}`,
                    function (data) {
                        return response(data)
                    }
                );
            }
        });
    }
})