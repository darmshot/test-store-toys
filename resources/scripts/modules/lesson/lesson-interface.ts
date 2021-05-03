interface Rect {
    readonly id: string
    color?: string
    size: {
        width: number
        height: number
    }
}

const rect1: Rect = {
    id: '123',
    size: {
        width: 2,
        height: 32
    }
}

const resct2 = {} as Rect
const rect3 = <Rect>{}

rect3.size = {
    width: 32,
    height: 324
}


//-----


interface RectWithAria extends Rect {
    getArea: () => number
}


const rect5: RectWithAria = {
    id: '12',
    size: {
        width: 20,
        height: 33
    },
    getArea() {
        return this.size.width * this.size.height
    }
}


interface IClock {
    time: Date

    setTime(date: Date): void
}

class Clock implements IClock {
    time = new Date()

    setTime(date: Date): void {
        this.time = date
    }
}


//-------------

interface Styles {
    [key: string]: string
}

const css = {
    border: '1px solid red',
    borderRadius: '5px'
}

