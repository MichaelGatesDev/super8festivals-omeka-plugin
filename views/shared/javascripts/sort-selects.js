jQuery(document).ready(() => {

    // sort the dropdown
    const selects = jQuery('select');
    for (let select of selects) {
        select = jQuery(select);

        // get currently selected
        const selectedOption = select.find('option:selected');
        const selectedOptionValue = selectedOption.val();

        const options = jQuery.makeArray(select.find('option'));
        const sorted = options.sort(function (a, b) {
            return (jQuery(a).text() > jQuery(b).text()) ? 1 : -1;
        });
        select.append(jQuery(sorted)).attr('selectedIndex', 0);

        // select the originally selected item
        select.val(selectedOptionValue);
    }
});
