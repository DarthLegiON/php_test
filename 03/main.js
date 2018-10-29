class NotFoundValidateException extends Error {
  constructor(message, type) {
    super(message)
    this.notFoundType = type
  }
}

class ValidationManager {
  /**
   *
   * @param locale
     */
  constructor(locale = false) {
    if (!locale) locale = 'ru'
    this.setLocalale(locale)
  }

  validate (value, validationType) {
    try {
      let regExp = this[validationType]
      if (!regExp) {
        throw new NotFoundValidateException('undefined validation type:', validationType)
      }
      return regExp.test(value)
    } catch(err) {
      console.debug(err.message, err.notFoundType)
    }
  }

  setLocalale (locale) {
    this.local = locale
  }

  /**
   * define private interface
  */

  get letters () {
    return new RegExp(/^([a-zа-яёA-ZА-Яё]+)$/i)
  }

  get numbers () {
    return  new RegExp(/^([0-9]+)$/i)
  }

  //disagrating mask (ru locale)
  get phone () {
    if(this.locale && locale !== 'ru') {
      //different strategy
    }
    //Format: (xxx) xxx-xx-xx
    let regex = new RegExp(/\([0-9]{3}\)\s[0-9]{3}-[0-9]{2}-[0-9]{2}$/)
    return regex
  }

  get email () {
    return new RegExp(/^[-._a-z0-9]+@(?:[a-z0-9][-a-z0-9]+\.)+[a-z]{2,6}$/)
  }
}

window.onload = () => {
    let validateBtn = document.querySelector('#validate-button')
    let validator = new ValidationManager()
    let lettersInput = document.querySelector('#letters')
    let numbersInput = document.querySelector('#numbers')
    let emailInput = document.querySelector('#email')
    let phoneInput = document.querySelector('#phone')
    validateBtn.onclick = (e) => {
      console.clear()
      e.preventDefault()
      let vLetters = validator.validate(lettersInput.value, 'letters')
      let vNumers = validator.validate(numbersInput.value, 'numbers')
      let vEmail = validator.validate(emailInput.value, 'email')
      let vPhone = validator.validate(phoneInput.value, 'phone')
      let exeptionRun = validator.validate(phoneInput.value, 'test')
      console.debug('letters', vLetters)
      console.debug('numbers', vNumers)
      console.debug('email', vEmail)
      console.debug('phone', vPhone)
    }
}
