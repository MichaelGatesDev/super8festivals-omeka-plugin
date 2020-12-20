import { isEmptyString } from "../../../shared/javascripts/misc.js";

export class Person {
    static getFullName = (person) => {
        let result = "";
        if (!isEmptyString(person.first_name)) {
            result += person.first_name;
            if (!isEmptyString(person.first_name)) {
                result += ` ${person.last_name}`;
            }
        } else if (!isEmptyString(person.organization_name)) {
            result = person.organization_name;
        }
        return result;
    };
    static getDisplayName = (person) => {
        let result = "";
        if (!isEmptyString(person.first_name)) {
            result += person.first_name;
            if (!isEmptyString(person.last_name)) {
                result += ` ${person.last_name}`;
            }
            if (!isEmptyString(person.email)) {
                result += ` (${person.email})`;
            }
        } else if (!isEmptyString(person.organization_name)) {
            result = person.organization_name;
            if (!isEmptyString(person.email)) {
                result += ` (${person.email})`;
            }
        } else {
            result = person.email;
        }
        return result;
    };
}
