import {Attribute} from "../../Core/Attribute.js";
import CoreDatabase from "../../Core/Database.js";
import {Element} from "../../Core/Element.js";
import Model from "./Core/Model.js";

export class Chat {
    static conversation(model) {
        Attribute.setInput(Element.getId('response'))
        if (Attribute.getInput().name) {
            localStorage.setItem('name', Attribute.getInput().name)
            let name = Model[model][Attribute.getInput().name]
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
    static save() {
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
        CoreDatabase.request(JSON.stringify(translate))
    }
}