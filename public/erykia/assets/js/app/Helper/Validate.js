import {Chat} from "../Component/Chat/Chat.js";

export class Validate {
    static message = ''
    static regex
    static value

    static index(input) {
        return this.validate(input)
    }
    static response(input) {
        Chat.translate(`invalid ${input.name}${this.message}`)
    }
    static validate(input) {
        if (input.name === 'name') {
            this.regex = /[a-zA-Z ]{3,}$/
            this.value = input.value
        }
        if (input.name === 'email') {
            this.regex = /\S+@\S+\.\S+/
            this.value = input.value
        }
        // if (input.name === 'password') {
        //     this.regex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/;
        //     this.value = input.value
        //     this.message = ` minimum 8 characters with at least 1 uppercase letter 1 lowercase letter and numbers`
        // }
        if(this.regex){
            if(!this.regex.test(this.value)){
                this.response(input)
                return false
            }
        }
        return true;

    }

}