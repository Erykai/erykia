import {Chat} from "../Component/Chat.js";
import {Attribute} from "../Core/Attribute.js";
import {Element} from "../Core/Element.js";

export class User
{
    static index(response) {
        Chat.response(response.user)
        if(!Attribute.getDeveloper()){
            localStorage.clear()
        }else{
            localStorage.removeItem('data')
        }
        this.login()
    }
    static login()
    {
        Chat.response('Obrigada pelas informações, para continuar acesse: ' + window.location.href.replace("/ia", "")+ "/admin")
        Element.getId('send').remove()
        Element.getId('response').remove()
    }
}