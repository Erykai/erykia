import {Attribute} from "../Core/Attribute.js";
import {Chat} from "../Component/Chat.js";

export class Exist
{
    static index(response) {
        if(response.exist){
            localStorage.removeItem('data')
        }
        Attribute.getInput().setAttribute('name', 'login')
        Chat.conversation()
    }
}