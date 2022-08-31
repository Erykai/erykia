import {Attribute} from './Attribute.js';
import {Chat} from "../Component/Chat/Chat.js";
import CoreDatabase from './Database.js';
import {Element} from "./Element.js";
import {Validate} from "../Helper/Validate.js";

export class Controller {
    static developer(developer = false) {
        Attribute.setDeveloper(developer)
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
        Chat.conversation(Attribute.getSend().name)
    }
    static start() {
        Attribute.setSend(Element.getId('send'))
        Attribute.setInput(Element.getId('response'))
        window.addEventListener("load", function () {
            Attribute.setUrl(window.location.href + '/database')
            Attribute.setMethod('POST')
            CoreDatabase.request('{"env": "isset"}')
            Chat.conversation('user')
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
}