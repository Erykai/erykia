import {Attribute} from "../Core/Attribute.js";
import {Chat} from "../Component/Chat/Chat.js";
export class Database
{
    static index(response) {
        localStorage.removeItem('data')
        if(!Attribute.getDeveloper()){
            localStorage.clear()
        }
        Chat.response(response.database)
        Attribute.getInput().setAttribute('name', 'user')
        Chat.conversation('user')
    }
}