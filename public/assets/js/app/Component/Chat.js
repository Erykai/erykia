import {Attribute} from "../Core/Attribute.js";
import {Database} from "../Core/Database.js";
import {Element} from "../Core/Element.js";

export class Chat {
    //INPUT//
    static base() {
        Chat.response("Qual drive do seu banco de dados ex: mysql")
        Attribute.getInput().setAttribute('name', 'driver')
        Chat.setValue()
    }
    static cryptography() {
        Attribute.setUrl(window.location.href)
        Attribute.setMethod('POST')
        Database.request(localStorage.getItem('data'))
        Attribute.clearData()
    }
    static driver() {
        Chat.response("Defina uma chave para criptografar e descritografar seus dados")
        Attribute.getInput().setAttribute('name', 'cryptography')
        Chat.setValue()
    }
    static email() {
        Chat.response("Defina uma senha segura, ela será usada para logar no sistema")
        Attribute.getInput().setAttribute('name', 'password')
        Chat.setValue()
    }
    static host() {
        Chat.response("Qual nome de usuário do banco de dados " + Attribute.getInput().value + "?")
        Attribute.getInput().setAttribute('name', 'username')
        Chat.setValue()
    }
    static name_user() {
        Chat.response("Qual seu email?")
        Attribute.getInput().setAttribute('name', 'email')
        Chat.setValue()
    }
    static pass() {
        Chat.response("Qual nome da sua base de dados?")
        Attribute.getInput().setAttribute('name', 'base')
        Chat.setValue()
    }
    static password() {
        Attribute.setUrl(window.location.href)
        Attribute.setMethod('POST')
        Database.request(localStorage.getItem('data'))
        Attribute.getInput().setAttribute('name', 'end')
    }
    static user() {
        Chat.response("Qual seu nome?")
        Attribute.getInput().setAttribute('name', 'name_user')
        Chat.setValue()
    }
    static username() {
        Chat.response("Qual a senha do usuário " + Attribute.getInput().value + " do banco de dados?")
        Attribute.getInput().setAttribute('name', 'pass')
        Chat.setValue()
    }
    //SYSTEM//
    static conversation() {
        Attribute.setInput(Element.getId('response'))
        if(Attribute.getInput().name){
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
        Element.getId('response').value = ""
    }
    static setValue() {
        Attribute.getInput().value = localStorage.getItem(Attribute.getInput().name) ?? ''
    }
    //TRIGGER//
    static database() {
        Chat.response("Desculpe mas preciso que informe todos dados corretamente")
        Chat.response("Qual local do seu banco? ex: localhost")
        Attribute.getInput().setAttribute('name', 'host')
        Chat.setValue()
    }
    static env() {
        Attribute.setUrl(window.location.href)
        Attribute.setMethod('POST')
        Database.request('{"exist": "user"}')
    }
    static start() {
        Chat.response("Olá meu nome é Erykia, #boraprogramar")
        Chat.response("preciso dos dados de seu banco mariadb ou mysql")
        Chat.response("Qual local do seu banco? ex: localhost")
        Attribute.getInput().setAttribute('name', 'host')
        Chat.setValue()
    }
}