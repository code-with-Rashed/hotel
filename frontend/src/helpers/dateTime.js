export const dateFormatter = (dateTime) => {
  const date = new Date(dateTime)
  return date.toLocaleDateString()
}
export const timeFormatter = (dateTime) => {
  const time = new Date(dateTime)
  return time.toLocaleTimeString()
}
export const todayDate = () => {
  const month =
    new Date().getMonth() + 1 > 9 ? new Date().getMonth() + 1 : '0' + (new Date().getMonth() + 1)
  return new Date().getFullYear() + '-' + month + '-' + new Date().getDate()
}
