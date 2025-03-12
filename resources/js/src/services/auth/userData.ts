import { handleError } from "vue";
import { LoginResponseType } from "./login";

export function getUserData():LoginResponseType|undefined {

    try {

        const userData = localStorage.getItem('user');
        const connectdUser:LoginResponseType = typeof userData !== 'object' ? JSON.parse(userData) : undefined;
        if(connectdUser === undefined)
            throw new Error('User is not connected');
        return connectdUser;

    } catch (error) {
        console.log((error as Error).message);
    }
}
