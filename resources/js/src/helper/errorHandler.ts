import axios, { AxiosError } from "axios"
import { showError } from "@/helper/toast-notification"

interface ValidationErrorResponse {
    message: string;
    errors: {
        [key: string]: string[];
    };
}

export class ApiError extends Error {
    constructor(message: string, public statusCode?: number) {
        super(message);
        this.name = 'ApiError';
    }
}

export function handleAxiosError(error: unknown) {
    if (axios.isAxiosError(error)) {
        const axiosError = error as AxiosError<ValidationErrorResponse>;

        // Manejar errores de validación
        if (axiosError.response?.data?.errors) {
            const { errors } = axiosError.response.data;
            for (const field in errors) {
                errors[field].forEach(errorMessage => {
                    showError(`${errorMessage}`);
                });
            }
        }
        else if (axiosError.response?.data?.message) {
            showError(axiosError.response.data.message);
            return;
        }
        // Manejar otros tipos de errores
        else {
            switch (axiosError.response?.status) {
                case 400:
                    showError('400: Solicitud incorrecta');
                    break;
                case 403:
                    showError('403: No tiene permisos para realizar esta acción');
                break;
                case 404:
                    showError('404: Recurso no encontrado');
                break;
                default:
                    showError('Error en la solicitud');
                    break;
            }
        }
    } else {
        showError('Error inesperado');
    }
}
