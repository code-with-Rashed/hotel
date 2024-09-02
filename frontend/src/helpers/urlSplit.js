export const urlSplit = (url, condition = '') => {
  if (url) {
    return url.split(condition)
  }
}
