//La funzione verifica che la stringa "string" non contenga i caratteri nella costante "SPECIAL"
export function special_characters(string) {
    const SPECIAL = /[`@#$%*()_\=\[\]{};':"\\|,<>\/]/;
    return SPECIAL.test(string);
};

//La funzione verifica che stringa "string" non sia vuota
export function emptyDataWhiteSpaceNotAllowed(string) {
    if (string === "" || hasWhiteSpace(string))
        return true;
    else
        return false;
};

export function emptyData(string) {
    if (string === "")
        return true;
    else
        return false;
};

//La funzione verifica che stringa "string" non contenga whitespaces
function hasWhiteSpace(string) {
    return string.indexOf(' ') >= 0;
};

export function onlyDigits(string) {
    return string.match(/^[0-9]+$/);
};

export function nullValue(string) {
    if (emptyDataWhiteSpaceNotAllowed(string))
        return string = null;
};