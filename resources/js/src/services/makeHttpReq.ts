import axios from "axios";
import { APP } from "@/const/APP";
import { getUserData } from "./auth/userData";

type HttpVerbType = 'GET' | 'POST' | 'PUT' | 'PATCH' | 'DELETE'

export function makeHttpReq<TInput, TResponse>(
    endpoint:string,
    verb:HttpVerbType,
    input?:TInput
) {

    const userData = getUserData();

    return axios<TResponse>({
            method: verb,
            url: `${APP.apiBaseURL}/${endpoint}`,
            headers: {
                'content-type': 'application/json',
                'authorization': `Bearer ${userData?.token}`,
            },
            data: input
        }).then(res => res.data);
}
