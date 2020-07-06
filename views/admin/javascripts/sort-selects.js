jQuery(document).ready(() => {

    // get currently selected
    const selectedOption = jQuery('option:selected');
    const selectedDropdownIndex = selectedOption[0].index;
    const selectedOptionText = selectedOption[0].text;

    // sort the dropdown
    const selects = jQuery('select');
    for (let select of selects) {
        select = jQuery(select);
        const options = jQuery.makeArray(select.find('option'));
        const sorted = options.sort(function (a, b) {
            return (jQuery(a).text() > jQuery(b).text()) ? 1 : -1;
        });
        select.append(jQuery(sorted)).attr('selectedIndex', 0);

        // select the originally selected item
        select.get(0).selectedIndex = selectedDropdownIndex === 0 ? 0 : getIndexByText(selectedOptionText);
    }


    function getIndexByText(text) {
        const options = jQuery('option');
        for (const option of options) {
            if (option.text === text) return option.index;
        }
        return null;
    }
});
