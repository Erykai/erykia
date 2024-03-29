import {Attribute} from "../Core/Attribute.js";
import {Chat} from "../Component/Chat/Chat.js";

export class Exist
{
    static index(response) {
        if(response.exist){
            localStorage.removeItem('data')
            Attribute.getInput().setAttribute('name', 'login')
            Chat.conversation('login')
            return;
        }
        Attribute.getInput().setAttribute('name', 'user')
        Chat.conversation('user')
    }
}