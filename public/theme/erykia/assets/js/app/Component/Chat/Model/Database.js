import {Attribute} from "../../../Core/Attribute.js";
import {Element} from "../../../Core/Element.js";
import {Chat} from "../Chat.js";
import CoreDatabase from "../../../Core/Database.js";

export class Database
{
    //TRIGGER
    static database() {
        Chat.translate("Sorry but I need you to enter all data correctly. " +
            "Where is your bank? ex: localhost")
        Attribute.getInput().setAttribute('name', 'host')
        Chat.save()
    }
    static start() {
        Chat.translate("Hello my name is Erykia, let's program! " +
            "I need your mariadb or mysql database data. " +
            "Where is your bank? ex: localhost", "Erykia")
        Attribute.getInput().setAttribute('name', 'host')
        Attribute.getSend().setAttribute('name', 'database')
        Chat.save()
    }
    //FORM
    static base() {
        Chat.translate("Which drive of your database ex: mysql")
        Attribute.getInput().setAttribute('name', 'driver')
        Chat.save()
    }
    static cryptography() {
        Element.getId('load-chat').setAttribute('style','')
        Attribute.setUrl(window.location.href + '/database')
        Attribute.setMethod('POST')
        CoreDatabase.request(localStorage.getItem('data'))
        Attribute.clearData()
    }
    static driver() {
        Chat.translate("Define a key to encrypt and decrypt your data")
        Attribute.getInput().setAttribute('name', 'cryptography')
        Chat.save()
    }
    static host() {
        Chat.translate("What database username " + Attribute.getInput().value + "?", Attribute.getInput().value)
        Attribute.getInput().setAttribute('name', 'username')
        Chat.save()
    }
    static password() {
        Chat.translate("What is your database name?")
        Attribute.getInput().setAttribute('name', 'base')
        Chat.save()
    }
    static username() {
        Chat.translate("What is the user password " + Attribute.getInput().value + " from the database?",
            Attribute.getInput().value)
        Attribute.getInput().setAttribute('name', 'password')
        Chat.save()
    }
}