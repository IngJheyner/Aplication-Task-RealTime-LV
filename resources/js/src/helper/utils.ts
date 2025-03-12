export function myDebounce<T>(func:() => Promise<T>, delay:number) {
    let timer:any;

    return function() {
        clearTimeout(timer);
        setTimeout(() => func(), delay);
    }
}
