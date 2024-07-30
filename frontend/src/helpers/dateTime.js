export const dateFormatter = (dateTime) => {
    const date = new Date(dateTime)
    return date.toLocaleDateString()
}
export const timeFormatter = (dateTime) => {
    const time = new Date(dateTime)
    return time.toLocaleTimeString()
}
