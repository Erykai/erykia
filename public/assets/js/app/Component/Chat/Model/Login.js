import {Attribute} from "../../../Core/Attribute.js";
import {Element} from "../../../Core/Element.js";
import CoreDatabase from "../../../Core/Database.js";
import {Chat} from "../Chat.js";

export class Login
{
    static login() {
        Chat.translate("What is your email?")
        Attribute.getInput().setAttribute('name', 'login')
        Attribute.getSend().setAttribute('name', 'login')
        Chat.save()
    }
    static email() {
        Chat.translate("What is your password?")
        Attribute.getInput().setAttribute('name', 'login')
        Chat.save()
    }
    static password() {
        Element.getId('load-chat').setAttribute('style','')
        Attribute.setUrl(window.location.href + '/login')
        Attribute.setMethod('POST')
        CoreDatabase.request(localStorage.getItem('data'))
        Attribute.getInput().setAttribute('name', 'end')
    }
}