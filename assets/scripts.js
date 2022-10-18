var gmTimeShow = 8000

/**
 * check email
 * @param {string} text
 * @returns boolean
 */
var isEmail = function (text) {
  var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
  return re.test(text)
}

/**
 * show the modal by removing the class and replacing it after x milliseconds
 * @param {string} target id
 * @param {string} classname hidden
 */
function showModal(target, classname) {
  var modal = document.getElementById(target)
  modal.classList.remove(classname)
  setTimeout(() => {
    modal.classList.add(classname)
  }, gmTimeShow)
}

/**
 * main function
 */
document.addEventListener('DOMContentLoaded', function () {
  // close modal
  document
    .getElementById('gm-contact-form-status')
    .addEventListener('click', function (e) {
      e.preventDefault()
      e.currentTarget.classList.add('gm-contact-form-status-hidden')
    })

  // token request ajax
  var tokenRequest = new XMLHttpRequest()
  tokenRequest.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      var res = JSON.parse(this.responseText)
      var form = document.getElementById('gm-contact-form')
      form.token.value = res.token
    }
  }
  tokenRequest.open('GET', '/wp-json/gm_contact_form/getToken')

  var form = document.getElementById('gm-contact-form')
  form.email.addEventListener('focus', function (e) {
    tokenRequest.send()
  })

  // error input
  var inputs = document.querySelectorAll(
    '#gm-contact-form input, #gm-contact-form textarea',
  )
  inputs.forEach((input) => {
    input.addEventListener(
      'invalid',
      (event) => {
        console.log(input)
        input.classList.add('error')
      },
      false,
    )
    input.addEventListener(
      'valid',
      (event) => {
        input.classList.remove('error')
      },
      false,
    )
  })

  // send form
  form.addEventListener('submit', function (e) {
    e.preventDefault()
    var form = e.currentTarget
    var button = form.querySelector('#gm-contact-form-submit')
    // input filled
    if (
      form.email.value !== '' &&
      form.name.value !== '' &&
      form.message.value !== '' &&
      isEmail(form.email.value)
    ) {
      var request = new XMLHttpRequest()
      request.onreadystatechange = function () {
        button.setAttribute('disabled', 'true')
        if (this.readyState == 4 && this.status == 200) {
          var res = JSON.parse(this.responseText)
          // error
          if (res.error) {
            // show wrapper modal
            showModal('gm-contact-form-status', 'gm-contact-form-status-hidden')
            // show message error
            showModal('gm-contact-form-error', 'gm-contact-form-modal-hidden')
            button.removeAttribute('disabled')

            return (document.querySelector(
              '.gm-contact-form-error span.gm-message',
            ).innerHTML = gmContactFormErrorMessage)
          }
          // success
          // show wrapper modal
          showModal('gm-contact-form-status', 'gm-contact-form-status-hidden')
          // show success message
          showModal('gm-contact-form-success', 'gm-contact-form-modal-hidden')
          form.reset()
          button.removeAttribute('disabled')
          return (document.querySelector(
            '.gm-contact-form-success span.gm-message',
          ).innerHTML = gmContactFormSuccessMessage)
        }
      }

      request.open('POST', '/wp-json/gm_contact_form/action')
      request.send(new FormData(e.currentTarget))
    }
  })
})
