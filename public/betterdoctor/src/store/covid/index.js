const state = () => ({
  questions: [
    {
      question: "First lets start with your name",
      generalQuestion: true,
      fields: [
        {
          label: "First Name",
          placeholder: "First Name",
          name: "firstName",
          type: "text",
          component: "TextField"
        },
        {
          label: "Last Name",
          placeholder: "Last Name",
          name: "lastName",
          type: "text",
          component: "TextField"
        }
      ]
    },
    {
      question: "What’s your shipping address?",
      generalQuestion: true,    
      fields: [
        {
          label: "Address",
          placeholder: "Address",
          name: "address",
          type: "text",
          component: "AddressChange"
        }
      ]
    },
    {
      question: "What's the best phone number to reach you at?",
      generalQuestion: true,    
      fields: [
        {
          label: "Phone Number",
          placeholder: "(111) 111-1111",
          name: "phoneNumber",
          type: "tel",
          component: "TextField"
        }
      ]
    },
    {
      question: "what’s the best email to reach you at?",
      generalQuestion: true,    
      fields: [
        {
          label: "Email",
          placeholder: "Enter Email (user@gmail.com)",
          name: "email",
          type: "email",
          component: "TextField"
        }
      ]
    },
    // {
    //   question:
    //     "To make sure you get the proper dosage, what's your Weight?",
    //   generalQuestion: true,
    //   fields: [
    //     {
    //       label: "Weigth",
    //       placeholder: "Enter Weight",
    //       name: "weight",
    //       type: "number",
    //       component: "Weight" 
    //     }
    //   ]
    // },
    // {
    //   question:
    //     "To make sure you get the proper dosage, what's your Height?",
    //   generalQuestion: true,
    //   fields: [
       
    //     {
    //       label: "Height",
    //       placeholder: "Feet (Less than 10)",
    //       type: "text",
    //       component: "Height"
    //     }
    //   ]
    // },
    // {
    //   question: "What's your Sex?",
    //   noSubmit: false,
    //   fields: [
    //     {
    //       label: "Gender",
    //       placeholder: "",
    //       name: "gender",
    //       type: "check",
    //       component: "Radio",
    //       options: [
    //         {
    //           text: "Male",
    //           value: "male"
    //         },
    //         {
    //           text: "Female",
    //           value: "female"
    //         }
    //       ]
    //     }
    //   ]
    // },
    {
      question: "What's your Date of Birth?",
      generalQuestion: true,    
      fields: [
        {
          label: "Date of Birth",
          placeholder: "mm/dd/yy",
          name: "dateOfBirth",
          type: "date",
          component: "DateFields"
        }
      ]
    }
  ],
  result: {
    form: "covid"
  },
  qas: {}
});

const mutations = {
  SET_QAS: function(state) {
    let qas = state.questions.filter(q => !q.generalQuestion);
    let q = qas.map(q => {
      return q.question;
    });
    let a = qas.map(q => {
      if (state.result[q.fields[0].name] !== undefined) {
        if (q.fields[0].component == "Checkbox") {
          if (state.result[q.fields[0].name][0] == null) {
            return "none of these apply";
          }
        }
        return state.result[q.fields[0].name];
      }
    });
    state.qas = {
      q,
      a
    };
  }
};

const actions = {};

const getters = {};

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
};
