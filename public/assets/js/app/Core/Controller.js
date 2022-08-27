import {Attribute} from './Attribute.js';
import {Chat} from "../Component/Chat.js";
import {Database} from './Database.js';
import {Element} from "./Element.js";
import {Validate} from "../Helper/Validate.js";

export class Controller {
    static start() {
        Attribute.setSend(Element.getId('send'))
        Attribute.setInput(Element.getId('response'))
        window.addEventListener("load", function () {
            Attribute.setUrl(window.location.href)
            Attribute.setMethod('POST')
            Database.request('{"env": "isset"}')
            Chat.conversation()
        })
        Attribute.getSend().addEventListener('click', () => {
            this.send()
        })
        Attribute.getInput().addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                this.send()
            }
        })
    }

    static send() {
        if (!Validate.index(Attribute.getInput())) {
            return false;
        }
        Attribute.setData(Attribute.getInput().name, Attribute.getInput().value)
        localStorage.setItem(Attribute.getInput().name, Attribute.getInput().value)
        Chat.response(Attribute.getInput().value, 'input')
        let post = Object.assign({}, Attribute.getData())
        localStorage.setItem('data', JSON.stringify(post))
        Chat.conversation()
    }

    static developer(developer = false) {
        Attribute.setDeveloper(developer)
    }

}