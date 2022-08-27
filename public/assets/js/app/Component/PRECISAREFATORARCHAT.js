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

    static setValue() {
        Attribute.getInput().value = localStorage.getItem(Attribute.getInput().name) ?? ''
    }

    static start() {
        console.log('kieu')
        this.response("Olá meu nome é Erykia, #boraprogramar")
        this.response("preciso dos dados de seu banco mariadb ou mysql")
        this.response("Qual local do seu banco? ex: localhost")
        Attribute.getInput().setAttribute('name', 'host')
        this.setValue()
    }

    static database() {
        this.response("Desculpe mas preciso que informe todos dados corretamente")
        this.response("Qual local do seu banco? ex: localhost")
        Attribute.getInput().setAttribute('name', 'host')
        this.setValue()
    }

    static host() {
        this.response("Qual nome de usuário do banco de dados " + Attribute.getInput().value + "?")
        Attribute.getInput().setAttribute('name', 'username')
        this.setValue()
    }

    static username()
    {
        this.response("Qual a senha do usuário " + Attribute.getInput().value + " do banco de dados?")
        Attribute.getInput().setAttribute('name', 'pass')
        this.setValue()
    }

    static pass()
    {
        this.response("Qual nome da sua base de dados?")
        Attribute.getInput().setAttribute('name', 'base')
        this.setValue()
    }

    static base()
    {
        this.response("Qual drive do seu banco de dados ex: mysql")
        Attribute.getInput().setAttribute('name', 'driver')
        this.setValue()
    }

    static driver()
    {
        this.response("Defina uma chave para criptografar e descritografar seus dados")
        Attribute.getInput().setAttribute('name', 'cryptography')
        this.setValue()
    }

    static cryptography()
    {
        Attribute.setUrl(window.location.href)
        Attribute.setMethod('POST')
        Database.request(localStorage.getItem('data'))
        Attribute.clearData()
    }

    static env()
    {
        Attribute.setUrl(window.location.href)
        Attribute.setMethod('POST')
        Database.request('{"exist": "user"}')
    }

    static user()
    {
        this.response("Qual seu nome?")
        Attribute.getInput().setAttribute('name', 'name_user')
        this.setValue()
    }

    static name_user()
    {
        this.response("Qual seu email?")
        Attribute.getInput().setAttribute('name', 'email')
        this.setValue()
    }

    static email()
    {
        this.response("Defina uma senha segura, ela será usada para logar no sistema")
        Attribute.getInput().setAttribute('name', 'password')
        this.setValue()
    }

    static password()
    {
        Attribute.setUrl(window.location.href)
        Attribute.setMethod('POST')
        Database.request(localStorage.getItem('data'))
        Attribute.getInput().setAttribute('name', 'end')
    }

    static conversation() {
        Attribute.setInput(Element.getId('response'))
        localStorage.setItem('name', Attribute.getInput().name)
        //ORGANIZAR PARA FICAR DINAMICO
        // let name = this[Attribute.getInput().name]
        // if(typeof name === 'function'){
        //     return name
        // }

        if (Attribute.getInput().name === 'start') {
            this.start()
            return true
        }
        if (Attribute.getInput().name === 'database') {
            this.database()
            return true
        }
        if (Attribute.getInput().name === 'host') {
            this.host()
            return true
        }
        if (Attribute.getInput().name === 'username') {
            this.username()
            return true
        }
        if (Attribute.getInput().name === 'pass') {
            this.pass()
            return true
        }
        if (Attribute.getInput().name === 'base') {
            this.base()
            return true
        }
        if (Attribute.getInput().name === 'driver') {
            this.driver()
            return true
        }
        if (Attribute.getInput().name === 'cryptography') {
            this.cryptography()
            return true
        }
        if (Attribute.getInput().name === 'env') {
            this.env()
            return true
        }
        if (Attribute.getInput().name === 'user') {
            this.user()
            return true
        }
        if (Attribute.getInput().name === 'name_user') {
            this.name_user()
            return true
        }
        if (Attribute.getInput().name === 'email') {
            this.email()
            return true
        }
        if (Attribute.getInput().name === 'password') {
            this.password()
            return true
        }
    }
}