import {Chat} from "../Component/Chat.js";
import {Element} from "../Core/Element.js";

export class Translate {
    static index(response) {
        let load = Element.getId('load-chat');
        Chat.response(response.translate)
        load.setAttribute('style','display: none')
    }
}