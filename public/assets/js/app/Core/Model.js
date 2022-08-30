import {Database} from "../Model/Database.js";
import {Env} from "../Model/Env.js";
import {Error} from "../Model/Error.js";
import {Exist} from "../Model/Exist.js";
import {User} from "../Model/User.js";
import {Translate} from "../Model/Traslate.js";

export default {
    database: Database,
    env: Env,
    error: Error,
    exist: Exist,
    translate: Translate,
    user: User
}