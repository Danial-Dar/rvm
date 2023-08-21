import axios from "axios";
import VueCookies from "vue-cookie";

export default {
  data() {
    return {
      status: 1, // 1 in progress, 2 validating results, 3 bad score ,4  completed,
      score: 0
    };
  },
  methods: {
    async crossCheck() {
      this.$store.commit(this.module + "/SET_QAS", this.result);
      this.$store.commit("SET_RESULT", this.result);
      this.$store.commit("SET_QAS", this.qas);
      let { data } = await axios.get("https://api.ipify.org/?format=json");
      return await axios
        .post(
          "https://verify.vouched.id/api/identity/crosscheck",
          {
            firstName: this.result.firstName[0],
            lastName: this.result.lastName[0],
            email: this.result.email,
            phone: this.result.phoneNumber,
            address: this.result.addressObject,
            ipAddress: data.ip
          },
          {
            headers: {
              "Content-Type": "application/json",
              "X-API-Key": "URebfX#FF7gST3L_uD_d0Lt~B8!8fv"
            }
          }
        )
        .then(
          res => {
            console.log('res')
            console.log(res)
            VueCookies.set('vouched_id' , res.data.id);
            if (res.data.result.confidences.identity > 0.5) {
              this.$router.push({ name: "select-package" });
            } else {
              this.$router.push({ name: "verify-identity" });
            }
            // if (res.data.result.confidences.identity < 5.5) {
            //   this.$router.push({ name: "verify-identity" });
            // } else {
            //   this.$router.push({ name: "select-package" });
            // }
          },
          err => {
            this.$store.commit("SET_RESULT", this.result);
            this.$router.push({ name: "verify-identity" });
          }
        );
    }
  },
  watch: {
    async id(val) {
      let id = parseInt(val, 10);
      if (id > this.questions.length) {
        this.status = 2;
        await this.crossCheck();
      }
    }
  }
};
