import {Attribute} from "../Core/Attribute.js";
import {Chat} from "../Component/Chat/Chat.js";

export class Env {
    static index(response) {
        if(response.env){
            Attribute.getInput().setAttribute('name', 'env')
            Chat.conversation('user')
            return true
        }
        Attribute.getInput().setAttribute('name', 'start')
        Chat.conversation('database')
    }
}