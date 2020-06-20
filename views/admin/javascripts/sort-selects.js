$(document).ready(() => {

    // get currently selected
    const selectedOption = $('option:selected');
    const selectedDropdownIndex = selectedOption[0].index;
    const selectedOptionText = selectedOption[0].text;

    // sort the dropdown
    const select = $('select');
    select.html(select.find('option').sort(function (x, y) {
        // to change to descending order switch "<" for ">"
        return $(x).text() > $(y).text() ? 1 : -1;
    }));

    // select the originally selected item
    select.get(0).selectedIndex = selectedDropdownIndex === 0 ? 0 : getIndexByText(selectedOptionText);

    function getIndexByText(text) {
        const options = $('option');
        for (const option of options) {
            if (option.text === text) return option.index;
        }
        return null;
    }
});
