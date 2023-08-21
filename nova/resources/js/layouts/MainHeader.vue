<template>
  <div>
    <header
      class="bg-white dark:bg-gray-800 flex items-center h-14 shadow-b dark:border-b dark:border-gray-700"
    >
      <button
        @click.prevent="hello"
        class="lg:hidden inline-flex items-center justify-center ml-1 w-12 h-12 rounded-lg focus:ring focus:ring-inset focus:outline-none ring-primary-200 dark:ring-gray-600"
        :aria-label="__('Toggle Sidebar')"
        :aria-expanded="mainMenuShown ? 'true' : 'false'"
      >
        <Icon type="menu" />
      </button>

      <div class="hidden lg:w-60 flex-shrink-0 md:flex items-center">
        <Link
          :href="$url('/')"
          class="text-gray-900 hover:text-gray-500 active:text-gray-900 dark:text-gray-400 dark:hover:text-gray-300 dark:active:text-gray-500 h-12 rounded-lg flex items-center ml-2 focus:ring focus:ring-inset focus:outline-none ring-primary-200 dark:ring-gray-600 px-4"
          :aria-label="appName"
        >
          <AppLogo class="h-6" />
        </Link>

        <!-- <LicenseWarning /> -->
      </div>

      <div class="flex flex-1 px-4 sm:px-8 lg:px-12">
        <GlobalSearch
          class="relative z-10"
          v-if="globalSearchEnabled"
          dusk="global-search-component"
        />

        <div class="flex items-center pl-6 ml-auto">
          

          <!-- <div
            v-if="
              currentUser &&
              currentUser.role == 'user' &&
              currentUser.credit == true
            "
            class="px-4 py-2 font-bold border rounded bg-red-200"
            
          >
            <span>
              Please contact Vos Support to resolve your negative balance
            </span>
          </div> -->

          <Modal
            v-if="
                currentUser &&
                currentUser.role == 'user' &&
                currentUser.credit == true
              "
            data-testid="delete-resource-modal"
            :show="true"
            role="alertdialog"
            maxWidth="sm"
          >
            <form
              @submit.prevent="$emit('confirm')"
              class="mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden"
            >
              <slot>
                <ModalHeader v-text="__('Low Balance Alert')" />
                <ModalContent>
                  <p class="leading-normal">
                    {{
                      __(
                        'Please contact Vos Support to resolve your negative balance'
                      )
                    }}
                  </p>
                </ModalContent>
              </slot>

              <ModalFooter>
                <div class="ml-auto">
                  <!-- <LinkButton
                    type="button"
                    data-testid="cancel-button"
                    dusk="cancel-delete-button"
                    @click.prevent="$emit('close')"
                    class="mr-3"
                  >
                    {{ __('Cancel') }}
                  </LinkButton>

                  <LoadingButton
                    ref="confirmButton"
                    dusk="confirm-delete-button"
                    :processing="working"
                    :disabled="working"
                    component="DangerButton"
                    type="submit"
                  >
                    {{ __(uppercaseMode) }}
                  </LoadingButton> -->
                </div>
              </ModalFooter>
            </form>
          </Modal>

          
          <div
            v-if="
              currentUser &&
              (currentUser.role == 'user' || currentUser.role == 'company')
            "
            class="px-4 py-2 font-bold border rounded hidden md:block"
            :class="{ 'bg-red-200': currentUser.formated_number < 0 }"
          >
            <!-- <a href="javascript:void(0)" @click="show = true,loading=false"
              >${{ currentUser.formated_number }} USD</a
            > -->
            <!-- <a href="javascript:void(0)" -->
            <a href="javascript:void(0)" @click="show=true"
              >${{ currentUser.balance }} USD</a
            >
          </div>

          <ThemeDropdown />
          <NotificationCenter v-if="notificationCenterEnabled" />
          <UserMenu class="hidden md:flex ml-2" />
        </div>
      </div>
    </header>
    <Modal :show="show" data-testid="payment-modal" role="alertdialog">
            <form
              @submit.prevent="submit"
              class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden"
              style="width: 460px"
            >
                <ModalHeader v-text="__('Payment')" />
                <ModalContent>
                  <span>Thank you for choosing Vos Logic, Reach out to your account rep to top up your balance</span>    
                </ModalContent>
                <ModalFooter>
                    <div class="ml-auto">
                        <LinkButton
                        dusk="cancel-upload-delete-button"
                        type="button"
                        @click.prevent="show = false"
                        class="mr-3"
                        >
                        {{ __('Cancel') }}
                        </LinkButton>
                        
                    </div>
                </ModalFooter>
            </form>
        </Modal>
    <!-- card modal start -->
    <!-- <Modal :show="show" data-testid="payment-modal" role="alertdialog">
      <form
        @submit.prevent="submit"
        class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden"
        style="width: 460px"
      >
        <ModalHeader v-text="__('Payment')" />
        <ModalContent>
          <div class="flex relative w-full mb-2">
            <input
              class="w-full form-control form-input form-input-bordered"
              ref="number"
              id="number"
              type="text"
              placeholder="Card number"
              v-model="number"
              @input="validateCnumber"
              v-on:keydown="formatCardNumber"
              v-on:keypress="isLetter($event)"
              required
              maxlength="19"
              name="usrnm"
            />
            <img
              class="icon"
              id="icon"
              v-if="brand == 'unknown'"
              src="https://raw.githubusercontent.com/aaronfagan/svg-credit-card-payment-icons/master/mono/generic.svg?sanitize=true"
              alt="Generic Card"
            />
            <img
              class="icon"
              id="icon"
              v-if="brand == 'visa'"
              src="https://raw.githubusercontent.com/aaronfagan/svg-credit-card-payment-icons/master/flat/visa.svg?sanitize=true"
              alt="Generic Card"
            />
            <img
              class="icon"
              id="icon"
              v-if="brand == 'mastercard'"
              src="https://raw.githubusercontent.com/aaronfagan/svg-credit-card-payment-icons/master/flat/mastercard.svg?sanitize=true"
              alt="Generic Card"
            />
            <img
              class="icon"
              id="icon"
              v-if="brand == 'jcb'"
              src="https://raw.githubusercontent.com/aaronfagan/svg-credit-card-payment-icons/master/flat/jcb.svg?sanitize=true"
              alt="Generic Card"
            />
            <img
              class="icon"
              id="icon"
              v-if="brand == 'amex'"
              src="https://raw.githubusercontent.com/aaronfagan/svg-credit-card-payment-icons/master/flat/amex.svg?sanitize=true"
              alt="Generic Card"
            />
            <img
              class="icon"
              id="icon"
              v-if="brand == 'discover'"
              src="https://raw.githubusercontent.com/aaronfagan/svg-credit-card-payment-icons/master/flat/discover.svg?sanitize=true"
              alt="Generic Card"
            />
            <img
              class="icon"
              id="icon"
              v-if="brand == 'dinersclub'"
              src="https://raw.githubusercontent.com/aaronfagan/svg-credit-card-payment-icons/master/flat/diners.svg?sanitize=true"
              alt="Generic Card"
            />
          </div>
          <div class="flex relative w-full mb-2">
            <input
              class="input-field-exp"
              ref="expiry"
              id="expiry"
              type="text"
              placeholder="MM/YY"
              v-model="expiry"
              @input="validateCexpiry"
              v-on:keydown="formatCardExpiry"
              @keyup.delete="backEvent"
              v-on:keypress="isLetter($event)"
              required
              maxlength="5"
              name="usrnm"
            />
            <input
              class="input-field-cvc"
              ref="cvv"
              id="cvv"
              type="text"
              placeholder="CVC"
              v-model="cvv"
              @input="validateCcvv"
              v-on:keypress="isLetter($event)"
              @keyup.delete="backEventCvc"
              required
              maxlength="4"
              name="usrnm"
            />
            <input
              class="input-field-zip"
              ref="zip"
              id="zip"
              type="text"
              placeholder="Zip/Postal code"
              v-model="zip"
              @input="validateCzip"
              v-on:keypress="isLetter($event)"
              @keyup.delete="backEventZip"
              required
              maxlength="5"
              name="usrnm"
            />
          </div>
          <div class="flex relative w-full mt-3 mb-2">
            <input
              class="w-full form-control form-input form-input-bordered"
              ref="amount"
              id="amount"
              type="text"
              placeholder="Enter Amount"
              v-model="result.amount"
              required
              name="amount"
            />
            </div>
        </ModalContent>
        <ModalFooter>
          <div class="ml-auto">
            <LinkButton
              dusk="cancel-upload-delete-button"
              type="button"
              @click.prevent="show = false"
              class="mr-3"
            >
              {{ __('Cancel') }}
            </LinkButton>
            <LoadingButton
              type="submit"
              class="flex-shrink-0 shadow rounded focus:outline-none ring-primary-200 dark:ring-gray-600 focus:ring bg-primary-500 hover:bg-primary-400 active:bg-primary-600 text-white dark:text-gray-800 inline-flex items-center font-bold px-4 h-9 text-sm flex-shrink-0"
              :loading="loading"
              @click="loading=false"
            >
              Pay
            </LoadingButton>
          </div>
        </ModalFooter>
      </form>
    </Modal> -->
    <!-- card modal end -->
    <!-- Mobile Sidebar -->
    <div class="lg:hidden w-60" :class="{ hidden: !mainMenuShown }">
      <div class="fixed inset-0 flex z-40">
        <div class="fixed inset-0" aria-hidden="true">
          <div
            @click="toggleMainMenu"
            class="absolute inset-0 bg-gray-600 dark:bg-gray-900 opacity-75"
          />
        </div>

        <div
          class="bg-white dark:bg-gray-800 relative flex-1 flex flex-col max-w-xxs w-full"
        >
          <div class="absolute top-0 right-0 -mr-12 pt-2">
            <button
              @click.prevent="hello"
              class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
              :aria-label="__('Close Sidebar')"
            >
              <!-- Heroicon name: outline/x -->
              <svg
                class="h-6 w-6 text-white"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                aria-hidden="true"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M6 18L18 6M6 6l12 12"
                />
              </svg>
            </button>
          </div>

          <div v-if="currentUser" class="hidden md:block">
            {{ currentUser.balance }}
          </div>
          <div class="px-2 border-b border-gray-100 dark:border-gray-700">
            <Link
              :href="$url('/')"
              class="h-12 px-2 rounded-lg flex items-center focus:ring focus:ring-inset focus:outline-none text-black"
              :aria-label="appName"
            >
              <AppLogo class="h-6" />
            </Link>
          </div>

          <div class="overflow-x-auto">
            <MainMenu class="mt-3 px-2" />
          </div>

          <div
            class="bg-white dark:bg-gray-800 absolute left-0 bottom-0 right-0 py-1 px-2 md:hidden border-t border-gray-100 dark:border-gray-700"
          >
            <UserMenu />
          </div>

          <div class="flex-shrink-0 w-14" aria-hidden="true">
            <!-- Dummy element to force sidebar to shrink to fit close icon -->
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapMutations } from 'vuex'
import LicenseWarning from '@/components/LicenseWarning'
window.io = require('socket.io-client');

export default {
  methods: mapMutations(['toggleMainMenu']),
  components: { LicenseWarning },
  data() {
    return {
      show: false,
      loading: false,
      number: null,
      phone: null,
      expiry: null,
      cvv: null,
      zip: null,
      brand: 'unknown',
      result: {
        amount:null,
        card: {
          number: null,
          brand: null,
          expiration: null,
          cvc: null,
          postalCode: null,
        },
      },
    }
  },
  created(){
    this.loading = false;
    window.socket = window.io(window.location.origin);

    window.socket.on("connect", () => {
        console.log(socket.id); // x8WIv7-mJelg7on_ALbx
    });

    socket.on('connect', function () {
        console.log('socket connected')
    })
    socket.emit('subscribe', {
        channel: 'rvm_database_progress-bar'
    })

    window.socket.on("disconnect", () => {
        console.log(socket.id); // undefined
    });

    socket.on('App\\Events\\UpdateProgressBar', function (channel, data) {
        Nova.$emit('change-progress-'+data.campaign.id, {progress: data.progress});
    })
  },
  watch: {
    mainMenuShown(newValue) {
      if (newValue == true) {
        document.body.classList.add('overflow-y-hidden')
        return
      }

      document.body.classList.remove('overflow-y-hidden')
    },
  },

  beforeUnmount() {
    document.body.classList.remove('overflow-y-hidden')
  },

  computed: {
    ...mapGetters(['mainMenuShown', 'currentUser']),

    globalSearchEnabled() {
      return Nova.config('globalSearchEnabled')
    },

    notificationCenterEnabled() {
      return Nova.config('notificationCenterEnabled')
    },

    appName() {
      return Nova.config('appName')
    },
  },
  methods: {
    hello() {
      console.log('hello');
      this.$store.commit('toggleMainMenu');
    },
    async submit() {
      this.loading = true;
      
      let data = {
        card : this.result.card,
        amount : this.result.amount
      };
      // let amount = this.result.amount;
      let params = data
     
      await Nova.request().post('/nova-api/custom/payment', params)
      .then(response => {
        this.loading = false;
        this.show = false;
        if(response.data.data.success){
          Nova.success('Balance added successfully.');
        }else{
          Nova.error('Error In Payment Process.');
        }
        
        
      })
      
    },
    formatCardNumber() {
      console.log('formatCardNumber')
      let number = this.number.replace(/\D/g, '')
      this.number = number ? number.match(/.{1,4}/g).join(' ') : ''
      // console.log('this.number')
      // console.log(this.number)

      // VueCookies.set('number',)
      // return  this.number ? this.number.match(/.{1,4}/g).join(' ') : '';
    },
    isLetter(e) {
      let char = String.fromCharCode(e.keyCode) // Get the character
      if (/^[0-9]+$/.test(char)) return true // Match with regex
      else e.preventDefault() // If not match, don't add to input text
    },
    validateCnumber() {
      let value = this.number
      this.result.card.number = value
      console.log('this.result.card.number')
      console.log(this.result.card.number)
      console.log(value)
      let visa = value.replace(/\D/g, '').match(/^4[0-9]{12}(?:[0-9]{3})?$/)

      let master = value
        .replace(/\D/g, '')
        .match(
          /^(5[1-5][0-9]{14}|2(22[1-9][0-9]{12}|2[3-9][0-9]{13}|[3-6][0-9]{14}|7[0-1][0-9]{13}|720[0-9]{12}))$/
        )

      let jcb = value.replace(/\D/g, '').match(/^(?:2131|1800|35\d{3})\d{11}$/)

      let amex = value.replace(/\D/g, '').match(/^3[47][0-9]{13}$/)

      let discover = value
        .replace(/\D/g, '')
        .match(
          /^65[4-9][0-9]{13}|64[4-9][0-9]{13}|6011[0-9]{12}|(622(?:12[6-9]|1[3-9][0-9]|[2-8][0-9][0-9]|9[01][0-9]|92[0-5])[0-9]{10})$/
        )

      let dinersclub = value
        .replace(/\D/g, '')
        .match(/^3(?:0[0-5]|[68][0-9])[0-9]{11}$/)

      if (visa) {
        console.log('visa')
        // console.log(visa.input.length)

        if (visa.input.length > 15) {
          document.getElementById('number').classList.remove('invalid-field')
          document.getElementById('icon').classList.remove('invalid-field')
          document.getElementById('number').classList.add('valid-field')
          document.getElementById('icon').classList.add('valid-field')
          window.setTimeout(() => document.getElementById('expiry').focus(), 0)
          // alert(document.getElementById('expiry'))
          this.brand = 'visa'
          this.result.card.brand = 'visa'

          return false
        }
        // this.brand = 'visa'
      }

      if (master) {
        document.getElementById('number').classList.remove('invalid-field')
        document.getElementById('icon').classList.remove('invalid-field')
        document.getElementById('number').classList.add('valid-field')
        document.getElementById('icon').classList.add('valid-field')
        window.setTimeout(() => document.getElementById('expiry').focus(), 0)
        this.brand = 'mastercard'
        this.result.card.brand = 'mastercard'

        return false
      }

      if (jcb) {
        document.getElementById('number').classList.remove('invalid-field')
        document.getElementById('icon').classList.remove('invalid-field')
        document.getElementById('number').classList.add('valid-field')
        document.getElementById('icon').classList.add('valid-field')
        window.setTimeout(() => document.getElementById('expiry').focus(), 0)

        this.brand = 'jcb'
        this.result.card.brand = 'jcb'

        return false
      }

      if (amex) {
        document.getElementById('number').classList.remove('invalid-field')
        document.getElementById('icon').classList.remove('invalid-field')
        document.getElementById('number').classList.add('valid-field')
        document.getElementById('icon').classList.add('valid-field')
        window.setTimeout(() => document.getElementById('expiry').focus(), 0)

        this.brand = 'amex'
        this.result.card.brand = 'amex'

        return false
      }

      if (discover) {
        document.getElementById('number').classList.remove('invalid-field')
        document.getElementById('icon').classList.remove('invalid-field')
        document.getElementById('number').classList.add('valid-field')
        document.getElementById('icon').classList.add('valid-field')
        window.setTimeout(() => document.getElementById('expiry').focus(), 0)

        this.brand = 'discover'
        this.result.card.brand = 'discover'

        return false
      }

      if (dinersclub) {
        document.getElementById('number').classList.remove('invalid-field')
        document.getElementById('icon').classList.remove('invalid-field')
        document.getElementById('number').classList.add('valid-field')
        document.getElementById('icon').classList.add('valid-field')
        window.setTimeout(() => document.getElementById('expiry').focus(), 0)

        this.brand = 'dinersclub'
        this.result.card.brand = 'dinersclub'

        return false
      }
      document.getElementById('number').classList.remove('valid-field')
      document.getElementById('icon').classList.remove('valid-field')
      document.getElementById('number').classList.add('invalid-field')
      document.getElementById('icon').classList.add('invalid-field')
      this.brand = 'unknown'
    },
    validateCexpiry(event) {
      if (!this.expiry.includes('/')) {
        let expiry = this.expiry.replace(/\D/g, '')
        this.expiry = expiry ? expiry.match(/.{1,2}/g).join('/') : ''
      }
      let value = this.expiry

      this.result.card.expiration = value
      console.log('this.result.card.expiration')
      console.log(this.result.card.expiration)

      console.log(value.replace(/[^0-9\.]+/g, '').length)
      var input = document.getElementById('expiry')
      console.log('input')
      console.log(input.value.replace(/[^0-9\.]+/g, '').length)

      input.addEventListener('keydown', function (event) {
        const key = event.key
        // console.log('key')
        // console.log(key)
        if (
          key === 'Backspace' &&
          input.value.replace(/[^0-9\.]+/g, '').length == 0
        ) {
          document.getElementById('number').focus()
          console.log('backspace')
          return
        }
      })

      let month = value.split('/')[0]
      let year = value.split('/')[1]

      let currentYear = new Date().getYear()
      let currentMonth = new Date().getMonth()

      let today = new Date()
      let someday = new Date()
      someday.setFullYear('20' + year, month, 1)

      if (someday > today) {
        //valid
        console.log('someday > today')
        console.log(value)
        // document.getElementById('cvv').focus()
        if (value.length == 5)
          window.setTimeout(() => document.getElementById('cvv').focus(), 0)

        return false
      } else {
        console.log('someday < today')

        console.log(value)
      }

      if (month < currentMonth) {
        console.log('month not valid')
      }
    },
    backEvent() {
      // console.clear()
      console.log('backbbbbbb')
      console.log('this.expiry')
      console.log(this.expiry)
      if (this.expiry === null || this.expiry === '') {
        var tNumber = this.number
        this.number = tNumber.substring(0, tNumber.length - 1)
        this.brand = 'unknown'
        document.getElementById('number').focus()
      }
    },
    backEventCvc() {
      // console.clear()
      console.log('backbbbbbb')
      console.log('this.cvc')
      console.log(this.cvv)
      if (this.cvv === null || this.cvv === '') {
        var tExpiry = this.expiry
        this.expiry = tExpiry.substring(0, tExpiry.length - 1)
        // this.brand = 'unknown'
        document.getElementById('expiry').focus()
      }
    },
    backEventZip() {
      // console.clear()
      console.log('backbbbbbb')
      console.log('this.zip')
      console.log(this.zip)
      if (this.zip === null || this.zip === '') {
        var tCvv = this.cvv
        this.cvv = tCvv.substring(0, tCvv.length - 1)
        // this.brand = 'unknown'
        document.getElementById('cvv').focus()
      }
    },
    validateCcvv(event) {
      var self = this
      let value = this.cvv.replace(/[^0-9\.]+/g, '')
      // if(value.includes('_')){
      this.result.card.cvc = value
      console.log('this.result.card.cvc')
      console.log(this.result.card.cvc)
      // }
      console.log(value.replace(/[^0-9\.]+/g, '').length)
      var input = document.getElementById('cvv')
      var newExpiry = this.expiry
      console.log('input')
      console.log(input.value.replace(/[^0-9\.]+/g, '').length)
      input.addEventListener('keydown', function (event) {
        const key = event.key
        // console.log('key')
        // console.log(key)
        if (
          key === 'Backspace' &&
          input.value.replace(/[^0-9\.]+/g, '').length == 0
        ) {
          // document.getElementById('expiry').focus()
          // this.expiry = this.expiry.slice(0,-1)
          console.log('this.expiry')
          // console.log(self.expiry.slice(0,-1))
          var tExp = self.expiry
          // console.log('self.expiry.length')
          // console.log(self.expiry.length)
          if (self.expiry.length === 5) {
            self.expiry = tExp.substring(0, tExp.length - 1)
          }
          // console.log(self.expiry)
          // console.log(document.getElementById('expiry').value.slice(0,-1))
          window.setTimeout(() => document.getElementById('expiry').focus(), 0)

          console.log('backspace')
          return
        }
      })
      console.log('value')
      console.log(value)
      console.log(value.length)
      if (this.brand == 'amex' && value.length == 4) {
        // document.getElementById('zip').focus()
        window.setTimeout(() => document.getElementById('zip').focus(), 0)
      }

      if (this.brand !== 'amex' && value.length == 3) {
        // document.getElementById('zip').focus()
        window.setTimeout(() => document.getElementById('zip').focus(), 0)
      }
    },
    validateCzip() {
      var self = this
      let value = this.zip.replace(/[^0-9\.]+/g, '')

      this.result.card.postalCode = value
      console.log('this.result.card.postalCode')
      console.log(this.result.card.postalCode)

      console.log(value.replace(/[^0-9\.]+/g, '').length)
      var input = document.getElementById('zip')
      console.log('input')
      console.log(input.value.replace(/[^0-9\.]+/g, '').length)
      input.addEventListener('keydown', function (event) {
        const key = event.key
        // console.log('key')
        // console.log(key)
        // var card = {
        //   number: this.number,
        //   expiry: this.expiry,
        //   cvv: this.cvv,
        //   zip: this.zip,
        //   brand: this.brand,
        // }
        
        // VueCookies.set('card', JSON.stringify(card))
        if (
          key === 'Backspace' &&
          input.value.replace(/[^0-9\.]+/g, '').length == 0
        ) {
          // document.getElementById('cvv').focus()
          var tExp = self.cvv
          // console.log('self.expiry.length')
          // console.log(self.expiry.length)
          if (self.cvv.length >= 3) {
            self.cvv = tExp.substring(0, tExp.length - 1)
          }
          window.setTimeout(() => document.getElementById('cvv').focus(), 0)

          console.log('backspace')
          return
        }
      })
    },
  },
}
</script>
<style scoped>
.icon {
  padding: 10px;
  background: white;
  color: #0ca2ad;
  max-width: 50px;
  text-align: center;
  border: 1px solid #e2e8f0;
  border-left: none;

  /* border: 1px solid; */
}

.valid-field {
  border: 1px solid rgba(63, 243, 63, 0.863);
  background-color: rgba(248, 255, 248, 0.863);
}
.invalid-field {
  border: 1px solid rgba(243, 63, 63, 0.863);
  background-color: rgba(255, 242, 242, 0.863);
}

.input-field-exp {
  width: 50%;
  padding: 10px;
  /* margin-left: 10%; */
  border: 1px solid #e2e8f0;
  /* border-left: none; */
  /* border-right: none; */
  outline: none;
}

.input-field-cvc {
  width: 50%;
  padding: 10px;
  border: 1px solid #e2e8f0;
  border-left: none;
  /* border-right: none; */
  outline: none;
  /* overflow: none; */
}
.input-field-zip {
  width: 100%;
  padding: 10px;
  border: 1px solid #e2e8f0;
  /* border-left: none; */
  outline: none;
}

.input-field:focus {
  outline: none;
}

.input-field-exp {
  width: 50%;
  padding: 10px;
  /* margin-left: 10%; */
  border: 1px solid #e2e8f0;
  /* border-left: none; */
  /* border-right: none; */
  outline: none;
}

.input-field-cvc {
  width: 50%;
  padding: 10px;
  border: 1px solid #e2e8f0;
  border-left: none;
  /* border-right: none; */
  outline: none;
  /* overflow: none; */
}

.input-field-zip {
  width: 100%;
  padding: 10px;
  border: 1px solid #e2e8f0;
  /* border-left: none; */
  outline: none;
}
</style>
