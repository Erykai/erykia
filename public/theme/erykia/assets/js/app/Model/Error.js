import {Attribute} from "../Core/Attribute.js";
import {Chat} from "../Component/Chat/Chat.js";
import {Element} from "../Core/Element.js";

export class Error {
    static index(data, request) {
        Chat.response(data.error, request)
        Attribute.setInput(Element.getId('response'))
        if (localStorage.getItem('name') === 'cryptography') {
            Attribute.getInput().setAttribute('name', 'database')
            Chat.conversation('database')
        } else {
            Attribute.getInput().setAttribute('name', localStorage.getItem('name'))
            Chat.conversation('user')
        }

    }
}