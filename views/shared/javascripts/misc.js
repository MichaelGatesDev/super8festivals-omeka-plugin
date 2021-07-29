/**
 * Smoothly scrolls to the element with the specified ID
 * @param elemID The element ID to scroll to
 */
export const scrollTo = (elemID) => {
    const elem = document.getElementById(elemID);
    if (!elem) return;
    elem.scrollIntoView({
        behavior: "smooth", // smooth scroll
        block: "start", // the upper border of the element will be aligned at the top of the visible part of the window of the scrollable area.
    });
};

/**
 * Confirms that the specified input is a format which represents a proper floating point number
 * @param input The input to check
 * @returns {boolean} If the input is valid
 */
export const isValidFloat = (input) => (!/^\s*$/.test(input) && !isNaN(input));

export const isEmptyString = (input) => input === null || input === undefined || input.replace(/\s/g, "") === "";

export const FormAction = {
    Add: "add",
    Update: "update",
    Delete: "delete",
};

export const openLink = (url, newTab = false) => {
    window.open(url, newTab ? "_blank" : "_self");
};

export const getAttributeFromElementStr = (elementStr, attr) => {
    const parser = new DOMParser();
    const htmlDoc = parser.parseFromString(elementStr, "text/html");
    return htmlDoc.querySelector("iframe").getAttribute(attr);
};

export const SUPPORTED_IMAGE_MIMES = [
    "image/png",
    "image/jpeg",
];

export const SUPPORTED_DOCUMENT_MIMES = [
    "application/pdf",
];

export const getVideoThumbnailFor = async (url) => {
    const ytRegex = /(youtube\.com|youtu.be)\/(watch\?v=)?([A-Za-z0-9_\-]+)/;
    const vimeoRegex = /vimeo\.com\/(manage\/)?(videos\/)?([0-9]+)/;

    if (ytRegex.test(url)) {
        const res = ytRegex.exec(url);
        const vidId = res[3];
        return `https://img.youtube.com/vi/${vidId}/0.jpg`;
    } else if (vimeoRegex.test(url)) {
        const res = vimeoRegex.exec(url);
        const vidId = res[3];

        const resp = await $.ajax({
            type: "GET",
            url: `//vimeo.com/api/v2/video/${vidId}.json`,
            dataType: "json",
        });
        return resp[0].thumbnail_medium;
    }
};