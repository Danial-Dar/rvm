const state = () => ({
  questions: [
    {
      question: "What’s your first and last name?",
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
      question: "What's the best phone number to reach you at?",
      generalQuestion: true,
      fields: [
        {
          label: "Phone number",
          placeholder: "(111) 111-1111",
          name: "phoneNumber",
          type: "tel",
          component: "TextField"
        }
      ]
    },
    {
      question: "What’s the best email to reach you at?",
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
    {
      question:
        "What's your address? This is where your medicine will be delivered if prescribed",
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
      question: "Are you allergic to any medications?",
      type: "button",
      noSubmit: false,
      fields: [
        {
          label: "",
          placeholder: "",
          name: "areYouAllergicToAnyMedications",
          type: "button",
          component: "Buttons",
          options: [
            {
              text: "Yes",
              value: "Yes",
              action: "popup",
              fields: [
                {
                  lable: "",
                  placeholder: "",
                  name: "whyYouAllergicToMedications",
                  component: "AutoComplete"
                }
              ]
            },
            {
              text: "No",
              value: "No",
              action: "input"
            }
          ]
        }
      ]
    },
    {
      question: "Are you currently taking any medications or vitamins?",
      type: "button",
      noSubmit: false,
      fields: [
        {
          label: "",
          placeholder: "",
          name: "areYouTakingAnyMedications",
          type: "button",
          component: "Buttons",
          options: [
            {
              text: "Yes",
              value: "Yes",
              action: "popup",
              fields: [
                {
                  lable: "",
                  placeholder: "",
                  name: "whichMedicationsOrVitamins",
                  component: "AutoComplete"
                }
              ]
            },
            {
              text: "No",
              value: "No",
              action: "input"
            }
          ]
        }
      ]
    },
    {
      question:
        "To make sure you get the proper dosage, what's your Weight?",
      generalQuestion: true,    
      fields: [
        {
          label: "Weigth",
          placeholder: "Enter weight",
          name: "weight",
          type: "number",
          component: "Weight"
        }
      ]
    },
    {
      question:
        "To make sure you get the proper dosage, what's your Height?",
      generalQuestion: true,    
      fields: [
        
        {
          label: "Height",
          placeholder: "Feet (Less than 10)",
          type: "text",
          component: "Height"
        }
      ]
    },
    {
      question:
        "What's your Date of Birth? We only assist patients over 18 years of age.",
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
    },
    // {
    //   question: "What's your Gender?",
    //   noSubmit: false,
    //   fields: [
    //     {
    //       label: "",
    //       placeholder: "",
    //       name: "gender",
    //       type: "check",
    //       component: "Radio",
    //       options: [
    //         {
    //           text: 'Male',
    //           value: 'male'
    //         },
    //         {
    //           text: 'Female',
    //           value: 'female'
    //         }
    //       ]
    //     }
    //   ]
    // },

    {
      question: "Have you been diagnosed with Herpes?",
      type: "button",
      noSubmit: false,
      fields: [
        {
          label: "",
          placeholder: "",
          name: "haveYouEverDiagnosedWithHerpes",
          type: "button",
          component: "Buttons",
          options: [
            {
              text: "Yes",
              value: "Yes",
              action: "input"
            },
            {
              text: "No",
              value: "No",
              action: "failed",
              failedText:
                "Unfortunately, we’re only able to provide Herpes treatments to those who have been diagnosed with Herpes."
            }
          ]
        }
      ]
    },

    {
      question: "Are you currently experiencing an outbreak?",
      type: "button",
      noSubmit: false,
      fields: [
        {
          label: "",
          placeholder: "",
          name: "currentlyExperiencingOutbreak",
          type: "button",
          component: "Buttons",
          options: [
            {
              text: "Yes",
              value: "Yes",
              action: "input"
            },
            {
              text: "No",
              value: "No",
              action: "input"
            }
          ]
        }
      ]
    },
    {
      question: "Have you had a cold sore or herpes outbreak in the past?",
      type: "button",
      noSubmit: false,
      fields: [
        {
          label: "",
          placeholder: "",
          name: "coldSoreHerpesOutbreak",
          type: "button",
          component: "Buttons",
          options: [
            {
              text: "Yes",
              value: "Yes",
              action: "input"
            },
            {
              text: "No",
              value: "No",
              action: "input"
            }
          ]
        }
      ]
    }
  ],
  result: {
    form: "Herpes"
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
        if( (q.fields[0].name === 'areYouAllergicToAnyMedications' && state.result[q.fields[0].name] !== 'No') || (q.fields[0].name === 'areYouTakingAnyMedications' && state.result[q.fields[0].name] !== 'No')){
          console.log('a', q.fields[0].name)
          return state.result[q.fields[0].options[0].fields[0].name]
        }
        else{
          console.log('b', q.fields[0].name)

          return state.result[q.fields[0].name];

        }
        // return state.result[q.fields[0].name];
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
