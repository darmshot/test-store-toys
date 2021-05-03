

let isTest: boolean = true;

let testArray: number[] = [
    1,2,3
]

// Tupe
const contact:[string,number] =['Vilvet',123]

let any:any = 12

any='hello'
//--------

function sayMyName(name: string): void{
    console.log(name)
}

sayMyName('123')

//Never
function throwError(message: string):never{
    while (true){

    }

}
//Types
type Login = String


const login: Login = 'hello'

type ID = string | number

const id:ID = '2323'
