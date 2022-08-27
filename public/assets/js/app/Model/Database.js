import {Chat} from "../Component/Chat.js";
import {Attribute} from "../Core/Attribute.js";

export class Database
{
    static index(response) {
        localStorage.removeItem('data')
        if(!Attribute.getDeveloper()){
            localStorage.clear()
        }
        Chat.response(response.database)
        Attribute.getInput().setAttribute('name', 'user')
        Chat.conversation()
    }
}