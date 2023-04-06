import {Attribute} from "../Core/Attribute.js";
import {Element} from "../Core/Element.js";
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
        let  url = `${window.location.href.replace("/ia", "")}`
        Chat.translate(`Ready now just program! access:  <a style="color: #fff" target="_blank" href="${url}/dashboard  ">Dashboard</a>`,
            `<a style="color: #fff" target="_blank" href="${url}/`
        )
        Element.getId('send').remove()
        Element.getId('response').remove()

    }
}