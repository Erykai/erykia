import {Element} from "../Core/Element.js";
import {Attribute} from "../Core/Attribute.js";
import {Database} from "../Core/Database.js";

export class Chat {
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

    static setValue()
    {
        Attribute.getInput().value = localStorage.getItem(Attribute.getInput().name) ?? ''
    }

    static conversation() {
        Attribute.setInput(Element.getId('response'))
        localStorage.setItem('name', Attribute.getInput().name)
        if (Attribute.getInput().name === 'start') {
            this.response("Olá meu nome é Erykia, #boraprogramar")
            this.response("preciso dos dados de seu banco mariadb ou mysql")
            this.response("Qual local do seu banco? ex: localhost")
            Attribute.getInput().setAttribute('name', 'host')
            this.setValue()
            return true
        }
        if (Attribute.getInput().name === 'database') {
            this.response("Desculpe mas preciso que informe todos dados corretamente")
            this.response("Qual local do seu banco? ex: localhost")
            Attribute.getInput().setAttribute('name', 'host')
            this.setValue()
            return true
        }
        if (Attribute.getInput().name === 'host') {
            this.response("Qual nome de usuário do banco de dados " + Attribute.getInput().value + "?")
            Attribute.getInput().setAttribute('name', 'username')
            this.setValue()
            return true
        }
        if (Attribute.getInput().name === 'username') {
            this.response("Qual a senha do usuário " + Attribute.getInput().value + " do banco de dados?")
            Attribute.getInput().setAttribute('name', 'pass')
            this.setValue()
            return true
        }
        if (Attribute.getInput().name === 'pass') {
            this.response("Qual nome da sua base de dados?")
            Attribute.getInput().setAttribute('name', 'base')
            this.setValue()
            return true
        }
        if (Attribute.getInput().name === 'base') {
            this.response("Qual drive do seu banco de dados ex: mysql")
            Attribute.getInput().setAttribute('name', 'driver')
            this.setValue()
            return true
        }
        if (Attribute.getInput().name === 'driver') {
            this.response("Defina uma chave para criptografar e descritografar seus dados")
            Attribute.getInput().setAttribute('name', 'cryptography')
            this.setValue()
            return true
        }
        if (Attribute.getInput().name === 'cryptography') {
            Attribute.setUrl(window.location.href)
            Attribute.setMethod('POST')
            Database.request(localStorage.getItem('data'))
            Attribute.clearData()
            return true
        }
        if (Attribute.getInput().name === 'env') {
            Attribute.setUrl(window.location.href)
            Attribute.setMethod('POST')
            Database.request('{"exist": "user"}')
            return true
        }
        if (Attribute.getInput().name === 'user') {
            this.response("Qual seu nome?")
            Attribute.getInput().setAttribute('name', 'name_user')
            this.setValue()
            return true
        }
        if (Attribute.getInput().name === 'name_user') {
            this.response("Qual seu email?")
            Attribute.getInput().setAttribute('name', 'email')
            this.setValue()
            return true
        }
        if (Attribute.getInput().name === 'email') {
            this.response("Defina uma senha segura, ela será usada para logar no sistema")
            Attribute.getInput().setAttribute('name', 'password')
            this.setValue()
            return true
        }
        if (Attribute.getInput().name === 'password') {
            Attribute.setUrl(window.location.href)
            Attribute.setMethod('POST')
            Database.request(localStorage.getItem('data'))
            Attribute.getInput().setAttribute('name', 'end')
            return true
        }
    }
}