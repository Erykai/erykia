import {Attribute} from "../Core/Attribute.js";
import {Database} from "../Core/Database.js";
import {Element} from "../Core/Element.js";

export class Chat {
    //INPUT CREATE SYSTEM//
    static base() {
        Chat.translate("Which drive of your database ex: mysql")
        Attribute.getInput().setAttribute('name', 'driver')
        Chat.setValue()
    }
    static cryptography() {
        Element.getId('load-chat').setAttribute('style','')
        Attribute.setUrl(window.location.href)
        Attribute.setMethod('POST')
        Database.request(localStorage.getItem('data'))
        Attribute.clearData()
    }
    static driver() {
        Chat.translate("Define a key to encrypt and decrypt your data")
        Attribute.getInput().setAttribute('name', 'cryptography')
        Chat.setValue()
    }
    static email() {
        Chat.translate("Set a secure password, it will be used to log into the system")
        Attribute.getInput().setAttribute('name', 'password')
        Chat.setValue()
    }
    static host() {
        Chat.translate("What database username " + Attribute.getInput().value + "?", Attribute.getInput().value)
        Attribute.getInput().setAttribute('name', 'username')
        Chat.setValue()
    }
    static name_user() {
        Chat.translate("What is your email?")
        Attribute.getInput().setAttribute('name', 'email')
        Chat.setValue()
    }
    static pass() {
        Chat.translate("What is your database name?")
        Attribute.getInput().setAttribute('name', 'base')
        Chat.setValue()
    }
    static password() {
        Element.getId('load-chat').setAttribute('style','')
        Attribute.setUrl(window.location.href)
        Attribute.setMethod('POST')
        Database.request(localStorage.getItem('data'))
        Attribute.getInput().setAttribute('name', 'end')
    }
    static user() {
        Chat.translate("What is your name?")
        Attribute.getInput().setAttribute('name', 'name_user')
        Chat.setValue()
    }
    static username() {
        Chat.translate("What is the user password " + Attribute.getInput().value + " from the database?",
            Attribute.getInput().value)
        Attribute.getInput().setAttribute('name', 'pass')
        Chat.setValue()
    }
    //LOGIN//
    static login() {
        Chat.translate("What is your email?")
        Attribute.getInput().setAttribute('name', 'login_email')
        Chat.setValue()
    }
    static login_email() {
        Chat.translate("What is your password?")
        Attribute.getInput().setAttribute('name', 'login_password')
        Chat.setValue()
    }
    static login_password() {
        Element.getId('load-chat').setAttribute('style','')
        Attribute.setUrl(window.location.href + '/login')
        Attribute.setMethod('POST')
        Database.request(localStorage.getItem('data'))
        Attribute.getInput().setAttribute('name', 'end')
    }
    //SYSTEM//
    static conversation() {
        Attribute.setInput(Element.getId('response'))
        if (Attribute.getInput().name) {
            localStorage.setItem('name', Attribute.getInput().name)
            let name = this[Attribute.getInput().name]
            if (typeof name === 'function') {
                name()
                return true
            }
        }
    }
    static response(data, request = 'ia') {
        let response
        let div
        response = Element.tag()
        div = Element.tag()
        response.setAttribute('class', 'response-' + request)
        div.setAttribute('class', 'chatbot-response-' + request)
        Element.getId('chatErykia')
            .appendChild(div)
            .appendChild(response)
        response.innerHTML += data
        if(!Attribute.getDeveloper()){
            Element.getId('response').value = ""
        }
    }
    static setValue() {
        Attribute.getInput().value = localStorage.getItem(Attribute.getInput().name) ?? ''
    }
    static translate(message, dynamic = null) {
        Element.getId('load-chat').setAttribute('style','')
        let translate = {}
        translate.text = message
        if (dynamic) {
            translate.dynamic = dynamic
        }
        Attribute.setUrl(window.location.href.replace("/ia", "") + "/component/language")
        Attribute.setMethod('POST')
        Database.request(JSON.stringify(translate))
    }
    //TRIGGER//
    static database() {
        Chat.translate("Sorry but I need you to enter all data correctly. " +
            "Where is your bank? ex: localhost")
        Attribute.getInput().setAttribute('name', 'host')
        Chat.setValue()
    }
    static env() {
        Attribute.setUrl(window.location.href)
        Attribute.setMethod('POST')
        Database.request('{"exist": "user"}')
    }
    static start() {
        Chat.translate("Hello my name is Erykia, let's program! " +
            "I need your mariadb or mysql database data. " +
            "Where is your bank? ex: localhost", "Erykia")
        Attribute.getInput().setAttribute('name', 'host')
        Chat.setValue()
    }
}