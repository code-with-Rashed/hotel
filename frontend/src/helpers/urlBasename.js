export const urlBasename = (url, invalidResponse = false) => {
  let basename
  try {
    const handleUrl = new URL(url)
    const parseUrl = handleUrl.host.split('.')
    basename = parseUrl[parseUrl.length - 2]
  } catch (error) {
    basename = invalidResponse
  }
  return basename
}
