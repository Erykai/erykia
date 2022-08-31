import {Attribute} from "../Core/Attribute.js";
import {Chat} from "../Component/Chat/Chat.js";

export class User {
    static index(response) {
        Chat.response(response.user)
        if (!Attribute.getDeveloper()) {
            localStorage.clear()
        } else {
            localStorage.removeItem('data')
        }
        this.login()
    }

    static login() {
        alert('faça login')
    }
}