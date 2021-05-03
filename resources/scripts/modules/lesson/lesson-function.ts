function toUpperCase(value: string): string {
    return value.trim().toUpperCase()
}

interface MyPosition {
    x: number | undefined,
    y: number | undefined
}

interface MyPositionWidthDefault extends MyPosition {
    default: string
}

function position(): MyPosition
function position(a: number): MyPositionWidthDefault
function position(a: number, b: number): MyPosition

function position(a?: number, b?: number) {
    if (!a && !b) {
        return {x: undefined, y: undefined}
    }

    if (a && !b) {
        return {x: a, y: undefined, default: a.toString()}
    }else {
        return {x: a, y: b}
    }

}

console.log('Empty: ', position())
console.log('One param: ', position(42))
console.log('Two param: ', position(10, 15))

