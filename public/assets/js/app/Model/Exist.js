import {Chat} from "../Component/Chat.js";
import {Element} from "../Core/Element.js";
import {Attribute} from "../Core/Attribute.js";

export class Exist
{
    static index(response) {
        if(response.exist){
            localStorage.removeItem('data')
            Chat.response('Desculpe mas agora você só pode falar comigo pelo painel acesse: ' + window.location.href.replace("/ia", "") + "/admin")
            Element.getId('send').remove()
            Element.getId('response').remove()
        }
        Attribute.getInput().setAttribute('name', 'user')
        Chat.conversation()
    }
}