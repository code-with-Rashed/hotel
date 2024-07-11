export const hideBsModal = (id) => {
  const modal = document.getElementById(id)
  const div = document.createElement('div')
  div.setAttribute('data-bs-dismiss', 'modal')
  modal.append(div)
  div.click()
}
