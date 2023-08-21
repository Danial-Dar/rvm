<template>
  <div>
    <stripe-element-card
      ref="elementRef"
      :pk="publishableKey"
      @token="tokenCreated"
      id="cardEl"  
      @forminput="console.log('key')"
    />
  </div>
</template>

<script>
import { StripeElementCard } from '@vue-stripe/vue-stripe';
export default {
  components: {
    StripeElementCard,
  },
  data () {
    this.publishableKey = 'sdsdsddssd';
    return {
      token: null,
      card: {},
    };
  },
  method: {
      checkInput(){
console.log('input')
      },
    testCard () {
console.log('input')
      
      // this will trigger the process
    //   this.$refs.elementRef.submit();
    },
    tokenCreated (token) {
      console.log('sssss');
      // handle the token
      // send it to your server
    },
  }
};
</script>