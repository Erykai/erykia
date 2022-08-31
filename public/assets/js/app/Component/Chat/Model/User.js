import {Attribute} from "../../../Core/Attribute.js";
import {Element} from "../../../Core/Element.js";
import CoreDatabase from "../../../Core/Database.js";
import {Chat} from "../Chat.js";

export class User
{
    //TRIGGER
    static env() {
        Attribute.setUrl(window.location.href + '/user')
        Attribute.setMethod('POST')
        CoreDatabase.request('{"exist": "user"}')
    }
    static user() {
        Chat.translate("What is your name?")
        Attribute.getInput().setAttribute('name', 'name')
        Attribute.getSend().setAttribute('name', 'user')
        Chat.save()
    }
    //FORM
    static email() {
        Chat.translate("Set a secure password, it will be used to log into the system")
        Attribute.getInput().setAttribute('name', 'password')
        Chat.save()
    }
    static name() {
        Chat.translate("What is your email?")
        Attribute.getInput().setAttribute('name', 'email')
        Chat.save()
    }
    static password() {
        Element.getId('load-chat').setAttribute('style','')
        Attribute.setUrl(window.location.href + '/user')
        Attribute.setMethod('POST')
        CoreDatabase.request(localStorage.getItem('data'))
        Attribute.getInput().setAttribute('name', 'end')
    }
}