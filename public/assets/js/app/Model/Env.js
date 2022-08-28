import {Attribute} from "../Core/Attribute.js";
import {Chat} from "../Component/Chat.js";

export class Env {
    static index(response) {
        if(response.env){
            localStorage.removeItem('data')
            Attribute.getInput().setAttribute('name', 'env')
            Chat.conversation()
            return true
        }
        Attribute.getInput().setAttribute('name', 'start')
        Chat.conversation()
    }
}